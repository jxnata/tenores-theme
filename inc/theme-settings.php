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
		'banner'                      => '',
		'headline'                    => '',
		'installments_count'          => 12,
		'contact_email'               => '',
		'contact_phone'               => '',
		'cto_url'                     => '',
		'social_linkedin'             => '',
		'social_facebook'             => '',
		'social_instagram'            => '',
		'social_youtube'              => '',
		'footer_menu_primary'         => '',
		'footer_menu_secondary'       => '',
		'webinar_enabled'             => 0,
		'webinar_date'                => '',
		'webinar_url'                 => '',
		'featured_course_masteriyo'   => '',
		'featured_course_banner'      => '',
		'featured_course_title'       => '',
		'featured_course_subtitle'    => '',
		'member_access_title'         => __('Conteúdo Exclusivo para Membros', 'tenores'),
		'member_access_subtitle'      => __('Este conteúdo está disponível apenas para membros registrados. Faça login ou crie uma conta para acessar.', 'tenores'),
		'subscription_product_id'     => '',
		'subscriber_access_title'     => __('Conteúdo Exclusivo para Assinantes', 'tenores'),
		'subscriber_access_subtitle'  => __('Este conteúdo está disponível apenas para assinantes. Assine agora para ter acesso completo.', 'tenores'),
		'myaccount_non_subscriber_title'   => __('Seja um Assinante!', 'tenores'),
		'myaccount_non_subscriber_message' => __('Assine agora e tenha acesso a todos os cursos e conteúdos exclusivos da plataforma.', 'tenores'),
		'myaccount_subscriber_title'       => __('Bem-vindo, Assinante!', 'tenores'),
		'myaccount_subscriber_message'     => __('Você já é um assinante ativo. Aproveite todos os cursos e conteúdos exclusivos disponíveis.', 'tenores'),
		'courses_page_id'             => '',
		'google_oauth_enabled'        => 0,
		'google_oauth_client_id'      => '',
		'google_oauth_client_secret'   => '',
	];

	return array_merge($defaults, $settings);
}

function tenores_can_manage_theme_settings(): bool
{
	return current_user_can('manage_options') || current_user_can('edit_others_posts');
}

function tenores_register_theme_settings(): void
{
	register_setting(
		'tenores_theme_settings_group',
		TENORES_SETTINGS_OPTION,
		[
			'type'              => 'array',
			'sanitize_callback' => 'tenores_sanitize_theme_settings',
			'capability'        => 'edit_others_posts',
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
		'tenores_render_image_upload_field',
		'tenores_theme_settings',
		'tenores_theme_main_section',
		[
			'key' => 'banner',
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
		'tenores_installments_count',
		__('Máximo de parcelas', 'tenores'),
		'tenores_render_text_field',
		'tenores_theme_settings',
		'tenores_theme_main_section',
		[
			'key'         => 'installments_count',
			'type'        => 'number',
			'placeholder' => '12',
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

	add_settings_field(
		'tenores_footer_menu_primary',
		__('Menu Principal do Footer', 'tenores'),
		'tenores_render_menu_select_field',
		'tenores_theme_settings',
		'tenores_theme_main_section',
		[
			'key' => 'footer_menu_primary',
		]
	);

	add_settings_field(
		'tenores_footer_menu_secondary',
		__('Menu Secundário do Footer', 'tenores'),
		'tenores_render_menu_select_field',
		'tenores_theme_settings',
		'tenores_theme_main_section',
		[
			'key' => 'footer_menu_secondary',
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

	add_settings_section(
		'tenores_theme_featured_course_section',
		__('Curso em Destaque', 'tenores'),
		'__return_false',
		'tenores_theme_settings'
	);

	add_settings_field(
		'tenores_featured_course_masteriyo',
		__('Curso em destaque', 'tenores'),
		'tenores_render_masteriyo_course_select_field',
		'tenores_theme_settings',
		'tenores_theme_featured_course_section',
		[
			'key' => 'featured_course_masteriyo',
		]
	);

	add_settings_field(
		'tenores_featured_course_banner',
		__('Banner promocional', 'tenores'),
		'tenores_render_image_upload_field',
		'tenores_theme_settings',
		'tenores_theme_featured_course_section',
		[
			'key' => 'featured_course_banner',
		]
	);

	add_settings_field(
		'tenores_featured_course_title',
		__('Título', 'tenores'),
		'tenores_render_text_field',
		'tenores_theme_settings',
		'tenores_theme_featured_course_section',
		[
			'key'         => 'featured_course_title',
			'type'        => 'text',
			'placeholder' => __('Destrave Sua Voz, Liberte Seu Potencial', 'tenores'),
		]
	);

	add_settings_field(
		'tenores_featured_course_subtitle',
		__('Subtítulo', 'tenores'),
		'tenores_render_textarea_field',
		'tenores_theme_settings',
		'tenores_theme_featured_course_section',
		[
			'key'         => 'featured_course_subtitle',
			'placeholder' => __('Aprenda a falar com confiança, emoção e presença em qualquer situação.', 'tenores'),
		]
	);

	add_settings_section(
		'tenores_theme_member_access_section',
		__('Acesso de Membros', 'tenores'),
		'__return_false',
		'tenores_theme_settings'
	);

	add_settings_field(
		'tenores_subscription_product_id',
		__('Produto de Assinatura', 'tenores'),
		'tenores_render_subscription_product_select_field',
		'tenores_theme_settings',
		'tenores_theme_member_access_section',
		[
			'key' => 'subscription_product_id',
		]
	);

	add_settings_field(
		'tenores_member_access_title',
		__('Título da mensagem para não-logados', 'tenores'),
		'tenores_render_text_field',
		'tenores_theme_settings',
		'tenores_theme_member_access_section',
		[
			'key'         => 'member_access_title',
			'type'        => 'text',
			'placeholder' => __('Conteúdo Exclusivo para Membros', 'tenores'),
		]
	);

	add_settings_field(
		'tenores_member_access_subtitle',
		__('Subtítulo da mensagem para não-logados', 'tenores'),
		'tenores_render_textarea_field',
		'tenores_theme_settings',
		'tenores_theme_member_access_section',
		[
			'key'         => 'member_access_subtitle',
			'placeholder' => __('Este conteúdo está disponível apenas para membros registrados. Faça login ou crie uma conta para acessar.', 'tenores'),
		]
	);

	add_settings_field(
		'tenores_subscriber_access_title',
		__('Título da mensagem para não-assinantes', 'tenores'),
		'tenores_render_text_field',
		'tenores_theme_settings',
		'tenores_theme_member_access_section',
		[
			'key'         => 'subscriber_access_title',
			'type'        => 'text',
			'placeholder' => __('Conteúdo Exclusivo para Assinantes', 'tenores'),
		]
	);

	add_settings_field(
		'tenores_subscriber_access_subtitle',
		__('Subtítulo da mensagem para não-assinantes', 'tenores'),
		'tenores_render_textarea_field',
		'tenores_theme_settings',
		'tenores_theme_member_access_section',
		[
			'key'         => 'subscriber_access_subtitle',
			'placeholder' => __('Este conteúdo está disponível apenas para assinantes. Assine agora para ter acesso completo.', 'tenores'),
		]
	);

	add_settings_section(
		'tenores_theme_myaccount_section',
		__('Página Minha Conta', 'tenores'),
		'__return_false',
		'tenores_theme_settings'
	);

	add_settings_field(
		'tenores_courses_page_id',
		__('Página de Cursos', 'tenores'),
		'tenores_render_page_select_field',
		'tenores_theme_settings',
		'tenores_theme_myaccount_section',
		[
			'key' => 'courses_page_id',
		]
	);

	add_settings_field(
		'tenores_myaccount_non_subscriber_title',
		__('Título para não-assinantes', 'tenores'),
		'tenores_render_text_field',
		'tenores_theme_settings',
		'tenores_theme_myaccount_section',
		[
			'key'         => 'myaccount_non_subscriber_title',
			'type'        => 'text',
			'placeholder' => __('Seja um Assinante!', 'tenores'),
		]
	);

	add_settings_field(
		'tenores_myaccount_non_subscriber_message',
		__('Mensagem para não-assinantes', 'tenores'),
		'tenores_render_textarea_field',
		'tenores_theme_settings',
		'tenores_theme_myaccount_section',
		[
			'key'         => 'myaccount_non_subscriber_message',
			'placeholder' => __('Assine agora e tenha acesso a todos os cursos e conteúdos exclusivos da plataforma.', 'tenores'),
		]
	);

	add_settings_field(
		'tenores_myaccount_subscriber_title',
		__('Título para assinantes', 'tenores'),
		'tenores_render_text_field',
		'tenores_theme_settings',
		'tenores_theme_myaccount_section',
		[
			'key'         => 'myaccount_subscriber_title',
			'type'        => 'text',
			'placeholder' => __('Bem-vindo, Assinante!', 'tenores'),
		]
	);

	add_settings_field(
		'tenores_myaccount_subscriber_message',
		__('Mensagem para assinantes', 'tenores'),
		'tenores_render_textarea_field',
		'tenores_theme_settings',
		'tenores_theme_myaccount_section',
		[
			'key'         => 'myaccount_subscriber_message',
			'placeholder' => __('Você já é um assinante ativo. Aproveite todos os cursos e conteúdos exclusivos disponíveis.', 'tenores'),
		]
	);

	add_settings_section(
		'tenores_theme_google_oauth_section',
		__('Login com Google', 'tenores'),
		'__return_false',
		'tenores_theme_settings'
	);

	add_settings_field(
		'tenores_google_oauth_enabled',
		__('Ativar login com Google', 'tenores'),
		'tenores_render_checkbox_field',
		'tenores_theme_settings',
		'tenores_theme_google_oauth_section',
		[
			'key' => 'google_oauth_enabled',
		]
	);

	add_settings_field(
		'tenores_google_oauth_client_id',
		__('Client ID do Google', 'tenores'),
		'tenores_render_text_field',
		'tenores_theme_settings',
		'tenores_theme_google_oauth_section',
		[
			'key'         => 'google_oauth_client_id',
			'type'        => 'text',
			'placeholder' => __('Cole aqui o Client ID do Google Cloud Console', 'tenores'),
		]
	);

	add_settings_field(
		'tenores_google_oauth_client_secret',
		__('Client Secret do Google', 'tenores'),
		'tenores_render_password_field',
		'tenores_theme_settings',
		'tenores_theme_google_oauth_section',
		[
			'key'         => 'google_oauth_client_secret',
			'placeholder' => __('Cole aqui o Client Secret do Google Cloud Console', 'tenores'),
		]
	);

	add_settings_field(
		'tenores_google_oauth_redirect_uri',
		__('URI de Redirecionamento', 'tenores'),
		'tenores_render_readonly_field',
		'tenores_theme_settings',
		'tenores_theme_google_oauth_section',
		[
			'key' => 'google_oauth_redirect_uri',
		]
	);
}

add_action('admin_init', 'tenores_register_theme_settings');

function tenores_add_theme_settings_page(): void
{
	add_theme_page(
		__('Configurações do Tema', 'tenores'),
		__('Configurações do Tema', 'tenores'),
		'edit_others_posts',
		'tenores-theme-settings',
		'tenores_render_theme_settings_page'
	);
}

add_action('admin_menu', 'tenores_add_theme_settings_page');

function tenores_render_theme_settings_page(): void
{
	if (!tenores_can_manage_theme_settings()) {
		wp_die(__('Você não tem permissão para acessar esta página.', 'tenores'));
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

		<hr class="wp-header-end" style="margin: 30px 0;">

		<div class="card" style="max-width: 800px;">
			<h2><?php esc_html_e('Shortcodes Disponíveis', 'tenores'); ?></h2>
			<p><?php esc_html_e('Use os shortcodes abaixo para inserir seções do tema em qualquer página ou post:', 'tenores'); ?></p>

			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row">
							<label><?php esc_html_e('Seção de Oferta', 'tenores'); ?></label>
						</th>
						<td>
							<code>[tenores_oferta]</code>
							<p class="description">
								<?php esc_html_e('Exibe a seção de oferta com preços e benefícios. Use este shortcode em qualquer página ou post onde desejar mostrar a oferta.', 'tenores'); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e('Posts para Membros', 'tenores'); ?></label>
						</th>
						<td>
							<code>[tenores_posts_membros]</code>
							<p class="description">
								<?php esc_html_e('Exibe posts exclusivos para membros registrados. Usuários não logados verão a mensagem de acesso restrito. Usuários com compras também verão posts exclusivos para membros com compras.', 'tenores'); ?>
							</p>
							<p class="description" style="margin-top: 10px;">
								<strong><?php esc_html_e('Atributos opcionais:', 'tenores'); ?></strong><br>
								<code>posts="5"</code> - <?php esc_html_e('Número de posts a exibir (padrão: 5)', 'tenores'); ?><br>
								<code>category="slug-da-categoria"</code> - <?php esc_html_e('Filtrar por categoria (opcional)', 'tenores'); ?><br>
								<code>tag="slug-da-tag"</code> - <?php esc_html_e('Filtrar por tag (opcional)', 'tenores'); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e('Cursos Masteriyo', 'tenores'); ?></label>
						</th>
						<td>
							<code>[tenores_cursos]</code>
							<p class="description">
								<?php esc_html_e('Exibe cursos do Masteriyo com o mesmo layout da página de cursos. Use este shortcode em qualquer página ou post onde desejar mostrar cursos.', 'tenores'); ?>
							</p>
							<p class="description" style="margin-top: 10px;">
								<strong><?php esc_html_e('Atributos opcionais:', 'tenores'); ?></strong><br>
								<code>posts_per_page="9"</code> - <?php esc_html_e('Número de cursos por página (padrão: 9)', 'tenores'); ?><br>
								<code>category="slug-da-categoria"</code> - <?php esc_html_e('Filtrar por categoria de curso (opcional)', 'tenores'); ?><br>
								<code>price="free"</code> - <?php esc_html_e('Exibir apenas cursos gratuitos', 'tenores'); ?><br>
								<code>price="paid"</code> - <?php esc_html_e('Exibir apenas cursos pagos', 'tenores'); ?><br>
								<code>access="public"</code> - <?php esc_html_e('Exibir apenas cursos de acesso livre', 'tenores'); ?><br>
								<code>access="members"</code> - <?php esc_html_e('Exibir apenas cursos para usuários registrados', 'tenores'); ?><br>
								<code>access="subscribers"</code> - <?php esc_html_e('Exibir apenas cursos para assinantes', 'tenores'); ?><br>
								<code>pagination="true"</code> - <?php esc_html_e('Exibir paginação (padrão: true). Use "false" para desabilitar', 'tenores'); ?>
							</p>
							<p class="description" style="margin-top: 10px;">
								<strong><?php esc_html_e('Exemplos:', 'tenores'); ?></strong><br>
								<code>[tenores_cursos]</code> - <?php esc_html_e('Exibe 9 cursos por página com paginação', 'tenores'); ?><br>
								<code>[tenores_cursos posts_per_page="6" price="free"]</code> - <?php esc_html_e('Exibe 6 cursos gratuitos por página', 'tenores'); ?><br>
								<code>[tenores_cursos access="subscribers"]</code> - <?php esc_html_e('Exibe apenas cursos exclusivos para assinantes', 'tenores'); ?><br>
								<code>[tenores_cursos category="tecnologia" access="public"]</code> - <?php esc_html_e('Exibe cursos gratuitos da categoria tecnologia', 'tenores'); ?>
							</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
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

function tenores_render_menu_select_field(array $args): void
{
	$settings = tenores_get_theme_settings();
	$key      = $args['key'] ?? '';
	$value    = isset($settings[$key]) ? (string) $settings[$key] : '';
	$menus    = wp_get_nav_menus();

	printf(
		'<select id="%1$s" name="%2$s[%1$s]" class="regular-text">',
		esc_attr($key),
		esc_attr(TENORES_SETTINGS_OPTION)
	);

	printf(
		'<option value="">%s</option>',
		esc_html__('-- Selecione um menu --', 'tenores')
	);

	foreach ($menus as $menu) {
		printf(
			'<option value="%1$s" %2$s>%3$s</option>',
			esc_attr($menu->term_id),
			selected($value, $menu->term_id, false),
			esc_html($menu->name)
		);
	}

	echo '</select>';
	echo '<p class="description">';
	printf(
		esc_html__('Crie ou gerencie menus em %s.', 'tenores'),
		sprintf(
			'<a href="%s">%s</a>',
			esc_url(admin_url('nav-menus.php')),
			esc_html__('Aparência > Menus', 'tenores')
		)
	);
	echo '</p>';
}

function tenores_render_product_select_field(array $args): void
{
	$settings = tenores_get_theme_settings();
	$key      = $args['key'] ?? '';
	$value    = isset($settings[$key]) ? (string) $settings[$key] : '';

	if (!class_exists('WooCommerce')) {
		echo '<p class="description" style="color: #d63638;">';
		esc_html_e('WooCommerce não está ativo. Ative o plugin para selecionar um produto.', 'tenores');
		echo '</p>';
		return;
	}

	$products = wc_get_products([
		'status' => 'publish',
		'limit'  => -1,
		'orderby' => 'title',
		'order'   => 'ASC',
	]);

	printf(
		'<select id="%1$s" name="%2$s[%1$s]" class="regular-text">',
		esc_attr($key),
		esc_attr(TENORES_SETTINGS_OPTION)
	);

	printf(
		'<option value="">%s</option>',
		esc_html__('-- Selecione um produto --', 'tenores')
	);

	foreach ($products as $product) {
		printf(
			'<option value="%1$s" %2$s>%3$s</option>',
			esc_attr($product->get_id()),
			selected($value, $product->get_id(), false),
			esc_html($product->get_name())
		);
	}

	echo '</select>';
	echo '<p class="description">';
	printf(
		esc_html__('Selecione o produto que será exibido em destaque na loja. Gerencie produtos em %s.', 'tenores'),
		sprintf(
			'<a href="%s">%s</a>',
			esc_url(admin_url('edit.php?post_type=product')),
			esc_html__('Produtos', 'tenores')
		)
	);
	echo '</p>';
}

function tenores_render_subscription_product_select_field(array $args): void
{
	$settings = tenores_get_theme_settings();
	$key      = $args['key'] ?? '';
	$value    = isset($settings[$key]) ? (string) $settings[$key] : '';

	if (!class_exists('WooCommerce')) {
		echo '<p class="description" style="color: #d63638;">';
		esc_html_e('WooCommerce não está ativo. Ative o plugin para selecionar um produto.', 'tenores');
		echo '</p>';
		return;
	}

	// Busca produtos do tipo subscription (WPSwings Subscriptions for WooCommerce)
	$products = wc_get_products([
		'status'  => 'publish',
		'limit'   => -1,
		'orderby' => 'title',
		'order'   => 'ASC',
		'type'    => ['subscription', 'simple', 'variable'],
	]);

	printf(
		'<select id="%1$s" name="%2$s[%1$s]" class="regular-text">',
		esc_attr($key),
		esc_attr(TENORES_SETTINGS_OPTION)
	);

	printf(
		'<option value="">%s</option>',
		esc_html__('-- Selecione um produto de assinatura --', 'tenores')
	);

	foreach ($products as $product) {
		// Verifica se o produto tem assinatura habilitada (WPSwings)
		$is_subscription = get_post_meta($product->get_id(), '_wps_sfw_product', true) === 'yes';

		// Mostra apenas produtos com assinatura ou todos se não houver nenhum com assinatura
		if ($is_subscription) {
			printf(
				'<option value="%1$s" %2$s>%3$s</option>',
				esc_attr($product->get_id()),
				selected($value, $product->get_id(), false),
				esc_html($product->get_name())
			);
		}
	}

	echo '</select>';
	echo '<p class="description">';
	esc_html_e('Selecione o produto de assinatura que o usuário precisa ter ativo para acessar conteúdo restrito a assinantes.', 'tenores');
	echo '</p>';
}

function tenores_render_page_select_field(array $args): void
{
	$settings = tenores_get_theme_settings();
	$key      = $args['key'] ?? '';
	$value    = isset($settings[$key]) ? (string) $settings[$key] : '';

	$pages = get_pages([
		'sort_column' => 'post_title',
		'sort_order'  => 'ASC',
	]);

	printf(
		'<select id="%1$s" name="%2$s[%1$s]" class="regular-text">',
		esc_attr($key),
		esc_attr(TENORES_SETTINGS_OPTION)
	);

	printf(
		'<option value="">%s</option>',
		esc_html__('-- Selecione uma página --', 'tenores')
	);

	foreach ($pages as $page) {
		printf(
			'<option value="%1$s" %2$s>%3$s</option>',
			esc_attr($page->ID),
			selected($value, $page->ID, false),
			esc_html($page->post_title)
		);
	}

	echo '</select>';
	echo '<p class="description">';
	printf(
		esc_html__('Selecione a página. Gerencie páginas em %s.', 'tenores'),
		sprintf(
			'<a href="%s">%s</a>',
			esc_url(admin_url('edit.php?post_type=page')),
			esc_html__('Páginas', 'tenores')
		)
	);
	echo '</p>';
}

function tenores_render_masteriyo_course_select_field(array $args): void
{
	$settings = tenores_get_theme_settings();
	$key      = $args['key'] ?? '';
	$value    = isset($settings[$key]) ? (string) $settings[$key] : '';

	// Verifica se Masteriyo está ativo
	$is_masteriyo_active = class_exists('Masteriyo\Masteriyo') || defined('MASTERIYO_VERSION');

	if (!$is_masteriyo_active) {
		echo '<p class="description" style="color: #d63638;">';
		esc_html_e('Masteriyo não está ativo. Ative o plugin para selecionar um curso.', 'tenores');
		echo '</p>';
		return;
	}

	// Busca cursos via WP_Query
	$courses_query = new WP_Query([
		'post_type'      => 'mto-course',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
	]);

	$courses = $courses_query->posts;

	printf(
		'<select id="%1$s" name="%2$s[%1$s]" class="regular-text">',
		esc_attr($key),
		esc_attr(TENORES_SETTINGS_OPTION)
	);

	printf(
		'<option value="">%s</option>',
		esc_html__('-- Selecione um curso --', 'tenores')
	);

	foreach ($courses as $course) {
		$course_id   = $course->ID;
		$course_name = get_the_title($course_id);

		printf(
			'<option value="%1$s" %2$s>%3$s</option>',
			esc_attr($course_id),
			selected($value, $course_id, false),
			esc_html($course_name)
		);
	}

	echo '</select>';
	echo '<p class="description">';
	printf(
		esc_html__('Selecione o curso que será exibido em destaque. Gerencie cursos em %s.', 'tenores'),
		sprintf(
			'<a href="%s">%s</a>',
			esc_url(admin_url('edit.php?post_type=mto-course')),
			esc_html__('Cursos', 'tenores')
		)
	);
	echo '</p>';
}

function tenores_render_password_field(array $args): void
{
	$settings    = tenores_get_theme_settings();
	$key         = $args['key'] ?? '';
	$placeholder = $args['placeholder'] ?? '';
	$value       = isset($settings[$key]) ? (string) $settings[$key] : '';

	printf(
		'<input type="password" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="regular-text" placeholder="%4$s" autocomplete="off" />',
		esc_attr($key),
		esc_attr(TENORES_SETTINGS_OPTION),
		esc_attr($value),
		esc_attr($placeholder)
	);
}

function tenores_render_readonly_field(array $args): void
{
	$key = $args['key'] ?? '';

	// A URI será gerada dinamicamente pelo módulo google-oauth.php
	$redirect_uri = rest_url('tenores/v1/google-oauth/callback');

	printf(
		'<input type="text" id="%1$s" value="%2$s" class="regular-text" readonly />',
		esc_attr($key),
		esc_attr($redirect_uri)
	);
	echo '<p class="description">';
	esc_html_e('Copie esta URI e adicione como URI de redirecionamento autorizada no Google Cloud Console.', 'tenores');
	echo '</p>';
}

function tenores_render_image_upload_field(array $args): void
{
	$settings = tenores_get_theme_settings();
	$key      = $args['key'] ?? '';
	$value    = isset($settings[$key]) ? absint($settings[$key]) : 0;
	$image_url = '';

	if ($value) {
		$image_url = wp_get_attachment_image_url($value, 'full');
	}

	wp_enqueue_media();
?>
	<div class="tenores-image-upload-wrapper">
		<input type="hidden" id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr(TENORES_SETTINGS_OPTION); ?>[<?php echo esc_attr($key); ?>]" value="<?php echo esc_attr($value); ?>" />

		<div id="<?php echo esc_attr($key); ?>_preview" class="tenores-image-preview" style="margin-bottom: 10px;">
			<?php if ($image_url) : ?>
				<img src="<?php echo esc_url($image_url); ?>" style="max-width: 300px; height: auto; display: block;" />
			<?php endif; ?>
		</div>

		<button type="button" class="button tenores-upload-image-button" data-target="<?php echo esc_attr($key); ?>">
			<?php echo $value ? esc_html__('Alterar imagem', 'tenores') : esc_html__('Selecionar imagem', 'tenores'); ?>
		</button>

		<?php if ($value) : ?>
			<button type="button" class="button tenores-remove-image-button" data-target="<?php echo esc_attr($key); ?>" style="margin-left: 5px;">
				<?php esc_html_e('Remover imagem', 'tenores'); ?>
			</button>
		<?php endif; ?>

		<p class="description">
			<?php esc_html_e('Selecione uma imagem para usar como background do banner. Se nenhuma imagem for selecionada, será usada a imagem padrão do tema.', 'tenores'); ?>
		</p>
	</div>

	<script>
		jQuery(document).ready(function($) {
			var file_frame;

			$(document).on('click', '.tenores-upload-image-button', function(e) {
				e.preventDefault();

				var button = $(this);
				var target = button.data('target');

				if (file_frame) {
					file_frame.open();
					return;
				}

				file_frame = wp.media({
					title: '<?php esc_html_e('Selecionar imagem', 'tenores'); ?>',
					button: {
						text: '<?php esc_html_e('Usar esta imagem', 'tenores'); ?>'
					},
					multiple: false
				});

				file_frame.on('select', function() {
					var attachment = file_frame.state().get('selection').first().toJSON();
					$('#' + target).val(attachment.id);
					$('#' + target + '_preview').html('<img src="' + attachment.url + '" style="max-width: 300px; height: auto; display: block;" />');
					button.text('<?php esc_html_e('Alterar imagem', 'tenores'); ?>');

					if (!$('.tenores-remove-image-button[data-target="' + target + '"]').length) {
						button.after('<button type="button" class="button tenores-remove-image-button" data-target="' + target + '" style="margin-left: 5px;"><?php esc_html_e('Remover imagem', 'tenores'); ?></button>');
					}
				});

				file_frame.open();
			});

			$(document).on('click', '.tenores-remove-image-button', function(e) {
				e.preventDefault();

				var button = $(this);
				var target = button.data('target');

				$('#' + target).val('');
				$('#' + target + '_preview').html('');
				$('.tenores-upload-image-button[data-target="' + target + '"]').text('<?php esc_html_e('Selecionar imagem', 'tenores'); ?>');
				button.remove();
			});
		});
	</script>
<?php
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

	$output['banner']              = isset($input['banner']) ? absint($input['banner']) : 0;
	$output['headline']            = isset($input['headline']) ? wp_kses($input['headline'], $allowed_html) : '';
	$output['contact_email']       = isset($input['contact_email']) ? sanitize_email($input['contact_email']) : '';
	$output['contact_phone']       = isset($input['contact_phone']) ? sanitize_text_field($input['contact_phone']) : '';
	$output['installments_count']  = isset($input['installments_count']) ? max(1, min(36, absint($input['installments_count']))) : 12;
	$output['cto_url']             = isset($input['cto_url']) ? esc_url_raw($input['cto_url']) : '';
	$output['social_linkedin']     = isset($input['social_linkedin']) ? esc_url_raw($input['social_linkedin']) : '';
	$output['social_facebook']     = isset($input['social_facebook']) ? esc_url_raw($input['social_facebook']) : '';
	$output['social_instagram']    = isset($input['social_instagram']) ? esc_url_raw($input['social_instagram']) : '';
	$output['social_youtube']      = isset($input['social_youtube']) ? esc_url_raw($input['social_youtube']) : '';
	$output['footer_menu_primary'] = isset($input['footer_menu_primary']) ? absint($input['footer_menu_primary']) : '';
	$output['footer_menu_secondary'] = isset($input['footer_menu_secondary']) ? absint($input['footer_menu_secondary']) : '';
	$output['webinar_enabled']     = !empty($input['webinar_enabled']) ? 1 : 0;
	$output['webinar_date']        = isset($input['webinar_date']) ? sanitize_text_field($input['webinar_date']) : '';
	$output['webinar_url']         = isset($input['webinar_url']) ? esc_url_raw($input['webinar_url']) : '';

	$output['featured_course_masteriyo'] = isset($input['featured_course_masteriyo']) ? absint($input['featured_course_masteriyo']) : '';
	$output['featured_course_banner']    = isset($input['featured_course_banner']) ? absint($input['featured_course_banner']) : 0;
	$output['featured_course_title']    = isset($input['featured_course_title']) ? sanitize_text_field($input['featured_course_title']) : '';
	$output['featured_course_subtitle']  = isset($input['featured_course_subtitle']) ? sanitize_textarea_field($input['featured_course_subtitle']) : '';

	$output['member_access_title']    = isset($input['member_access_title']) ? sanitize_text_field($input['member_access_title']) : '';
	$output['member_access_subtitle'] = isset($input['member_access_subtitle']) ? sanitize_textarea_field($input['member_access_subtitle']) : '';

	$output['subscription_product_id']     = isset($input['subscription_product_id']) ? absint($input['subscription_product_id']) : '';
	$output['subscriber_access_title']     = isset($input['subscriber_access_title']) ? sanitize_text_field($input['subscriber_access_title']) : '';
	$output['subscriber_access_subtitle']  = isset($input['subscriber_access_subtitle']) ? sanitize_textarea_field($input['subscriber_access_subtitle']) : '';

	$output['myaccount_non_subscriber_title']   = isset($input['myaccount_non_subscriber_title']) ? sanitize_text_field($input['myaccount_non_subscriber_title']) : '';
	$output['myaccount_non_subscriber_message'] = isset($input['myaccount_non_subscriber_message']) ? sanitize_textarea_field($input['myaccount_non_subscriber_message']) : '';
	$output['myaccount_subscriber_title']       = isset($input['myaccount_subscriber_title']) ? sanitize_text_field($input['myaccount_subscriber_title']) : '';
	$output['myaccount_subscriber_message']     = isset($input['myaccount_subscriber_message']) ? sanitize_textarea_field($input['myaccount_subscriber_message']) : '';
	$output['courses_page_id']                  = isset($input['courses_page_id']) ? absint($input['courses_page_id']) : '';

	$output['google_oauth_enabled']      = !empty($input['google_oauth_enabled']) ? 1 : 0;
	$output['google_oauth_client_id']    = isset($input['google_oauth_client_id']) ? sanitize_text_field($input['google_oauth_client_id']) : '';
	$output['google_oauth_client_secret'] = isset($input['google_oauth_client_secret']) ? sanitize_text_field($input['google_oauth_client_secret']) : '';

	return $output;
}
