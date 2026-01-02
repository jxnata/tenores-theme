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
				</div>

				<div class="lg:col-span-1 lg:absolute lg:top-64 lg:right-12 lg:max-w-xs shadow-2xl rounded-[2.5rem]">
					<div class="bg-dark p-6 pt-16 text-white relative overflow-hidden rounded-[2.5rem]">
						<div class="bg-secondary w-full h-10 absolute top-0 left-0"></div>

						<h3 class="font-extrabold text-lg mb-2">
							<?php esc_html_e('Investimento', 'tenores'); ?>
						</h3>

						<?php if ($is_free) : ?>
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

						<a href="#" class="text-sm font-semibold underline mb-6 inline-block">
							<?php esc_html_e('Ver todas as opções de pagamento', 'tenores'); ?>
						</a>

						<?php
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