<?php

/**
 * The Template for displaying product archives.
 *
 * @package Tenores
 */

defined('ABSPATH') || exit;

get_header();

$featured_course = tenores_get_featured_course();
?>

<main class="bg-light min-h-screen pt-24 pb-16">
	<div class="container mx-auto">

		<?php if (!empty($featured_course['banner'])) : ?>
			<section class="relative rounded-3xl overflow-hidden mb-12">
				<img
					src="<?php echo esc_url($featured_course['banner']); ?>"
					alt="<?php echo esc_attr($featured_course['title']); ?>"
					class="w-full h-[500px] object-cover" />

				<div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>

				<div class="absolute inset-0 flex items-center">
					<div class="container mx-auto px-8 md:px-16 flex justify-end">
						<div class="max-w-xl">
							<?php if (!empty($featured_course['title'])) : ?>
								<h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
									<?php echo esc_html($featured_course['title']); ?>
								</h2>
							<?php endif; ?>

							<?php if (!empty($featured_course['subtitle'])) : ?>
								<p class="text-white/90 text-lg mb-6 leading-tight font-medium">
									<?php echo esc_html($featured_course['subtitle']); ?>
								</p>
							<?php endif; ?>

							<a
								href="<?php echo esc_url($featured_course['url'] ?? ($featured_course['course']->get_permalink() ?? '#')); ?>"
								class="primary-button">
								<?php esc_html_e('Inscreva-se agora', 'tenores'); ?>
							</a>
						</div>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php tenores_shop_breadcrumb(); ?>

		<h1 class="my-12 text-center text-primary text-4xl font-black uppercase tracking-tight [text-wrap:balance] sm:text-5xl md:text-6xl">
			<?php echo esc_html(woocommerce_page_title(false)); ?>
		</h1>

		<?php if (woocommerce_product_loop()) : ?>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
				<?php
				while (have_posts()) :
					the_post();
					wc_get_template_part('content', 'product');
				endwhile;
				?>
			</div>

			<?php if (wc_get_loop_prop('total_pages') > 1) : ?>
				<div class="mt-12">
					<a
						href="<?php echo esc_url(add_query_arg('paged', max(1, get_query_var('paged')) + 1)); ?>"
						class="inline-block bg-primary hover:bg-primary/90 text-white font-semibold py-3 px-8 rounded-lg transition-colors">
						<?php esc_html_e('Mostrar mais', 'tenores'); ?>
					</a>
				</div>
			<?php endif; ?>

		<?php else : ?>

			<p class="text-zinc-600">
				<?php esc_html_e('Nenhum curso encontrado.', 'tenores'); ?>
			</p>

		<?php endif; ?>

	</div>
</main>

<?php
get_footer();
