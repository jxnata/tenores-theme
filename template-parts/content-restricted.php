<?php

/**
 * Template part para exibir mensagem de conteúdo restrito.
 *
 * @package Tenores
 */

if (!defined('ABSPATH')) {
	exit;
}

// Obter variáveis passadas via set_query_var ou usar defaults
$title    = get_query_var('tenores_restricted_title', '');
$subtitle = get_query_var('tenores_restricted_subtitle', '');
$reason   = get_query_var('tenores_restricted_reason', 'not_logged_in');

// Se não foram passadas, usar defaults
if (empty($title)) {
	$title = __('Conteúdo Exclusivo para Membros', 'tenores');
}
if (empty($subtitle)) {
	$subtitle = __('Este conteúdo está disponível apenas para membros registrados. Faça login ou crie uma conta para acessar.', 'tenores');
}

// URLs
$account_url = class_exists('WooCommerce') ? wc_get_page_permalink('myaccount') : wp_login_url(get_permalink());

// URL do produto de assinatura para não-assinantes
$subscription_url = '';
if ($reason === 'not_subscriber' && function_exists('tenores_get_theme_settings')) {
	$settings = tenores_get_theme_settings();
	$subscription_product_id = !empty($settings['subscription_product_id']) ? absint($settings['subscription_product_id']) : 0;

	if ($subscription_product_id && function_exists('wc_get_product')) {
		$product = wc_get_product($subscription_product_id);
		if ($product) {
			$subscription_url = $product->get_permalink();
		}
	}
}
?>

<div class="container mx-auto my-10 sm:my-20">
	<div class="mx-auto max-w-3xl text-center">
		<div class="mb-8">
			<i data-lucide="lock" class="size-16 mx-auto text-primary mb-6"></i>
			<h1 class="text-3xl md:text-4xl font-extrabold text-dark mb-4">
				<?php echo esc_html($title); ?>
			</h1>
			<?php if (!empty($subtitle)) : ?>
				<p class="text-lg text-zinc-700 mb-8 leading-relaxed">
					<?php echo esc_html($subtitle); ?>
				</p>
			<?php endif; ?>
		</div>

		<div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
			<?php if ($reason === 'not_subscriber' && !empty($subscription_url)) : ?>
				<a
					href="<?php echo esc_url($subscription_url); ?>"
					class="primary-button px-8 py-3">
					<?php esc_html_e('Assinar Agora', 'tenores'); ?>
				</a>
			<?php elseif (class_exists('WooCommerce')) : ?>
				<a
					href="<?php echo esc_url($account_url); ?>"
					class="primary-button px-8 py-3">
					<?php esc_html_e('Fazer Login ou Criar Conta', 'tenores'); ?>
				</a>
			<?php else : ?>
				<a
					href="<?php echo esc_url(wp_login_url(get_permalink())); ?>"
					class="primary-button px-8 py-3">
					<?php esc_html_e('Fazer Login', 'tenores'); ?>
				</a>
			<?php endif; ?>

			<a
				href="<?php echo esc_url(home_url('/')); ?>"
				class="secondary-button px-8 py-3">
				<?php esc_html_e('Voltar para Home', 'tenores'); ?>
			</a>
		</div>
	</div>
</div>