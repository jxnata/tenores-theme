<?php

/**
 * My Account Dashboard
 *
 * Shows the dashboard content on the my account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * @package    Tenores
 * @version    9.5.0
 */

defined('ABSPATH') || exit;

$current_user = wp_get_current_user();
$settings = function_exists('tenores_get_theme_settings') ? tenores_get_theme_settings() : [];

// Check if user has active subscription
$has_subscription = false;
if (function_exists('tenores_user_has_active_subscription')) {
	$has_subscription = tenores_user_has_active_subscription($current_user->ID);
}

// Get subscription product URL
$subscription_url = '';
$subscription_product_id = !empty($settings['subscription_product_id']) ? absint($settings['subscription_product_id']) : 0;

if ($subscription_product_id && function_exists('wc_get_product')) {
	$product = wc_get_product($subscription_product_id);
	if ($product) {
		$subscription_url = $product->get_permalink();
	}
}

// Get courses page URL
$courses_url = '';
$courses_page_id = !empty($settings['courses_page_id']) ? absint($settings['courses_page_id']) : 0;

if ($courses_page_id) {
	$courses_url = get_permalink($courses_page_id);
}

// Fallback to Masteriyo courses page
if (empty($courses_url) && function_exists('masteriyo_get_page_permalink')) {
	$courses_url = masteriyo_get_page_permalink('courses');
}

// Get messages from settings
if ($has_subscription) {
	$title = !empty($settings['myaccount_subscriber_title'])
		? $settings['myaccount_subscriber_title']
		: __('Bem-vindo, Assinante!', 'tenores');

	$message = !empty($settings['myaccount_subscriber_message'])
		? $settings['myaccount_subscriber_message']
		: __('Você já é um assinante ativo. Aproveite todos os cursos e conteúdos exclusivos disponíveis.', 'tenores');
} else {
	$title = !empty($settings['myaccount_non_subscriber_title'])
		? $settings['myaccount_non_subscriber_title']
		: __('Seja um Assinante!', 'tenores');

	$message = !empty($settings['myaccount_non_subscriber_message'])
		? $settings['myaccount_non_subscriber_message']
		: __('Assine agora e tenha acesso a todos os cursos e conteúdos exclusivos da plataforma.', 'tenores');
}
?>

<div class="tenores-dashboard py-8">
	<div class="text-center max-w-2xl mx-auto">
		<?php if ($has_subscription) : ?>
			<div class="mb-6">
				<i data-lucide="badge-check" class="size-16 mx-auto text-green-500 mb-4"></i>
			</div>

			<h2 class="text-2xl md:text-3xl font-bold text-dark mb-4">
				<?php echo esc_html($title); ?>
			</h2>

			<p class="text-lg text-zinc-600 mb-6 leading-relaxed">
				<?php echo esc_html($message); ?>
			</p>

			<?php if (!empty($courses_url)) : ?>
				<div class="mb-8">
					<a href="<?php echo esc_url($courses_url); ?>" class="primary-button inline-flex items-center gap-2 px-8 py-3">
						<i data-lucide="play-circle" class="size-5"></i>
						<?php esc_html_e('Acessar Cursos', 'tenores'); ?>
					</a>
				</div>
			<?php endif; ?>

			<div class="bg-light rounded-lg p-6 text-left">
				<h3 class="font-semibold text-dark mb-4">
					<?php esc_html_e('Navegação Rápida', 'tenores'); ?>
				</h3>
				<ul class="space-y-3 text-zinc-600">
					<li class="flex items-start gap-3">
						<i data-lucide="book-open" class="size-5 text-primary mt-0.5 flex-shrink-0"></i>
						<span>
							<strong><?php esc_html_e('Cursos:', 'tenores'); ?></strong>
							<?php esc_html_e('Na aba Cursos você pode continuar assistindo seus cursos e acompanhar seu progresso.', 'tenores'); ?>
						</span>
					</li>
					<li class="flex items-start gap-3">
						<i data-lucide="credit-card" class="size-5 text-primary mt-0.5 flex-shrink-0"></i>
						<span>
							<strong><?php esc_html_e('Assinaturas:', 'tenores'); ?></strong>
							<?php esc_html_e('Na aba Assinaturas você pode gerenciar sua assinatura, ver detalhes e renovação.', 'tenores'); ?>
						</span>
					</li>
					<li class="flex items-start gap-3">
						<i data-lucide="user" class="size-5 text-primary mt-0.5 flex-shrink-0"></i>
						<span>
							<strong><?php esc_html_e('Conta:', 'tenores'); ?></strong>
							<?php esc_html_e('Você pode editar seus dados pessoais, endereço e alterar sua senha nas abas correspondentes.', 'tenores'); ?>
						</span>
					</li>
				</ul>
			</div>

		<?php else : ?>
			<div class="mb-6">
				<i data-lucide="sparkles" class="size-16 mx-auto text-primary mb-4"></i>
			</div>

			<h2 class="text-2xl md:text-3xl font-bold text-dark mb-4">
				<?php echo esc_html($title); ?>
			</h2>

			<p class="text-lg text-zinc-600 mb-8 leading-relaxed">
				<?php echo esc_html($message); ?>
			</p>

			<?php if (!empty($subscription_url)) : ?>
				<div class="mb-8">
					<a href="<?php echo esc_url($subscription_url); ?>" class="primary-button inline-flex items-center gap-2 px-8 py-3">
						<i data-lucide="crown" class="size-5"></i>
						<?php esc_html_e('Assinar Agora', 'tenores'); ?>
					</a>
				</div>
			<?php endif; ?>

			<div class="bg-light rounded-lg p-6 text-left">
				<h3 class="font-semibold text-dark mb-4">
					<?php esc_html_e('O que você pode fazer aqui', 'tenores'); ?>
				</h3>
				<ul class="space-y-3 text-zinc-600">
					<li class="flex items-center gap-3">
						<i data-lucide="user" class="size-5 text-primary mt-0.5 flex-shrink-0"></i>
						<span class="mt-0">
							<?php esc_html_e('Editar seus dados pessoais e informações de perfil.', 'tenores'); ?>
						</span>
					</li>
					<li class="flex items-center gap-3">
						<i data-lucide="map-pin" class="size-5 text-primary mt-0.5 flex-shrink-0"></i>
						<span class="mt-0">
							<?php esc_html_e('Atualizar seus endereços de entrega e cobrança.', 'tenores'); ?>
						</span>
					</li>
					<li class="flex items-center gap-3">
						<i data-lucide="shopping-bag" class="size-5 text-primary mt-0.5 flex-shrink-0"></i>
						<span class="mt-0">
							<?php esc_html_e('Visualizar seu histórico de pedidos.', 'tenores'); ?>
						</span>
					</li>
				</ul>
			</div>
		<?php endif; ?>
	</div>
</div>