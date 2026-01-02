<?php

/**
 * Shortcodes do tema Tenores.
 *
 * @package Tenores
 */

/**
 * Shortcode para exibir a seção de oferta.
 *
 * @param array $atts Atributos do shortcode.
 * @return string HTML da seção de oferta.
 */
function tenores_offer_shortcode($atts = []): string
{
	ob_start();
	include get_template_directory() . '/template-parts/home/offer.php';
	return ob_get_clean();
}

add_shortcode('tenores_oferta', 'tenores_offer_shortcode');

/**
 * Shortcode para exibir posts apenas para membros.
 *
 * @param array $atts Atributos do shortcode.
 *   - posts: Número de posts a exibir (padrão: 5)
 *   - category: Slug da categoria (opcional)
 *   - tag: Slug da tag (opcional)
 * @return string HTML dos posts.
 */
function tenores_members_posts_shortcode($atts = []): string
{
	$atts = shortcode_atts([
		'posts'    => 5,
		'category' => '',
		'tag'      => '',
	], $atts, 'tenores_posts_membros');

	// Verificar se o usuário está logado
	if (!is_user_logged_in()) {
		$settings = tenores_get_theme_settings();
		$title    = !empty($settings['member_access_title']) ? $settings['member_access_title'] : '';
		$subtitle = !empty($settings['member_access_subtitle']) ? $settings['member_access_subtitle'] : '';

		ob_start();
		set_query_var('tenores_restricted_title', $title);
		set_query_var('tenores_restricted_subtitle', $subtitle);
		get_template_part('template-parts/content', 'restricted');
		return ob_get_clean();
	}

	$user_id = get_current_user_id();

	// Verificar se usuário tem compras (para posts de membros com compras)
	$has_purchases = tenores_user_has_purchases($user_id);

	// Construir meta query para posts de membros
	$meta_query = [
		'relation' => 'OR',
		[
			'key'     => TENORES_CONTENT_ACCESS_META,
			'value'   => TENORES_ACCESS_MEMBERS,
			'compare' => '=',
		],
	];

	// Se usuário tem compras, incluir também posts para membros com compras
	if ($has_purchases) {
		$meta_query[] = [
			'key'     => TENORES_CONTENT_ACCESS_META,
			'value'   => TENORES_ACCESS_PURCHASERS,
			'compare' => '=',
		];
	}

	// Query args
	$args = [
		'post_type'      => 'post',
		'posts_per_page' => absint($atts['posts']),
		'meta_query'     => $meta_query,
		'orderby'        => 'date',
		'order'          => 'DESC',
	];

	// Adicionar filtro por categoria se especificado
	if (!empty($atts['category'])) {
		$args['category_name'] = sanitize_text_field($atts['category']);
	}

	// Adicionar filtro por tag se especificado
	if (!empty($atts['tag'])) {
		$args['tag'] = sanitize_text_field($atts['tag']);
	}

	$query = new WP_Query($args);

	ob_start();

	if ($query->have_posts()) :
?>
		<div class="tenores-members-posts space-y-6 lg:space-y-12">
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<?php get_template_part('template-parts/content', ''); ?>
			<?php endwhile; ?>
		</div>
	<?php
		wp_reset_postdata();
	else :
	?>
		<p class="text-zinc-600">
			<?php esc_html_e('Nenhum post disponível para membros encontrado.', 'tenores'); ?>
		</p>
	<?php
	endif;

	return ob_get_clean();
}

add_shortcode('tenores_posts_membros', 'tenores_members_posts_shortcode');

/**
 * Shortcode para exibir cursos Masteriyo.
 *
 * @param array $atts Atributos do shortcode.
 *   - posts_per_page: Número de cursos por página (padrão: 9)
 *   - category: Slug da categoria (opcional)
 *   - price: Tipo de preço - "free" ou "paid" (opcional)
 *   - pagination: Exibir paginação - "true" ou "false" (padrão: "true")
 * @return string HTML dos cursos.
 */
function tenores_courses_shortcode($atts = []): string
{
	$atts = shortcode_atts([
		'posts_per_page' => 9,
		'category'       => '',
		'price'          => '',
		'pagination'     => 'true',
	], $atts, 'tenores_cursos');

	// Verifica se Masteriyo está ativo
	if (!function_exists('tenores_is_masteriyo_active') || !tenores_is_masteriyo_active()) {
		return '<p class="text-zinc-600">' . esc_html__('Masteriyo não está ativo.', 'tenores') . '</p>';
	}

	// Paginação
	$paged = isset($_GET['cursos_page']) ? max(1, absint($_GET['cursos_page'])) : 1;
	$posts_per_page = absint($atts['posts_per_page']);
	$offset = ($paged - 1) * $posts_per_page;

	// Query args para WP_Query (mais compatível)
	$query_args = [
		'post_type'      => 'mto-course',
		'post_status'    => 'publish',
		'posts_per_page' => $posts_per_page,
		'offset'         => $offset,
		'orderby'        => 'date',
		'order'          => 'DESC',
	];

	// Filtro por categoria
	if (!empty($atts['category'])) {
		$category_slug = sanitize_text_field($atts['category']);
		$query_args['tax_query'] = [
			[
				'taxonomy' => 'course_cat',
				'field'    => 'slug',
				'terms'    => $category_slug,
			],
		];
	}

	// Filtro por preço
	if (!empty($atts['price'])) {
		$price_filter = strtolower(sanitize_text_field($atts['price']));
		$meta_query = [];

		if ($price_filter === 'free') {
			$meta_query[] = [
				'key'     => '_price',
				'value'   => '0',
				'compare' => '=',
			];
		} elseif ($price_filter === 'paid') {
			$meta_query[] = [
				'key'     => '_price',
				'value'   => '0',
				'compare' => '>',
				'type'    => 'NUMERIC',
			];
		}

		if (!empty($meta_query)) {
			$query_args['meta_query'] = $meta_query;
		}
	}

	// Executa query
	$courses_query = new WP_Query($query_args);
	$total_pages = $courses_query->max_num_pages;

	ob_start();
	?>

	<div class="tenores-courses-shortcode">
		<?php if ($courses_query->have_posts()) : ?>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
				<?php
				while ($courses_query->have_posts()) :
					$courses_query->the_post();

					global $course;
					if (function_exists('masteriyo_get_course')) {
						$course = masteriyo_get_course(get_the_ID());
					}

					if ($course) {
						masteriyo_get_template('content-course.php');
					}
				endwhile;
				wp_reset_postdata();
				?>
			</div>

			<?php
			// Paginação
			$show_pagination = filter_var($atts['pagination'], FILTER_VALIDATE_BOOLEAN);
			if ($show_pagination && $total_pages > 1) :
				$base_url = get_permalink();
				if (!$base_url) {
					$base_url = home_url('/');
				}
			?>
				<nav class="mt-12 flex justify-center items-center gap-2">
					<?php if ($paged > 1) : ?>
						<a
							href="<?php echo esc_url(add_query_arg('cursos_page', $paged - 1, $base_url)); ?>"
							class="inline-flex items-center justify-center size-10 bg-dark hover:bg-dark/90 text-white font-semibold rounded-lg transition-colors">
							<i data-lucide="chevron-left" class="size-5"></i>
						</a>
					<?php endif; ?>

					<?php for ($i = 1; $i <= $total_pages; $i++) : ?>
						<?php if ($i === $paged) : ?>
							<span class="inline-flex items-center justify-center size-10 bg-primary text-white font-semibold rounded-lg">
								<?php echo esc_html($i); ?>
							</span>
						<?php else : ?>
							<a
								href="<?php echo esc_url(add_query_arg('cursos_page', $i, $base_url)); ?>"
								class="inline-flex items-center justify-center size-10 bg-white border border-dark/20 hover:bg-dark hover:text-white text-dark font-semibold rounded-lg transition-colors">
								<?php echo esc_html($i); ?>
							</a>
						<?php endif; ?>
					<?php endfor; ?>

					<?php if ($paged < $total_pages) : ?>
						<a
							href="<?php echo esc_url(add_query_arg('cursos_page', $paged + 1, $base_url)); ?>"
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

<?php
	return ob_get_clean();
}

add_shortcode('tenores_cursos', 'tenores_courses_shortcode');
