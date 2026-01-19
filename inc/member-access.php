<?php

/**
 * Sistema de controle de acesso para conteúdo exclusivo de membros.
 *
 * @package Tenores
 */

if (!defined('ABSPATH')) {
	exit;
}

use Automattic\WooCommerce\Utilities\OrderUtil;

// Constantes para níveis de acesso
const TENORES_ACCESS_PUBLIC = 'public';
const TENORES_ACCESS_MEMBERS = 'members';
const TENORES_ACCESS_SUBSCRIBERS = 'subscribers';

// Compatibilidade com valores antigos
const TENORES_ACCESS_PURCHASERS = 'purchasers';

// Meta key para armazenar nível de acesso
const TENORES_CONTENT_ACCESS_META = '_tenores_content_access';

/**
 * Retorna o nível de acesso de um conteúdo.
 *
 * @param int $post_id ID do post/página/produto
 * @return string Nível de acesso (public, members, subscribers)
 */
function tenores_get_content_access(int $post_id): string
{
	$access = get_post_meta($post_id, TENORES_CONTENT_ACCESS_META, true);

	if (empty($access)) {
		return TENORES_ACCESS_PUBLIC;
	}

	// Compatibilidade com valores antigos
	if ($access === TENORES_ACCESS_PURCHASERS) {
		$access = TENORES_ACCESS_SUBSCRIBERS;
	}

	$valid_access = [TENORES_ACCESS_PUBLIC, TENORES_ACCESS_MEMBERS, TENORES_ACCESS_SUBSCRIBERS];

	return in_array($access, $valid_access, true) ? $access : TENORES_ACCESS_PUBLIC;
}

/**
 * Verifica se um usuário tem uma assinatura ativa.
 * Usa o plugin WPSwings Subscriptions for WooCommerce.
 *
 * @param int $user_id ID do usuário
 * @param int|null $product_id ID do produto de assinatura específico (opcional)
 * @return bool True se o usuário tem uma assinatura ativa
 */
function tenores_user_has_active_subscription(int $user_id, ?int $product_id = null): bool
{
	if (!class_exists('WooCommerce')) {
		return false;
	}

	if (! function_exists('wps_sfw_get_meta_data')) {
		return false;
	}

	$is_hpos = OrderUtil::custom_orders_table_usage_is_enabled();

	if ($is_hpos) {
		$args = array(
			'return' => 'ids',
			'type'   => 'wps_subscriptions',
			'limit'  => -1,
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key'   => 'wps_customer_id',
					'value' => $user_id,
				),
				array(
					'key'   => 'wps_subscription_status',
					'value' => 'active',
				),
			),
		);
		$subscriptions = wc_get_orders($args);
	} else {
		$args = array(
			'numberposts' => -1,
			'post_type'   => 'wps_subscriptions',
			'post_status' => 'wc-wps_renewal',
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key'   => 'wps_customer_id',
					'value' => $user_id,
				),
				array(
					'key'   => 'wps_subscription_status',
					'value' => 'active',
				),
			),
		);
		$subscriptions = get_posts($args);
	}

	return ! empty($subscriptions);
}

/**
 * Verifica se um usuário tem compras no WooCommerce (função mantida para compatibilidade).
 *
 * @param int $user_id ID do usuário
 * @return bool True se o usuário tem pelo menos uma compra concluída
 * @deprecated Use tenores_user_has_active_subscription() instead
 */
function tenores_user_has_purchases(int $user_id): bool
{
	if (!class_exists('WooCommerce')) {
		return false;
	}

	if (function_exists('wc_get_customer_order_count')) {
		$order_count = wc_get_customer_order_count($user_id);
		if ($order_count > 0) {
			return true;
		}
	}

	$orders = wc_get_orders([
		'customer_id' => $user_id,
		'status'      => 'wc-completed',
		'limit'       => 1,
		'return'      => 'ids',
	]);

	return !empty($orders);
}

/**
 * Verifica se um usuário pode acessar um conteúdo.
 *
 * @param int $post_id ID do post/página/produto
 * @param int|null $user_id ID do usuário (null para usuário atual)
 * @return bool True se o usuário pode acessar o conteúdo
 */
function tenores_user_can_access_content(int $post_id, ?int $user_id = null): bool
{
	$access_level = tenores_get_content_access($post_id);

	// Conteúdo público sempre acessível
	if ($access_level === TENORES_ACCESS_PUBLIC) {
		return true;
	}

	// Se não especificou usuário, usar o atual
	if ($user_id === null) {
		$user_id = get_current_user_id();
	}

	// Se não está logado, não pode acessar conteúdo restrito
	if (!$user_id || !is_user_logged_in()) {
		return false;
	}

	// Apenas membros: usuário logado pode acessar
	if ($access_level === TENORES_ACCESS_MEMBERS) {
		return true;
	}

	// Apenas assinantes: precisa ter uma assinatura ativa
	if ($access_level === TENORES_ACCESS_SUBSCRIBERS) {
		return tenores_user_has_active_subscription($user_id);
	}

	return false;
}

/**
 * Retorna o motivo pelo qual o usuário não pode acessar o conteúdo.
 *
 * @param int $post_id ID do post/página/produto
 * @param int|null $user_id ID do usuário (null para usuário atual)
 * @return string Motivo: 'none' (pode acessar), 'not_logged_in', 'not_member', 'not_subscriber'
 */
function tenores_get_access_denial_reason(int $post_id, ?int $user_id = null): string
{
	$access_level = tenores_get_content_access($post_id);

	// Conteúdo público sempre acessível
	if ($access_level === TENORES_ACCESS_PUBLIC) {
		return 'none';
	}

	// Se não especificou usuário, usar o atual
	if ($user_id === null) {
		$user_id = get_current_user_id();
	}

	// Se não está logado
	if (!$user_id || !is_user_logged_in()) {
		return 'not_logged_in';
	}

	// Apenas membros: usuário logado pode acessar
	if ($access_level === TENORES_ACCESS_MEMBERS) {
		return 'none';
	}

	// Apenas assinantes: verifica se tem assinatura ativa
	if ($access_level === TENORES_ACCESS_SUBSCRIBERS) {
		if (tenores_user_has_active_subscription($user_id)) {
			return 'none';
		}
		return 'not_subscriber';
	}

	return 'none';
}

/**
 * Adiciona meta boxes para controle de acesso em posts e páginas.
 */
function tenores_add_access_meta_boxes(): void
{
	$post_types = ['post', 'page'];

	foreach ($post_types as $post_type) {
		add_meta_box(
			'tenores_content_access',
			__('Controle de Acesso', 'tenores'),
			'tenores_render_access_meta_box',
			$post_type,
			'side',
			'default'
		);
	}
}

add_action('add_meta_boxes', 'tenores_add_access_meta_boxes');

/**
 * Renderiza o meta box de controle de acesso.
 *
 * @param WP_Post $post Objeto do post
 */
function tenores_render_access_meta_box(WP_Post $post): void
{
	wp_nonce_field('tenores_save_access_meta', 'tenores_access_meta_nonce');

	$current_access = tenores_get_content_access($post->ID);

	$options = [
		TENORES_ACCESS_PUBLIC      => __('Acesso livre', 'tenores'),
		TENORES_ACCESS_MEMBERS     => __('Apenas Usuários Registrados', 'tenores'),
		TENORES_ACCESS_SUBSCRIBERS => __('Apenas Assinantes', 'tenores'),
	];
?>
	<p>
		<label for="tenores_content_access_field" class="screen-reader-text">
			<?php esc_html_e('Nível de Acesso', 'tenores'); ?>
		</label>
		<select
			id="tenores_content_access_field"
			name="tenores_content_access_field"
			class="widefat">
			<?php foreach ($options as $value => $label) : ?>
				<option value="<?php echo esc_attr($value); ?>" <?php selected($current_access, $value); ?>>
					<?php echo esc_html($label); ?>
				</option>
			<?php endforeach; ?>
		</select>
	</p>
	<p class="description">
		<?php esc_html_e('Defina quem pode acessar este conteúdo. Assinantes são usuários com uma assinatura ativa do produto configurado nas opções do tema.', 'tenores'); ?>
	</p>
<?php
}

/**
 * Salva o meta value de controle de acesso.
 *
 * @param int $post_id ID do post
 */
function tenores_save_access_meta(int $post_id): void
{
	// Verificar nonce
	if (!isset($_POST['tenores_access_meta_nonce']) || !wp_verify_nonce($_POST['tenores_access_meta_nonce'], 'tenores_save_access_meta')) {
		return;
	}

	// Verificar autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	// Verificar permissões
	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	// Salvar valor
	if (isset($_POST['tenores_content_access_field'])) {
		$access = sanitize_text_field($_POST['tenores_content_access_field']);
		$valid_access = [TENORES_ACCESS_PUBLIC, TENORES_ACCESS_MEMBERS, TENORES_ACCESS_SUBSCRIBERS];

		if (in_array($access, $valid_access, true)) {
			update_post_meta($post_id, TENORES_CONTENT_ACCESS_META, $access);
		}
	}
}

add_action('save_post', 'tenores_save_access_meta');
add_action('save_page', 'tenores_save_access_meta');

/**
 * Adiciona campo de controle de acesso para produtos WooCommerce.
 */
function tenores_add_product_access_field(): void
{
	if (!class_exists('WooCommerce')) {
		return;
	}

	global $post;

	$current_access = tenores_get_content_access($post->ID);

	$options = [
		TENORES_ACCESS_PUBLIC      => __('Público - Acesso livre', 'tenores'),
		TENORES_ACCESS_MEMBERS     => __('Apenas Usuários Registrados', 'tenores'),
		TENORES_ACCESS_SUBSCRIBERS => __('Apenas Assinantes', 'tenores'),
	];

	echo '<div class="options_group">';

	woocommerce_wp_select([
		'id'          => 'tenores_content_access_field',
		'label'       => __('Controle de Acesso', 'tenores'),
		'options'     => $options,
		'value'       => $current_access,
		'desc_tip'    => true,
		'description' => __('Defina quem pode acessar este produto. Assinantes são usuários com assinatura ativa.', 'tenores'),
	]);

	echo '</div>';
}

add_action('woocommerce_product_options_general_product_data', 'tenores_add_product_access_field');

/**
 * Salva o campo de controle de acesso para produtos WooCommerce.
 *
 * @param int $post_id ID do produto
 */
function tenores_save_product_access_field(int $post_id): void
{
	if (!class_exists('WooCommerce')) {
		return;
	}

	if (isset($_POST['tenores_content_access_field'])) {
		$access = sanitize_text_field($_POST['tenores_content_access_field']);
		$valid_access = [TENORES_ACCESS_PUBLIC, TENORES_ACCESS_MEMBERS, TENORES_ACCESS_SUBSCRIBERS];

		if (in_array($access, $valid_access, true)) {
			update_post_meta($post_id, TENORES_CONTENT_ACCESS_META, $access);
		}
	}
}

add_action('woocommerce_process_product_meta', 'tenores_save_product_access_field');

/**
 * Filtra a query principal para exibir apenas posts públicos no blog.
 *
 * @param WP_Query $query Query do WordPress
 */
function tenores_filter_public_posts_only(WP_Query $query): void
{
	// Aplicar apenas na query principal e não no admin
	if (is_admin() || !$query->is_main_query()) {
		return;
	}

	// Não aplicar em cursos do Masteriyo - eles devem aparecer na listagem independente do controle de acesso
	$post_type = $query->get('post_type');

	// Verifica se é um archive de cursos do Masteriyo
	if (is_post_type_archive('mto-course')) {
		return;
	}

	// Verifica se o post_type da query é mto-course
	if ($post_type === 'mto-course' || (is_array($post_type) && in_array('mto-course', $post_type, true))) {
		return;
	}

	// Aplicar apenas em páginas de blog (home, archive, category, tag, etc.)
	if (!is_home() && !is_archive() && !is_category() && !is_tag() && !is_author() && !is_search()) {
		return;
	}

	// Não aplicar em single posts
	if (is_singular()) {
		return;
	}

	// Meta query para incluir apenas posts públicos ou sem meta definida
	$meta_query = $query->get('meta_query');
	if (!is_array($meta_query)) {
		$meta_query = [];
	}

	$meta_query[] = [
		'relation' => 'OR',
		[
			'key'     => TENORES_CONTENT_ACCESS_META,
			'value'   => TENORES_ACCESS_PUBLIC,
			'compare' => '=',
		],
		[
			'key'     => TENORES_CONTENT_ACCESS_META,
			'compare' => 'NOT EXISTS',
		],
	];

	$query->set('meta_query', $meta_query);
}

add_action('pre_get_posts', 'tenores_filter_public_posts_only');
