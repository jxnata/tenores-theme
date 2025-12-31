<?php

/**
 * Personalização da página de login do WordPress.
 *
 * Customiza a aparência da página wp-login.php seguindo o padrão visual do tema Tenores.
 */

/**
 * Enfileira estilos CSS personalizados na página de login.
 */
function tenores_login_styles()
{
	$background_image = get_theme_image_url('auth-bg.webp');
	$custom_logo_id   = get_theme_mod('custom_logo');
	$logo_url         = $custom_logo_id ? wp_get_attachment_image_url($custom_logo_id, 'medium') : '';
?>
	<style type="text/css">
		/* Background da página */
		body.login {
			display: flex;
			background-image: url('<?php echo esc_url($background_image); ?>');
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-color: #001123;
		}

		/* Container do formulário com glassmorphism */
		#login {
			background: rgba(0, 17, 35, 0.7) !important;
			backdrop-filter: blur(10px);
			-webkit-backdrop-filter: blur(10px);
			border-radius: 16px;
			padding: 40px 24px !important;
			margin-top: 6%;
		}

		<?php if ($logo_url) : ?>

		/* Logo personalizado */
		#login h1 a,
		.login h1 a {
			background-image: url('<?php echo esc_url($logo_url); ?>') !important;
			background-size: contain;
			background-repeat: no-repeat;
			background-position: center;
			width: 200px;
			height: 80px;
			text-indent: 0;
			font-size: 24px;
			font-weight: 700;
			color: #F4F4F5;
			width: auto;
			height: auto;
		}

		<?php else : ?>#login h1 a,
		.login h1 a {
			display: none;
		}

		<?php endif; ?>

		/* Formulário - remover estilos padrão do WordPress */
		.login form,
		.login form#loginform,
		.login form#lostpasswordform,
		.login form#registerform {
			background: transparent !important;
			border: none !important;
			box-shadow: none !important;
			padding: 0 !important;
			margin-top: 20px !important;
		}

		/* Labels */
		.login label {
			color: #F4F4F5 !important;
			font-size: 14px;
			font-weight: 600;
		}

		/* Campos de input */
		.login input[type="text"],
		.login input[type="email"],
		.login input[type="password"],
		.login form .input,
		.login input#user_login,
		.login input#user_pass,
		.login input#user_email {
			background: rgba(255, 255, 255, 0.1) !important;
			border: 1px solid rgba(244, 244, 245, 0.3) !important;
			border-radius: 10px !important;
			color: #F4F4F5 !important;
			padding: 12px 16px !important;
			font-size: 16px !important;
			transition: border-color 0.2s ease, box-shadow 0.2s ease;
			box-shadow: none !important;
		}

		.login input[type="text"]:focus,
		.login input[type="email"]:focus,
		.login input[type="password"]:focus,
		.login form .input:focus {
			background: rgba(255, 255, 255, 0.15) !important;
			border-color: #FF6A00 !important;
			box-shadow: 0 0 0 3px rgba(255, 106, 0, 0.2) !important;
			outline: none !important;
		}

		.login input[type="text"]::placeholder,
		.login input[type="email"]::placeholder,
		.login input[type="password"]::placeholder {
			color: rgba(244, 244, 245, 0.5) !important;
		}

		/* Botão de submit */
		.login .button-primary,
		.login input[type="submit"],
		.login #wp-submit {
			background-color: #FF6A00 !important;
			background-image: none !important;
			border: none !important;
			border-radius: 10px !important;
			padding: 8px 24px !important;
			font-size: 16px !important;
			font-weight: 700 !important;
			text-shadow: none !important;
			box-shadow: none !important;
			transition: background-color 0.2s ease, transform 0.1s ease;
			width: 100% !important;
			height: auto !important;
			margin-top: 10px !important;
			color: #fff !important;
		}

		.login .button-primary:hover,
		.login .button-primary:focus,
		.login input[type="submit"]:hover,
		.login input[type="submit"]:focus,
		.login #wp-submit:hover,
		.login #wp-submit:focus {
			background-color: #e55f00 !important;
			border: none !important;
			box-shadow: none !important;
			color: #fff !important;
		}

		.login .button-primary:active,
		.login input[type="submit"]:active,
		.login #wp-submit:active {
			transform: scale(0.98);
		}

		/* Checkbox "Lembrar-me" */
		.login .forgetmenot {
			margin-top: 10px;
		}

		.login input[type="checkbox"] {
			appearance: none !important;
			-webkit-appearance: none !important;
			width: 18px !important;
			height: 18px !important;
			min-width: 18px !important;
			border: 1px solid rgba(244, 244, 245, 0.3) !important;
			border-radius: 4px !important;
			background: rgba(255, 255, 255, 0.1) !important;
			cursor: pointer;
			vertical-align: middle;
			margin-right: 6px !important;
			padding: 0 !important;
		}

		.login input[type="checkbox"]:checked {
			background-color: #FF6A00 !important;
			border-color: #FF6A00 !important;
			background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='20 6 9 17 4 12'%3E%3C/polyline%3E%3C/svg%3E") !important;
			background-size: 12px !important;
			background-position: center !important;
			background-repeat: no-repeat !important;
		}

		.login input[type="checkbox"]:checked::before {
			content: none !important;
		}

		.login input[type="checkbox"]:focus {
			box-shadow: none !important;
			outline: none !important;
		}

		/* Links */
		.login #nav,
		.login #backtoblog {
			text-align: center;
			padding: 0 !important;
			margin-top: 16px;
		}

		.login #nav a,
		.login #backtoblog a {
			color: #F4F4F5 !important;
			text-decoration: none !important;
			font-size: 14px;
			transition: color 0.2s ease;
		}

		.login #nav a:hover,
		.login #backtoblog a:hover {
			color: #FF6A00 !important;
		}

		/* Mensagens de erro/sucesso/info */
		.login .message,
		.login .success,
		.login #login_error,
		.login p.message {
			background: rgba(0, 17, 35, 0.9) !important;
			border: 1px solid rgba(244, 244, 245, 0.2) !important;
			border-left: 4px solid #40E0D0 !important;
			border-radius: 8px !important;
			color: #F4F4F5 !important;
			padding: 12px 16px !important;
			margin-bottom: 20px !important;
			box-shadow: none !important;
		}

		.login #login_error {
			border-left-color: #FF6A00 !important;
		}

		.login .message a,
		.login #login_error a {
			color: #40E0D0 !important;
		}

		/* Esconder ícone de mostrar senha padrão */
		.login .wp-hide-pw,
		.login .button.wp-hide-pw {
			color: rgba(244, 244, 245, 0.6) !important;
			background: transparent !important;
			border: none !important;
			box-shadow: none !important;
		}

		.login .wp-hide-pw:hover,
		.login .wp-hide-pw:focus {
			color: #F4F4F5 !important;
			background: transparent !important;
			box-shadow: none !important;
		}

		.login .dashicons {
			color: rgba(244, 244, 245, 0.6) !important;
		}

		.login .wp-hide-pw:hover .dashicons,
		.login .wp-hide-pw:focus .dashicons {
			color: #F4F4F5 !important;
		}

		/* Esconder o link do WordPress.org na parte inferior */
		.login .privacy-policy-page-link {
			text-align: center;
		}

		.login .privacy-policy-page-link a {
			color: rgba(244, 244, 245, 0.6) !important;
			font-size: 12px;
		}

		.login .privacy-policy-page-link a:hover {
			color: #F4F4F5 !important;
		}

		/* Seletor de idioma */
		.login .language-switcher {
			display: none;
			background: rgba(0, 17, 35, 0.7) !important;
			backdrop-filter: blur(10px);
			-webkit-backdrop-filter: blur(10px);
			border-radius: 10px !important;
			padding: 12px 16px !important;
			margin-top: 20px;
			width: 320px;

		}

		.login .language-switcher form {
			display: flex;
			align-items: center;
			gap: 8px;
		}

		.login .language-switcher label {
			color: #F4F4F5 !important;
		}

		.login .language-switcher select {
			background: rgba(255, 255, 255, 0.1) !important;
			border: 1px solid rgba(244, 244, 245, 0.3) !important;
			border-radius: 8px !important;
			color: #F4F4F5 !important;
			padding: 8px 12px !important;
		}

		.login .language-switcher select option {
			background: #001123 !important;
			color: #F4F4F5 !important;
		}

		.login .language-switcher .button {
			margin-top: 0 !important;
			width: auto !important;
			background: transparent !important;
			color: #FF6A00 !important;
			padding: 8px 16px !important;
			font-weight: 600 !important;
			text-shadow: none !important;
			box-shadow: none !important;
		}

		.login .language-switcher .button:hover {
			background: transparent !important;
			color: #fff !important;
		}

		/* Responsividade */
		@media screen and (max-width: 782px) {
			#login {
				margin-top: 20px;
				padding: 30px 20px !important;
				width: calc(100% - 40px);
				max-width: 320px;
			}

			#login h1 a,
			.login h1 a {
				width: 160px;
				height: 60px;
			}
		}
	</style>
<?php
}

add_action('login_enqueue_scripts', 'tenores_login_styles');

/**
 * Altera a URL do logo para apontar para a home do site.
 *
 * @return string URL da home do site.
 */
function tenores_login_logo_url()
{
	return home_url('/');
}

add_filter('login_headerurl', 'tenores_login_logo_url');

/**
 * Altera o texto do logo para o nome do site.
 *
 * @return string Nome do site.
 */
function tenores_login_logo_text()
{
	return get_bloginfo('name');
}

add_filter('login_headertext', 'tenores_login_logo_text');
