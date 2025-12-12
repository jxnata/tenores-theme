<?php

/**
 * The Template for displaying single products.
 *
 * @package Tenores
 */

defined('ABSPATH') || exit;

get_header();

global $product;

if (!$product || !is_a($product, 'WC_Product')) {
	$product = wc_get_product(get_the_ID());
}

if (!$product || !is_a($product, 'WC_Product')) {
	return;
}

$gallery_ids     = $product->get_gallery_image_ids();
$main_image_id   = $product->get_image_id();
$banner_image_id = !empty($gallery_ids) ? $gallery_ids[0] : $main_image_id;
$banner_url      = $banner_image_id ? wp_get_attachment_image_url($banner_image_id, 'full') : '';

$price         = $product->get_price();
$regular_price = $product->get_regular_price();
$sale_price    = $product->get_sale_price();

$sale_price_dates_from = get_post_meta($product->get_id(), '_sale_price_dates_from', true);
$sale_price_dates_to   = get_post_meta($product->get_id(), '_sale_price_dates_to', true);

$installment_value = $price ? wc_price($price / 12) : wc_price(0);
?>

<main>
	<section class="relative bg-dark py-24">
		<?php if ($banner_url) : ?>
			<div class="absolute inset-0">
				<img
					src="<?php echo esc_url($banner_url); ?>"
					alt="<?php echo esc_attr($product->get_name()); ?>"
					class="w-full h-full object-cover" />
				<div class="absolute inset-0 bg-gradient-to-r from-dark via-dark/80 to-dark/60"></div>
			</div>
		<?php endif; ?>

		<div class="relative container mx-auto">
			<div class="!text-white">
				<?php tenores_shop_breadcrumb(); ?>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-16">
				<div class="lg:col-span-2">
					<h1 class="text-3xl md:text-4xl font-extrabold text-white my-6">
						<?php echo esc_html($product->get_name()); ?>
					</h1>

					<?php if ($product->get_short_description()) : ?>
						<div class="text-white/90 text-lg mb-6 leading-relaxed">
							<?php echo wp_kses_post($product->get_short_description()); ?>
						</div>
					<?php endif; ?>

					<?php
					$course_duration = get_post_meta($product->get_id(), '_tenores_course_duration', true);
					if ($course_duration) :
					?>
						<div class="text-white/80 mb-8 flex items-center gap-2">
							<i data-lucide="clock" class="size-4 align-text-bottom"></i>
							<span><?php echo esc_html($course_duration); ?></span>
						</div>
					<?php endif; ?>

					<a
						href="<?php echo esc_url($product->add_to_cart_url()); ?>"
						class="primary-button px-12 py-4">
						<?php echo esc_html_e('Investir', 'tenores'); ?>
					</a>
				</div>

				<div class="lg:col-span-1 lg:absolute lg:top-64 lg:right-12 lg:max-w-xs shadow-2xl rounded-[2.5rem]">
					<div class="bg-dark p-6 pt-16 text-white relative overflow-hidden rounded-[2.5rem]">
						<div class="bg-secondary w-full h-10 absolute top-0 left-0"></div>

						<h3 class="font-extrabold text-lg mb-2">
							<?php esc_html_e('Investimento', 'tenores'); ?>
						</h3>

						<p class="text-sm mb-1">
							<?php esc_html_e('Valores válidos para 2026', 'tenores'); ?>
						</p>

						<p class="text-sm text-secondary mb-2">
							<?php esc_html_e('No cartão em até 12x de', 'tenores'); ?>
						</p>

						<p class="text-4xl md:text-5xl font-black text-white mb-2">
							<?php echo wp_kses_post($installment_value); ?>
						</p>

						<?php if ($sale_price && $regular_price && $regular_price > 0) : ?>
							<?php
							$discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
							?>
							<p class="text-sm text-secondary mb-2">
								<?php
								printf(
									esc_html__('Cupom de %d%% de desconto aplicado.', 'tenores'),
									$discount_percentage
								);
								?>
							</p>
						<?php endif; ?>


						<?php if ($sale_price && $regular_price) : ?>
							<p class="text-sm mb-4">
								<?php
								printf(
									esc_html__('Desconto de %s à vista', 'tenores'),
									wp_kses_post(wc_price((float) $regular_price - (float) $sale_price))
								);
								?>
							</p>
						<?php endif; ?>

						<?php if ($sale_price_dates_to && $sale_price_dates_from) : ?>
							<?php
							$date_from = date_i18n('d/m', $sale_price_dates_from);
							$date_to   = date_i18n('d/m', $sale_price_dates_to);
							?>
							<p class="text-xs mb-4">
								<?php
								printf(
									esc_html__('*Válido apenas para novas inscrições no período de %s a %s.', 'tenores'),
									esc_html($date_from),
									esc_html($date_to)
								);
								?>
							</p>
						<?php endif; ?>

						<a href="#" class="text-sm font-semibold underline mb-6 inline-block">
							<?php esc_html_e('Ver todas as opções de pagamento', 'tenores'); ?>
						</a>

						<a
							href="<?php echo esc_url($product->add_to_cart_url()); ?>"
							class="primary-button w-full">
							<?php esc_html_e('Investir', 'tenores'); ?>
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
					<?php echo wp_kses_post($product->get_description()); ?>
				</div>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
