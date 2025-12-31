<?php

/**
 * The template for displaying course content within loops.
 *
 * This template overrides the default Masteriyo content-course.php
 * to match the visual style of the WooCommerce product cards.
 *
 * @package Tenores
 */

defined('ABSPATH') || exit;

global $course;

if (empty($course) || !$course->is_visible()) {
	return;
}

$category  = tenores_get_masteriyo_course_category($course);
$image_url = tenores_get_masteriyo_course_image($course, 'large');
?>

<article class="bg-white rounded-3xl border border-dark overflow-hidden transition-shadow hover:shadow-lg">
	<div class="p-4">
		<a href="<?php echo esc_url($course->get_permalink()); ?>" class="block">
			<?php if ($image_url) : ?>
				<img
					src="<?php echo esc_url($image_url); ?>"
					alt="<?php echo esc_attr($course->get_name()); ?>"
					class="w-full aspect-square object-cover rounded-2xl" />
			<?php else : ?>
				<div class="w-full aspect-square bg-zinc-100 rounded-2xl flex items-center justify-center">
					<i data-lucide="book-open" class="size-12 text-zinc-300"></i>
				</div>
			<?php endif; ?>
		</a>
	</div>

	<div class="p-4 pt-0">
		<a href="<?php echo esc_url($course->get_permalink()); ?>" class="block !no-underline">
			<h3 class="font-bold text-dark text-lg leading-tight mb-2 !no-underline">
				<?php echo esc_html($course->get_name()); ?>
			</h3>
		</a>

		<?php if ($category) : ?>
			<span class="block text-primary text-sm font-semibold uppercase tracking-wide">
				<?php echo esc_html($category); ?>
			</span>
		<?php endif; ?>
	</div>
</article>

