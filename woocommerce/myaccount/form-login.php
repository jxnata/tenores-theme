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

		<p class="woocommerce-form-row form-row form-footer-link">
			<?php
			/* translators: %s: Login link */
			printf(esc_html__('Já possui uma conta? %s', 'tenores'), '<a href="' . esc_url($login_url) . '">' . esc_html__('Faça login', 'tenores') . '</a>');
			?>
		</p>

	<?php endif; ?>
</div>

<?php do_action('woocommerce_after_customer_login_form'); ?>