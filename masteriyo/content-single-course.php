<?php

/**
 * The Template for displaying single course content.
 *
 * This template overrides the default Masteriyo content-single-course.php
 * to match the visual style of the WooCommerce single product page.
 *
 * @package Tenores
 */

defined('ABSPATH') || exit;

global $course;

if (empty($course) || !$course->is_visible()) {
	return;
}

$settings           = function_exists('tenores_get_theme_settings') ? tenores_get_theme_settings() : [];
$installments_count = !empty($settings['installments_count']) ? max(1, (int) $settings['installments_count']) : 12;

$banner_url    = tenores_get_masteriyo_course_image($course, 'full');
$price         = $course->get_price();
$regular_price = method_exists($course, 'get_regular_price') ? $course->get_regular_price() : $price;
$is_free       = tenores_is_masteriyo_course_free($course);
$duration      = tenores_get_masteriyo_course_duration($course);
$enroll_url    = tenores_get_masteriyo_enroll_url($course);

$is_logged_in = is_user_logged_in();
$button_text = '';

// Verifica controle de acesso do curso
$course_id = method_exists($course, 'get_id') ? $course->get_id() : 0;
$can_access_course = true;
$access_denial_reason = 'none';
$is_subscribers_only = false;
$subscription_product_url = '';
$subscription_product_price = '';
$subscription_product_regular_price = '';
$subscription_installment_value = '';

if ($course_id && function_exists('tenores_user_can_access_content')) {
	$can_access_course = tenores_user_can_access_content($course_id);

	if (!$can_access_course) {
		$access_denial_reason = function_exists('tenores_get_access_denial_reason') ? tenores_get_access_denial_reason($course_id) : 'not_logged_in';

		// Verifica se é apenas para assinantes
		if (function_exists('tenores_get_content_access')) {
			$access_level = tenores_get_content_access($course_id);
			$is_subscribers_only = ($access_level === 'subscribers');
		}

		// Se não é assinante, busca URL do produto de assinatura
		if ($access_denial_reason === 'not_subscriber' && $is_subscribers_only) {
			$settings = function_exists('tenores_get_theme_settings') ? tenores_get_theme_settings() : [];
			$subscription_product_id = !empty($settings['subscription_product_id']) ? absint($settings['subscription_product_id']) : 0;

			if ($subscription_product_id && function_exists('wc_get_product')) {
				$product = wc_get_product($subscription_product_id);
				if ($product) {
					$subscription_product_url = $product->get_permalink();
				}
			}
		}
	}
}

// Se usuário não está logado e curso é gratuito, busca preço do produto de assinatura
if (!$is_logged_in && $is_free) {
	$settings = function_exists('tenores_get_theme_settings') ? tenores_get_theme_settings() : [];
	$subscription_product_id = !empty($settings['subscription_product_id']) ? absint($settings['subscription_product_id']) : 0;

	if ($subscription_product_id && function_exists('wc_get_product')) {
		$subscription_product = wc_get_product($subscription_product_id);
		if ($subscription_product) {
			$subscription_product_price = $subscription_product->get_price();

			if ($subscription_product_price) {
				if (function_exists('masteriyo_price')) {
					$subscription_monthly_price = masteriyo_price($subscription_product_price);
				} elseif (function_exists('wc_price')) {
					$subscription_monthly_price = wc_price($subscription_product_price);
				} else {
					$subscription_monthly_price = 'R$ ' . number_format($subscription_product_price, 2, ',', '.');
				}
			}
		}
	}
}

$installment_value = '';
if (!$is_free && $price && $installments_count > 0) {
	if (function_exists('masteriyo_price')) {
		$installment_value = masteriyo_price($price / $installments_count);
	} elseif (function_exists('wc_price')) {
		$installment_value = wc_price($price / $installments_count);
	} else {
		$installment_value = 'R$ ' . number_format($price / $installments_count, 2, ',', '.');
	}
}
?>

<main>
	<section class="relative bg-dark py-24">
		<?php if ($banner_url) : ?>
			<div class="absolute inset-0">
				<img
					src="<?php echo esc_url($banner_url); ?>"
					alt="<?php echo esc_attr($course->get_name()); ?>"
					class="w-full h-full object-cover" />
				<div class="absolute inset-0 bg-gradient-to-r from-dark via-dark/80 to-dark/60"></div>
			</div>
		<?php endif; ?>

		<div class="relative container mx-auto">
			<div class="!text-white">
				<?php tenores_masteriyo_breadcrumb(); ?>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-16">
				<div class="lg:col-span-2">
					<h1 class="text-3xl md:text-4xl font-extrabold text-white my-6">
						<?php echo esc_html($course->get_name()); ?>
					</h1>

					<?php
					$short_description = tenores_get_masteriyo_short_description($course);

					if ($short_description) : ?>
						<div class="text-white/90 text-lg mb-6 leading-relaxed">
							<?php echo wp_kses_post($short_description); ?>
						</div>
					<?php endif; ?>

					<?php
					$formatted_duration = tenores_format_course_duration($duration);
					if ($formatted_duration) :
					?>
						<div class="text-white/80 mb-8 flex items-center gap-2">
							<i data-lucide="clock" class="size-4 align-text-bottom"></i>
							<span><?php echo esc_html($formatted_duration); ?></span>
						</div>
					<?php endif; ?>

					<?php
					// Se o curso é apenas para assinantes e o usuário não é assinante
					if ($is_subscribers_only && $access_denial_reason === 'not_subscriber') {
					?>
						<div class="mb-4 p-4 bg-yellow-500/20 border border-yellow-500/50 rounded-lg">
							<p class="text-white font-semibold mb-2">
								<?php esc_html_e('Este curso é exclusivo para assinantes', 'tenores'); ?>
							</p>
							<p class="text-white/90 text-sm mb-4">
								<?php esc_html_e('Você precisa ter uma assinatura ativa para se inscrever neste curso.', 'tenores'); ?>
							</p>
							<?php if ($subscription_product_url) : ?>
								<a
									href="<?php echo esc_url($subscription_product_url); ?>"
									class="primary-button px-12 py-4 inline-block">
									<?php esc_html_e('Assinar Agora', 'tenores'); ?>
								</a>
							<?php endif; ?>
						</div>
					<?php
					} else {
						if (tenores_is_user_enrolled_in_masteriyo_course($course->get_id())) {
							$button_text = __('Continuar', 'tenores');
						} elseif ($is_free) {
							if (!$is_logged_in) {
								$button_text = __('Quero meu acesso', 'tenores');
							} else {
								$button_text = __('Inscrever-se', 'tenores');
							}
						} else {
							$button_text = __('Investir', 'tenores');
						}
					?>
						<a
							href="<?php echo esc_url($enroll_url); ?>"
							class="button primary-button px-12 py-4 add_to_cart_button ajax_add_to_cart">
							<?php echo esc_html($button_text); ?>
						</a>
					<?php
					}
					?>
				</div>

				<div class="lg:col-span-1 lg:absolute lg:top-64 lg:right-12 lg:max-w-xs shadow-2xl rounded-[2.5rem]">
					<div class="bg-dark p-6 pt-16 text-white relative overflow-hidden rounded-[2.5rem]">
						<div class="bg-secondary w-full h-10 absolute top-0 left-0"></div>

						<h3 class="font-extrabold text-lg mb-2">
							<?php esc_html_e('Investimento', 'tenores'); ?>
						</h3>

						<?php if ($is_free && (!$is_logged_in && $subscription_product_price)) : ?>
							<p class="text-sm mb-1">
								<?php esc_html_e('Assinatura mensal de apenas', 'tenores'); ?>
							</p>

							<p class="text-4xl md:text-5xl font-black text-white mb-4">
								<?php echo wp_kses_post($subscription_monthly_price); ?>
							</p>
						<?php elseif ($is_free) : ?>
							<p class="text-4xl md:text-5xl font-black text-secondary mb-4">
								<?php esc_html_e('Gratuito', 'tenores'); ?>
							</p>
						<?php else : ?>
							<p class="text-sm mb-1">
								<?php esc_html_e('Valores válidos para 2026', 'tenores'); ?>
							</p>

							<p class="text-sm text-secondary mb-2">
								<?php
								printf(
									esc_html__('No cartão em até %dx de', 'tenores'),
									(int) $installments_count
								);
								?>
							</p>

							<p class="text-4xl md:text-5xl font-black text-white mb-2">
								<?php echo wp_kses_post($installment_value); ?>
							</p>

							<?php if ($regular_price && $price && $regular_price > $price) : ?>
								<?php
								$discount_percentage = round((($regular_price - $price) / $regular_price) * 100);
								?>
								<p class="text-sm text-secondary mb-2">
									<?php
									printf(
										esc_html__('Cupom de %d%% de desconto aplicado.', 'tenores'),
										$discount_percentage
									);
									?>
								</p>
								<p class="text-sm mb-4">
									<?php
									$discount_amount = $regular_price - $price;
									if (function_exists('masteriyo_price')) {
										$discount_display = masteriyo_price($discount_amount);
									} elseif (function_exists('wc_price')) {
										$discount_display = wc_price($discount_amount);
									} else {
										$discount_display = 'R$ ' . number_format($discount_amount, 2, ',', '.');
									}
									printf(
										esc_html__('Desconto de %s à vista', 'tenores'),
										wp_kses_post($discount_display)
									);
									?>
								</p>
							<?php endif; ?>
						<?php endif; ?>

						<?php
						if (!$can_access_course && $access_denial_reason === 'not_subscriber') {
							// Curso apenas para assinantes e usuário não é assinante
						?>
							<div class="mb-4 p-4 bg-yellow-500/20 border border-yellow-500/50 rounded-lg">
								<p class="text-white font-semibold mb-2 text-sm">
									<?php esc_html_e('Exclusivo para assinantes', 'tenores'); ?>
								</p>
								<p class="text-white/90 text-xs mb-4">
									<?php esc_html_e('Assine para ter acesso a este curso.', 'tenores'); ?>
								</p>
								<?php if ($subscription_product_url) : ?>
									<a
										href="<?php echo esc_url($subscription_product_url); ?>"
										class="primary-button w-full text-center block">
										<?php esc_html_e('Assinar Agora', 'tenores'); ?>
									</a>
								<?php endif; ?>
							</div>
						<?php
						} else {
							$is_logged_in = is_user_logged_in();
							$button_text_sidebar = '';

							if (tenores_is_user_enrolled_in_masteriyo_course($course->get_id())) {
								$button_text_sidebar = __('Continuar', 'tenores');
							} elseif ($is_free) {
								if (!$is_logged_in) {
									$button_text_sidebar = __('Quero meu acesso', 'tenores');
								} else {
									$button_text_sidebar = __('Inscrever-se', 'tenores');
								}
							} else {
								$button_text_sidebar = __('Investir', 'tenores');
							}
						?>
							<a
								href="<?php echo esc_url($enroll_url); ?>"
								class="primary-button w-full add_to_cart_button ajax_add_to_cart">
								<?php echo esc_html($button_text_sidebar); ?>
							</a>
						<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="py-16">
		<div class="container mx-auto">
			<div class="max-w-3xl">
				<div class="prose prose-lg text-dark [&_h1]:mt-4 [&_h1]:mb-2 [&_h1]:text-3xl [&_h2]:text-2xl [&_h3]:text-xl [&_h4]:text-lg [&_h5]:text-base [&_h6]:text-sm [&_p]:mb-6">
					<?php echo wp_kses_post($course->get_description()); ?>
				</div>

				<!-- <?php
						// Course highlights if available
						if (method_exists($course, 'get_highlights') && $course->get_highlights()) :
							$highlights = $course->get_highlights();
						?>
					<div class="mt-12">
						<h2 class="text-2xl font-bold text-dark mb-6">
							<?php esc_html_e('O que você vai aprender', 'tenores'); ?>
						</h2>
						<div class="prose prose-lg text-dark">
							<?php echo wp_kses_post($highlights); ?>
						</div>
					</div>
				<?php endif; ?>

				<?php
				// Course curriculum if available
				if (function_exists('masteriyo_get_template')) :
				?>
					<div class="mt-12">
						<h2 class="text-2xl font-bold text-dark mb-6">
							<?php esc_html_e('Conteúdo do Curso', 'tenores'); ?>
						</h2>
						<?php
						/**
						 * Action hook for rendering course curriculum.
						 *
						 * @since 1.0.0
						 */
						do_action('masteriyo_single_course_curriculum', $course);
						?>
					</div>
				<?php endif; ?> -->
			</div>
		</div>
	</section>
</main>