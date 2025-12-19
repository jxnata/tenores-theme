<?php

/**
 * Single post template file.
 *
 * @package TailPress
 */

get_header();

if (have_posts()) {
	while (have_posts()) {
		the_post();
		$post_id = get_the_ID();

		// Verificar se o usuário tem acesso ao conteúdo
		if (!tenores_user_can_access_content($post_id)) {
			$settings = tenores_get_theme_settings();
			$title    = !empty($settings['member_access_title']) ? $settings['member_access_title'] : '';
			$subtitle = !empty($settings['member_access_subtitle']) ? $settings['member_access_subtitle'] : '';

			set_query_var('tenores_restricted_title', $title);
			set_query_var('tenores_restricted_subtitle', $subtitle);
			get_template_part('template-parts/content', 'restricted');

			get_footer();
			return;
		}
	}
	rewind_posts();
}
?>

<div class="container my-8 mx-auto">
	<?php if (have_posts()): ?>
		<?php while (have_posts()): the_post(); ?>
			<?php get_template_part('template-parts/content', 'single'); ?>

			<?php if (comments_open() || get_comments_number()): ?>
				<?php comments_template(); ?>
			<?php endif; ?>
		<?php endwhile; ?>
	<?php endif; ?>
</div>

<?php
get_footer();
