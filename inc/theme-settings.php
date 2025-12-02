<?php

/**
 * Configurações do tema Tenores.
 */

const TENORES_SETTINGS_OPTION = 'tenores_theme_settings';

function tenores_get_theme_settings(): array
{
	$settings = get_option(TENORES_SETTINGS_OPTION, []);

	if (!is_array($settings)) {
		$settings = [];
	}

	$defaults = [
		'banner'            => '',
		'headline'          => '',
		'contact_email'     => '',
		'contact_phone'     => '',
		'cto_url'           => '',
		'social_linkedin'   => '',
		'social_facebook'   => '',
		'social_instagram'  => '',
		'social_youtube'    => '',
		'webinar_enabled'   => 0,
		'webinar_date'      => '',
		'webinar_url'       => '',
	];

	return array_merge($defaults, $settings);
}

function tenores_register_theme_settings(): void
{
	register_setting(
		'tenores_theme_settings_group',
		TENORES_SETTINGS_OPTION,
		[
			'type'              => 'array',
			'sanitize_callback' => 'tenores_sanitize_theme_settings',
		]
	);

	add_settings_section(
		'tenores_theme_main_section',
		__('Configurações gerais', 'tenores'),
		'__return_false',
		'tenores_theme_settings'
	);

	add_settings_field(
		'tenores_banner',
		__('Banner', 'tenores'),
		'tenores_render_text_field',
		'tenores_theme_settings',
		'tenores_theme_main_section',
		[
			'key'         => 'banner',
			'type'        => 'text',
			'placeholder' => __('Texto do banner principal', 'tenores'),
		]
	);

	add_settings_field(
		'tenores_headline',
		__('Headline', 'tenores'),
		'tenores_render_headline_field',
		'tenores_theme_settings',
		'tenores_theme_main_section',
		[
			'key'         => 'headline',
			'placeholder' => __('Headline principal da página inicial', 'tenores'),
		]
	);

	add_settings_field(
		'tenores_contact_email',
		__('Email de contato', 'tenores'),
		'tenores_render_text_field',
		'tenores_theme_settings',
		'tenores_theme_main_section',
		[
			'key'         => 'contact_email',
			'type'        => 'email',
			'placeholder' => 'contato@exemplo.com',
		]
	);

	add_settings_field(
		'tenores_contact_phone',
		__('Telefone de contato', 'tenores'),
		'tenores_render_text_field',
		'tenores_theme_settings',
		'tenores_theme_main_section',
		[
			'key'         => 'contact_phone',
			'type'        => 'text',
			'placeholder' => '+55 (11) 99999-9999',
		]
	);

	add_settings_field(
		'tenores_cto_url',
		__('URL do CTA', 'tenores'),
		'tenores_render_text_field',
		'tenores_theme_settings',
		'tenores_theme_main_section',
		[
			'key'         => 'cto_url',
			'type'        => 'url',
			'placeholder' => 'https://exemplo.com/inscricao',
		]
	);

	add_settings_field(
		'tenores_social_linkedin',
		__('URL do LinkedIn', 'tenores'),
		'tenores_render_text_field',
		'tenores_theme_settings',
		'tenores_theme_main_section',
		[
			'key'         => 'social_linkedin',
			'type'        => 'url',
			'placeholder' => 'https://linkedin.com/in/seu-perfil',
		]
	);

	add_settings_field(
		'tenores_social_facebook',
		__('URL do Facebook', 'tenores'),
		'tenores_render_text_field',
		'tenores_theme_settings',
		'tenores_theme_main_section',
		[
			'key'         => 'social_facebook',
			'type'        => 'url',
			'placeholder' => 'https://facebook.com/sua-pagina',
		]
	);

	add_settings_field(
		'tenores_social_instagram',
		__('URL do Instagram', 'tenores'),
		'tenores_render_text_field',
		'tenores_theme_settings',
		'tenores_theme_main_section',
		[
			'key'         => 'social_instagram',
			'type'        => 'url',
			'placeholder' => 'https://instagram.com/seu-perfil',
		]
	);

	add_settings_field(
		'tenores_social_youtube',
		__('URL do YouTube', 'tenores'),
		'tenores_render_text_field',
		'tenores_theme_settings',
		'tenores_theme_main_section',
		[
			'key'         => 'social_youtube',
			'type'        => 'url',
			'placeholder' => 'https://youtube.com/seu-canal',
		]
	);

	add_settings_section(
		'tenores_theme_webinar_section',
		__('Webinar', 'tenores'),
		'__return_false',
		'tenores_theme_settings'
	);

	add_settings_field(
		'tenores_webinar_enabled',
		__('Mostrar webinar', 'tenores'),
		'tenores_render_checkbox_field',
		'tenores_theme_settings',
		'tenores_theme_webinar_section',
		[
			'key' => 'webinar_enabled',
		]
	);

	add_settings_field(
		'tenores_webinar_date',
		__('Data do webinar', 'tenores'),
		'tenores_render_text_field',
		'tenores_theme_settings',
		'tenores_theme_webinar_section',
		[
			'key'         => 'webinar_date',
			'type'        => 'date',
			'placeholder' => '',
		]
	);

	add_settings_field(
		'tenores_webinar_url',
		__('URL do webinar', 'tenores'),
		'tenores_render_text_field',
		'tenores_theme_settings',
		'tenores_theme_webinar_section',
		[
			'key'         => 'webinar_url',
			'type'        => 'url',
			'placeholder' => 'https://exemplo.com/webinar',
		]
	);
}

add_action('admin_init', 'tenores_register_theme_settings');

function tenores_add_theme_settings_page(): void
{
	add_theme_page(
		__('Configurações do Tema', 'tenores'),
		__('Configurações do Tema', 'tenores'),
		'manage_options',
		'tenores-theme-settings',
		'tenores_render_theme_settings_page'
	);
}

add_action('admin_menu', 'tenores_add_theme_settings_page');

function tenores_render_theme_settings_page(): void
{
	if (!current_user_can('manage_options')) {
		return;
	}

	$settings = tenores_get_theme_settings();
?>
	<div class="wrap">
		<h1><?php esc_html_e('Configurações do Tema', 'tenores'); ?></h1>

		<form action="options.php" method="post">
			<?php
			settings_fields('tenores_theme_settings_group');
			do_settings_sections('tenores_theme_settings');
			submit_button();
			?>
		</form>
	</div>
<?php
}

function tenores_render_text_field(array $args): void
{
	$settings    = tenores_get_theme_settings();
	$key         = $args['key'] ?? '';
	$type        = $args['type'] ?? 'text';
	$placeholder = $args['placeholder'] ?? '';
	$value       = isset($settings[$key]) ? (string) $settings[$key] : '';

	printf(
		'<input type="%1$s" id="%2$s" name="%3$s[%2$s]" value="%4$s" class="regular-text" placeholder="%5$s" />',
		esc_attr($type),
		esc_attr($key),
		esc_attr(TENORES_SETTINGS_OPTION),
		esc_attr($value),
		esc_attr($placeholder)
	);
}

function tenores_render_textarea_field(array $args): void
{
	$settings    = tenores_get_theme_settings();
	$key         = $args['key'] ?? '';
	$placeholder = $args['placeholder'] ?? '';
	$value       = isset($settings[$key]) ? (string) $settings[$key] : '';

	printf(
		'<textarea id="%1$s" name="%2$s[%1$s]" rows="4" class="large-text" placeholder="%3$s">%4$s</textarea>',
		esc_attr($key),
		esc_attr(TENORES_SETTINGS_OPTION),
		esc_attr($placeholder),
		esc_textarea($value)
	);
}

function tenores_render_headline_field(array $args): void
{
	$settings    = tenores_get_theme_settings();
	$key         = $args['key'] ?? '';
	$placeholder = $args['placeholder'] ?? '';
	$value       = isset($settings[$key]) ? (string) $settings[$key] : '';

	printf(
		'<textarea id="%1$s" name="%2$s[%1$s]" rows="4" class="large-text" placeholder="%3$s">%4$s</textarea>',
		esc_attr($key),
		esc_attr(TENORES_SETTINGS_OPTION),
		esc_attr($placeholder),
		esc_textarea($value)
	);
?>
	<p class="description">
		<?php esc_html_e('Você pode usar tags HTML para formatar o texto, como:', 'tenores'); ?>
		<code>&lt;strong&gt;</code>, <code>&lt;em&gt;</code>, <code>&lt;span&gt;</code>, etc.
		<?php esc_html_e('Exemplo:', 'tenores'); ?>
		<code>Fala Autêntica &lt;strong class="text-primary"&gt;Resultados&lt;/strong&gt; Reais</code>
	</p>
<?php
}

function tenores_render_checkbox_field(array $args): void
{
	$settings = tenores_get_theme_settings();
	$key      = $args['key'] ?? '';
	$checked  = !empty($settings[$key]) ? 'checked' : '';

	printf(
		'<label><input type="checkbox" id="%1$s" name="%2$s[%1$s]" value="1" %3$s /> %4$s</label>',
		esc_attr($key),
		esc_attr(TENORES_SETTINGS_OPTION),
		$checked,
		esc_html__('Ativar', 'tenores')
	);
}

function tenores_sanitize_theme_settings($input): array
{
	if (!is_array($input)) {
		return tenores_get_theme_settings();
	}

	$output = tenores_get_theme_settings();

	// Permite HTML no headline com tags comuns e atributos para estilização.
	$allowed_html = [
		'strong' => ['class' => [], 'style' => []],
		'em'     => ['class' => [], 'style' => []],
		'span'   => ['class' => [], 'style' => []],
		'br'     => [],
		'p'      => ['class' => [], 'style' => []],
	];

	$output['banner']           = isset($input['banner']) ? sanitize_text_field($input['banner']) : '';
	$output['headline']         = isset($input['headline']) ? wp_kses($input['headline'], $allowed_html) : '';
	$output['contact_email']    = isset($input['contact_email']) ? sanitize_email($input['contact_email']) : '';
	$output['contact_phone']    = isset($input['contact_phone']) ? sanitize_text_field($input['contact_phone']) : '';
	$output['cto_url']          = isset($input['cto_url']) ? esc_url_raw($input['cto_url']) : '';
	$output['social_linkedin']  = isset($input['social_linkedin']) ? esc_url_raw($input['social_linkedin']) : '';
	$output['social_facebook']  = isset($input['social_facebook']) ? esc_url_raw($input['social_facebook']) : '';
	$output['social_instagram'] = isset($input['social_instagram']) ? esc_url_raw($input['social_instagram']) : '';
	$output['social_youtube']   = isset($input['social_youtube']) ? esc_url_raw($input['social_youtube']) : '';
	$output['webinar_enabled']  = !empty($input['webinar_enabled']) ? 1 : 0;
	$output['webinar_date']     = isset($input['webinar_date']) ? sanitize_text_field($input['webinar_date']) : '';
	$output['webinar_url']      = isset($input['webinar_url']) ? esc_url_raw($input['webinar_url']) : '';

	return $output;
}
