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
