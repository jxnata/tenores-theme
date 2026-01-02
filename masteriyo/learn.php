<?php

/**
 * Learn page template.
 *
 * This template overrides the default Masteriyo learn.php
 * to match the theme's visual identity.
 *
 * @package Tenores
 */

defined('ABSPATH') || exit;

// Verifica se o usuário está logado para acessar a página de aprendizado
if (!is_user_logged_in()) {
	wp_redirect(wc_get_page_permalink('myaccount'));
	exit;
}

// Verifica se o curso é gratuito e se o usuário está inscrito
global $course;
$course_id = get_the_ID();

if (function_exists('masteriyo_get_course')) {
	$course = masteriyo_get_course($course_id);
}

if ($course && tenores_is_masteriyo_course_free($course)) {
	if (!tenores_is_user_enrolled_in_masteriyo_course($course_id)) {
		// Se é gratuito e não está inscrito, redireciona para a página do curso
		wp_redirect($course->get_permalink());
		exit;
	}
}
?>
<!DOCTYPE html>
<html lang="<?php echo esc_attr(get_locale()); ?>" <?php echo is_rtl() ? 'dir="rtl"' : ''; ?>>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php the_title(); ?></title>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> translate="no">
	<div id="masteriyo-interactive-course"></div>
	<?php wp_footer(); ?>
</body>

</html>