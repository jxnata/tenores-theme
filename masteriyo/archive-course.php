<?php

/**
 * The Template for displaying course archives.
 *
 * This template overrides the default Masteriyo archive-course.php
 * to match the visual style of the WooCommerce product archive.
 *
 * @package Tenores
 */

defined('ABSPATH') || exit;

get_header();

// Usa as mesmas configurações de curso em destaque do WooCommerce
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

		<?php tenores_masteriyo_breadcrumb(); ?>

		<h1 class="my-12 text-center text-primary text-4xl font-black uppercase tracking-tight [text-wrap:balance] sm:text-5xl md:text-6xl">
			<?php
			if (function_exists('masteriyo_page_title')) {
				masteriyo_page_title();
			} else {
				esc_html_e('Cursos', 'tenores');
			}
			?>
		</h1>

		<?php if (have_posts()) : ?>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
				<?php
				while (have_posts()) :
					the_post();

					global $course;
					if (function_exists('masteriyo_get_course')) {
						$course = masteriyo_get_course(get_the_ID());
					}

					if ($course) {
						masteriyo_get_template('content-course.php');
					}
				endwhile;
				?>
			</div>

			<?php
			$total_pages = $GLOBALS['wp_query']->max_num_pages ?? 1;
			if ($total_pages > 1) :
				$current_page = max(1, get_query_var('paged'));
			?>
				<nav class="mt-12 flex justify-center items-center gap-2">
					<?php if ($current_page > 1) : ?>
						<a
							href="<?php echo esc_url(get_pagenum_link($current_page - 1)); ?>"
							class="inline-flex items-center justify-center size-10 bg-dark hover:bg-dark/90 text-white font-semibold rounded-lg transition-colors">
							<i data-lucide="chevron-left" class="size-5"></i>
						</a>
					<?php endif; ?>

					<?php for ($i = 1; $i <= $total_pages; $i++) : ?>
						<?php if ($i === $current_page) : ?>
							<span class="inline-flex items-center justify-center size-10 bg-primary text-white font-semibold rounded-lg">
								<?php echo esc_html($i); ?>
							</span>
						<?php else : ?>
							<a
								href="<?php echo esc_url(get_pagenum_link($i)); ?>"
								class="inline-flex items-center justify-center size-10 bg-white border border-dark/20 hover:bg-dark hover:text-white text-dark font-semibold rounded-lg transition-colors">
								<?php echo esc_html($i); ?>
							</a>
						<?php endif; ?>
					<?php endfor; ?>

					<?php if ($current_page < $total_pages) : ?>
						<a
							href="<?php echo esc_url(get_pagenum_link($current_page + 1)); ?>"
							class="inline-flex items-center justify-center size-10 bg-dark hover:bg-dark/90 text-white font-semibold rounded-lg transition-colors">
							<i data-lucide="chevron-right" class="size-5"></i>
						</a>
					<?php endif; ?>
				</nav>
			<?php endif; ?>

		<?php else : ?>

			<p class="text-zinc-600 text-center">
				<?php esc_html_e('Nenhum curso encontrado.', 'tenores'); ?>
			</p>

		<?php endif; ?>

	</div>
</main>

<?php
get_footer();

