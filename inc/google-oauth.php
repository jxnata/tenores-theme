<?php

/**
 * Google OAuth Login Integration
 *
 * Implementa login e registro via Google OAuth para WordPress/WooCommerce.
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Inicializa o módulo Google OAuth.
 */
function tenores_google_oauth_init(): void
{
	// Registrar endpoints REST API
	add_action('rest_api_init', 'tenores_google_oauth_register_routes');
}

/**
 * Registra as rotas REST API para OAuth.
 */
function tenores_google_oauth_register_routes(): void
{
	register_rest_route('tenores/v1', '/google-oauth/authorize', [
		'methods'             => 'GET',
		'callback'            => 'tenores_google_oauth_authorize',
		'permission_callback' => '__return_true',
	]);

	register_rest_route('tenores/v1', '/google-oauth/callback', [
		'methods'             => 'GET',
		'callback'            => 'tenores_google_oauth_callback',
		'permission_callback' => '__return_true',
	]);
}

/**
 * Gera e retorna a URI de redirecionamento OAuth.
 */
function tenores_google_oauth_get_redirect_uri(): string
{
	return rest_url('tenores/v1/google-oauth/callback');
}

/**
 * Gera um token state único para proteção CSRF.
 */
function tenores_google_oauth_generate_state_token(): string
{
	$token = wp_generate_password(32, false);

	// Armazenar token em transiente com expiração de 10 minutos
	set_transient('tenores_google_oauth_state_' . $token, time(), 600);

	return $token;
}

/**
 * Valida um token state.
 */
function tenores_google_oauth_validate_state_token(string $token): bool
{
	$stored = get_transient('tenores_google_oauth_state_' . $token);

	if ($stored === false) {
		return false;
	}

	// Deletar token após uso (one-time use)
	delete_transient('tenores_google_oauth_state_' . $token);

	return true;
}

/**
 * Endpoint para iniciar o fluxo OAuth.
 * Redireciona o usuário para a página de autorização do Google.
 */
function tenores_google_oauth_authorize(WP_REST_Request $request): WP_REST_Response
{
	$settings = tenores_get_theme_settings();

	// Verificar se OAuth está habilitado
	if (empty($settings['google_oauth_enabled']) || empty($settings['google_oauth_client_id'])) {
		return new WP_REST_Response([
			'error' => __('Login com Google não está configurado.', 'tenores'),
		], 400);
	}

	// Gerar state token para proteção CSRF
	$state = tenores_google_oauth_generate_state_token();

	// Parâmetros da URL de autorização
	$redirect_uri = tenores_google_oauth_get_redirect_uri();
	$client_id    = $settings['google_oauth_client_id'];
	$scope        = 'openid email profile';

	$auth_url = add_query_arg([
		'client_id'     => $client_id,
		'redirect_uri'  => urlencode($redirect_uri),
		'response_type' => 'code',
		'scope'         => urlencode($scope),
		'state'         => $state,
		'access_type'   => 'offline',
		'prompt'         => 'consent',
	], 'https://accounts.google.com/o/oauth2/v2/auth');

	// Redirecionar para Google
	wp_redirect($auth_url);
	exit;
}

/**
 * Endpoint callback que recebe o código de autorização do Google.
 */
function tenores_google_oauth_callback(WP_REST_Request $request): void
{
	$settings = tenores_get_theme_settings();

	// Verificar se OAuth está habilitado
	if (empty($settings['google_oauth_enabled']) || empty($settings['google_oauth_client_id']) || empty($settings['google_oauth_client_secret'])) {
		wp_redirect(add_query_arg('oauth_error', 'not_configured', wc_get_page_permalink('myaccount')));
		exit;
	}

	// Obter parâmetros da URL
	$code  = $request->get_param('code');
	$state = $request->get_param('state');
	$error = $request->get_param('error');

	// Verificar se houve erro no Google
	if (!empty($error)) {
		wp_redirect(add_query_arg('oauth_error', 'user_denied', wc_get_page_permalink('myaccount')));
		exit;
	}

	// Validar state token (proteção CSRF)
	if (empty($state) || !tenores_google_oauth_validate_state_token($state)) {
		wp_redirect(add_query_arg('oauth_error', 'invalid_state', wc_get_page_permalink('myaccount')));
		exit;
	}

	// Validar código de autorização
	if (empty($code)) {
		wp_redirect(add_query_arg('oauth_error', 'no_code', wc_get_page_permalink('myaccount')));
		exit;
	}

	// Trocar código por access token
	$token_data = tenores_google_oauth_get_token($code, $settings);

	if (is_wp_error($token_data)) {
		wp_redirect(add_query_arg('oauth_error', 'token_exchange_failed', wc_get_page_permalink('myaccount')));
		exit;
	}

	// Obter dados do usuário do Google
	$user_data = tenores_google_oauth_get_user_data($token_data['access_token']);

	if (is_wp_error($user_data)) {
		wp_redirect(add_query_arg('oauth_error', 'user_data_failed', wc_get_page_permalink('myaccount')));
		exit;
	}

	// Criar ou autenticar usuário
	$user_result = tenores_google_oauth_create_or_login_user($user_data);

	if (is_wp_error($user_result)) {
		wp_redirect(add_query_arg('oauth_error', 'user_creation_failed', wc_get_page_permalink('myaccount')));
		exit;
	}

	// Redirecionar para página de conta
	wp_redirect(wc_get_page_permalink('myaccount'));
	exit;
}

/**
 * Troca o código de autorização por um access token.
 */
function tenores_google_oauth_get_token(string $code, array $settings): array|WP_Error
{
	$redirect_uri = tenores_google_oauth_get_redirect_uri();
	$client_id    = $settings['google_oauth_client_id'];
	$client_secret = $settings['google_oauth_client_secret'];

	$token_url = 'https://oauth2.googleapis.com/token';

	$body = [
		'code'          => $code,
		'client_id'     => $client_id,
		'client_secret' => $client_secret,
		'redirect_uri'  => $redirect_uri,
		'grant_type'    => 'authorization_code',
	];

	$response = wp_remote_post($token_url, [
		'body'    => $body,
		'timeout' => 30,
	]);

	if (is_wp_error($response)) {
		return $response;
	}

	$response_code = wp_remote_retrieve_response_code($response);
	$response_body = wp_remote_retrieve_body($response);
	$data          = json_decode($response_body, true);

	if ($response_code !== 200 || empty($data['access_token'])) {
		return new WP_Error('token_exchange_failed', __('Falha ao trocar código por token.', 'tenores'), $data);
	}

	return $data;
}

/**
 * Obtém os dados do usuário do Google usando o access token.
 */
function tenores_google_oauth_get_user_data(string $access_token): array|WP_Error
{
	$user_info_url = 'https://www.googleapis.com/oauth2/v2/userinfo';

	$response = wp_remote_get($user_info_url, [
		'headers' => [
			'Authorization' => 'Bearer ' . $access_token,
		],
		'timeout' => 30,
	]);

	if (is_wp_error($response)) {
		return $response;
	}

	$response_code = wp_remote_retrieve_response_code($response);
	$response_body = wp_remote_retrieve_body($response);
	$data          = json_decode($response_body, true);

	if ($response_code !== 200 || empty($data['email'])) {
		return new WP_Error('user_data_failed', __('Falha ao obter dados do usuário.', 'tenores'), $data);
	}

	// Verificar se o email está verificado
	if (empty($data['verified_email']) || !$data['verified_email']) {
		return new WP_Error('email_not_verified', __('Email do Google não está verificado.', 'tenores'));
	}

	return $data;
}

/**
 * Cria um novo usuário ou autentica um usuário existente com dados do Google.
 */
function tenores_google_oauth_create_or_login_user(array $user_data): int|WP_Error
{
	$email      = sanitize_email($user_data['email']);
	$first_name = isset($user_data['given_name']) ? sanitize_text_field($user_data['given_name']) : '';
	$last_name  = isset($user_data['family_name']) ? sanitize_text_field($user_data['family_name']) : '';
	$picture    = isset($user_data['picture']) ? esc_url_raw($user_data['picture']) : '';

	// Verificar se usuário já existe pelo email
	$user = get_user_by('email', $email);

	if ($user) {
		// Usuário existe, fazer login
		wp_set_current_user($user->ID);
		wp_set_auth_cookie($user->ID, true);

		// Atualizar meta do usuário
		update_user_meta($user->ID, '_google_oauth_user', true);
		if (!empty($picture)) {
			update_user_meta($user->ID, '_google_oauth_picture', $picture);
		}

		// Atualizar nome se necessário
		if (!empty($first_name)) {
			update_user_meta($user->ID, 'first_name', $first_name);
			update_user_meta($user->ID, 'billing_first_name', $first_name);
			update_user_meta($user->ID, 'shipping_first_name', $first_name);
		}
		if (!empty($last_name)) {
			update_user_meta($user->ID, 'last_name', $last_name);
			update_user_meta($user->ID, 'billing_last_name', $last_name);
			update_user_meta($user->ID, 'shipping_last_name', $last_name);
		}

		// Trigger WooCommerce login
		if (class_exists('WooCommerce')) {
			wc_set_customer_auth_cookie($user->ID);
		}

		return $user->ID;
	}

	// Criar novo usuário
	// Gerar username a partir do email
	$username = sanitize_user(current(explode('@', $email)), true);

	// Garantir que username é único
	$original_username = $username;
	$counter           = 1;
	while (username_exists($username)) {
		$username = $original_username . $counter;
		$counter++;
	}

	// Gerar senha aleatória segura
	$password = wp_generate_password(24, true, true);

	// Criar usuário
	$user_id = wp_create_user($username, $password, $email);

	if (is_wp_error($user_id)) {
		return $user_id;
	}

	// Atualizar dados do usuário
	wp_update_user([
		'ID'         => $user_id,
		'first_name' => $first_name,
		'last_name'  => $last_name,
	]);

	// Meta do usuário
	update_user_meta($user_id, '_google_oauth_user', true);
	if (!empty($picture)) {
		update_user_meta($user_id, '_google_oauth_picture', $picture);
	}

	// WooCommerce customer data
	if (class_exists('WooCommerce')) {
		update_user_meta($user_id, 'billing_first_name', $first_name);
		update_user_meta($user_id, 'billing_last_name', $last_name);
		update_user_meta($user_id, 'billing_email', $email);
		update_user_meta($user_id, 'shipping_first_name', $first_name);
		update_user_meta($user_id, 'shipping_last_name', $last_name);
	}

	// Fazer login automaticamente
	wp_set_current_user($user_id);
	wp_set_auth_cookie($user_id, true);

	// Trigger WooCommerce login
	if (class_exists('WooCommerce')) {
		wc_set_customer_auth_cookie($user_id);
	}

	// Trigger hook de criação de customer do WooCommerce
	if (class_exists('WooCommerce')) {
		do_action('woocommerce_created_customer', $user_id, [], $password);
	}

	return $user_id;
}

// Inicializar módulo
tenores_google_oauth_init();
