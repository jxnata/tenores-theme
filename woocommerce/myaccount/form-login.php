<?php

/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.9.0
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

// Determina qual formulário exibir baseado no parâmetro action da URL
$action = isset($_GET['action']) ? sanitize_text_field(wp_unslash($_GET['action'])) : 'login';
$is_registration_enabled = 'yes' === get_option('woocommerce_enable_myaccount_registration');
$show_login = ('login' === $action);
$show_register = ('register' === $action && $is_registration_enabled);

// URLs para alternar entre login e registro
$myaccount_page_id = get_option('woocommerce_myaccount_page_id');
$login_url = $myaccount_page_id ? get_permalink($myaccount_page_id) : wc_get_page_permalink('myaccount');
$register_url = add_query_arg('action', 'register', $login_url);
$site_name = get_bloginfo('name');

// Verificar se Google OAuth está ativado
$settings = tenores_get_theme_settings();
$google_oauth_enabled = !empty($settings['google_oauth_enabled']) && !empty($settings['google_oauth_client_id']);
$google_oauth_url = $google_oauth_enabled ? rest_url('tenores/v1/google-oauth/authorize') : '';

do_action('woocommerce_before_customer_login_form'); ?>

<div class="woocommerce-account-form-wrapper">
	<?php if ($show_login) : ?>

		<h2 class="text-xl font-bold"><?php esc_html_e('Seja bem vindo de volta', 'tenores'); ?></h2>

		<form class="woocommerce-form woocommerce-form-login login" method="post" novalidate>

			<?php do_action('woocommerce_login_form_start'); ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="username"><?php esc_html_e('Username or email address', 'woocommerce'); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo (! empty($_POST['username']) && is_string($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" required aria-required="true" /><?php // @codingStandardsIgnoreLine 
																																																																															?>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" required aria-required="true" />
			</p>

			<?php do_action('woocommerce_login_form'); ?>

			<p class="form-row">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
				</label>
				<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
				<button type="submit" class="woocommerce-button button woocommerce-form-login__submit<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="login" value="<?php esc_attr_e('Log in', 'woocommerce'); ?>"><?php esc_html_e('Log in', 'woocommerce'); ?></button>
			</p>
			<p class="woocommerce-LostPassword lost_password">
				<a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
			</p>

			<?php do_action('woocommerce_login_form_end'); ?>

		</form>

		<?php if ($google_oauth_enabled) : ?>
			<div class="woocommerce-google-oauth-separator">
				<p class="text-center my-4 text-sm"><?php esc_html_e('ou', 'tenores'); ?></p>
			</div>
			<div class="woocommerce-google-oauth-button-wrapper">
				<a href="<?php echo esc_url($google_oauth_url); ?>" class="woocommerce-google-oauth-button inline-flex items-center justify-center w-full px-4 py-3 bg-white border border-tertiary text-tertiary rounded-lg hover:bg-gray-50 transition-colors !no-underline">
					<svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
						<path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
						<path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" />
						<path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" />
					</svg>
					<span><?php esc_html_e('Continuar com o Google', 'tenores'); ?></span>
				</a>
			</div>
		<?php endif; ?>

		<?php if ($is_registration_enabled) : ?>
			<p class="woocommerce-form-row form-row form-footer-link">
				<?php
				/* translators: %1$s: Site name, %2$s: Register link */
				printf(esc_html__('Novo no %1$s? %2$s', 'tenores'), esc_html($site_name), '<a href="' . esc_url($register_url) . '">' . esc_html__('Criar uma conta', 'tenores') . '</a>');
				?>
			</p>
		<?php endif; ?>

	<?php endif; ?>

	<?php if ($show_register) : ?>

		<h2 class="text-xl font-bold"><?php esc_html_e('Criar uma conta', 'tenores'); ?></h2>
		<p class="form-subtitle"><?php esc_html_e('Estude a hora que quiser', 'tenores'); ?></p>

		<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action('woocommerce_register_form_tag'); ?>>

			<?php do_action('woocommerce_register_form_start'); ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="reg_full_name"><?php esc_html_e('Nome completo', 'tenores'); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="full_name" id="reg_full_name" autocomplete="name" value="<?php echo (! empty($_POST['full_name'])) ? esc_attr(wp_unslash($_POST['full_name'])) : ''; ?>" required aria-required="true" />
			</p>

			<?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_username"><?php esc_html_e('Username', 'woocommerce'); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo (! empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" required aria-required="true" /><?php // @codingStandardsIgnoreLine 
																																																																									?>
				</p>

			<?php endif; ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="reg_email"><?php esc_html_e('Email address', 'woocommerce'); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span></label>
				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo (! empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" required aria-required="true" /><?php // @codingStandardsIgnoreLine 
																																																																					?>
			</p>

			<?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_password"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" required aria-required="true" />
				</p>

			<?php else : ?>

				<p><?php esc_html_e('A link to set a new password will be sent to your email address.', 'woocommerce'); ?></p>

			<?php endif; ?>

			<?php do_action('woocommerce_register_form'); ?>

			<p class="woocommerce-form-row form-row">
				<?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
				<button type="submit" class="woocommerce-Button woocommerce-button button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?> woocommerce-form-register__submit" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
			</p>

			<?php do_action('woocommerce_register_form_end'); ?>

		</form>

		<?php if ($google_oauth_enabled) : ?>
			<div class="woocommerce-google-oauth-separator">
				<p class="text-center my-4 text-sm"><?php esc_html_e('ou', 'tenores'); ?></p>
			</div>
			<div class="woocommerce-google-oauth-button-wrapper">
				<a href="<?php echo esc_url($google_oauth_url); ?>" class="woocommerce-google-oauth-button inline-flex items-center justify-center w-full px-4 py-3 bg-white border border-tertiary text-tertiary rounded-lg hover:bg-gray-50 transition-colors !no-underline">
					<svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
						<path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
						<path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" />
						<path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" />
					</svg>
					<span><?php esc_html_e('Continuar com o Google', 'tenores'); ?></span>
				</a>
			</div>
		<?php endif; ?>

		<p class="woocommerce-form-row form-row form-footer-link">
			<?php
			/* translators: %s: Login link */
			printf(esc_html__('Já possui uma conta? %s', 'tenores'), '<a href="' . esc_url($login_url) . '">' . esc_html__('Faça login', 'tenores') . '</a>');
			?>
		</p>

	<?php endif; ?>
</div>

<?php do_action('woocommerce_after_customer_login_form'); ?>