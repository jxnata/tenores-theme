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

global $course;
$course_id = get_the_ID();

if (function_exists('masteriyo_get_course')) {
	$course = masteriyo_get_course($course_id);
}

// Verifica controle de acesso do tema Tenores (members, subscribers)
if (function_exists('tenores_user_can_access_content') && !tenores_user_can_access_content($course_id)) {
	$denial_reason = function_exists('tenores_get_access_denial_reason') ? tenores_get_access_denial_reason($course_id) : 'not_logged_in';

	if ($denial_reason === 'not_logged_in') {
		// Usuário não está logado, redireciona para login
		wp_redirect(wc_get_page_permalink('myaccount'));
		exit;
	}

	// Usuário está logado mas não tem permissão (não é assinante)
	// Redireciona para o produto de assinatura configurado no tema
	if ($denial_reason === 'not_subscriber') {
		$settings = function_exists('tenores_get_theme_settings') ? tenores_get_theme_settings() : [];
		$subscription_product_id = !empty($settings['subscription_product_id']) ? absint($settings['subscription_product_id']) : 0;

		if ($subscription_product_id && function_exists('wc_get_product')) {
			$product = wc_get_product($subscription_product_id);
			if ($product) {
				wp_redirect($product->get_permalink());
				exit;
			}
		}
	}

	// Fallback: redireciona para a página do curso se não houver produto de assinatura configurado
	if ($course) {
		wp_redirect($course->get_permalink());
		exit;
	}

	wp_redirect(home_url());
	exit;
}

// Verifica se o usuário está inscrito no curso
if ($course && !tenores_is_user_enrolled_in_masteriyo_course($course_id)) {
	// Não está inscrito, redireciona para a página do curso
	wp_redirect($course->get_permalink());
	exit;
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