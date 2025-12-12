<?php

/**
 * The template for displaying product content within loops.
 *
 * @package Tenores
 */

defined('ABSPATH') || exit;

global $product;

if (empty($product) || !$product->is_visible()) {
	return;
}

$category = tenores_get_product_category($product->get_id());
?>

<article <?php wc_product_class('bg-white rounded-3xl border border-dark overflow-hidden transition-shadow hover:shadow-lg', $product); ?>>
	<div class="p-4">
		<a href="<?php echo esc_url($product->get_permalink()); ?>" class="block">
			<?php if ($product->get_image_id()) : ?>
				<img
					src="<?php echo esc_url(wp_get_attachment_image_url($product->get_image_id(), 'large')); ?>"
					alt="<?php echo esc_attr($product->get_name()); ?>"
					class="w-full aspect-square object-cover rounded-2xl" />
			<?php else : ?>
				<div class="w-full aspect-square bg-zinc-100 rounded-2xl flex items-center justify-center">
					<i data-lucide="image" class="size-12 text-zinc-300"></i>
				</div>
			<?php endif; ?>
		</a>
	</div>

	<div class="p-4 pt-0">
		<a href="<?php echo esc_url($product->get_permalink()); ?>" class="block !no-underline">
			<h3 class="font-bold text-dark text-lg leading-tight mb-4 !no-underline">
				<?php echo esc_html($product->get_name()); ?>
			</h3>
		</a>

		<?php if ($category) : ?>
			<span class="text-primary text-sm font-semibold uppercase tracking-wide mb-3">
				<?php echo esc_html($category); ?>
			</span>
		<?php endif; ?>
	</div>
</article>