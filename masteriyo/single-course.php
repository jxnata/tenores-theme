<?php

/**
 * The Template for displaying single course.
 *
 * This template overrides the default Masteriyo single-course.php
 * to use the theme's header and footer.
 *
 * @package Tenores
 */

defined('ABSPATH') || exit;

get_header();

global $course;

$course_id = get_the_ID();

if (function_exists('masteriyo_get_course')) {
	$course = masteriyo_get_course($course_id);
}

if (!$course) {
	get_footer();
	return;
}

// Check access control (Tenores theme system)
if (function_exists('tenores_user_can_access_content') && !tenores_user_can_access_content($course_id)) {
	$settings = function_exists('tenores_get_theme_settings') ? tenores_get_theme_settings() : [];
	$denial_reason = function_exists('tenores_get_access_denial_reason') ? tenores_get_access_denial_reason($course_id) : 'not_logged_in';

	// Define title and subtitle based on denial reason
	if ($denial_reason === 'not_subscriber') {
		$title    = !empty($settings['subscriber_access_title']) ? $settings['subscriber_access_title'] : __('Conteúdo Exclusivo para Assinantes', 'tenores');
		$subtitle = !empty($settings['subscriber_access_subtitle']) ? $settings['subscriber_access_subtitle'] : __('Este conteúdo está disponível apenas para assinantes. Assine agora para ter acesso completo.', 'tenores');
	} else {
		$title    = !empty($settings['member_access_title']) ? $settings['member_access_title'] : __('Conteúdo Exclusivo para Membros', 'tenores');
		$subtitle = !empty($settings['member_access_subtitle']) ? $settings['member_access_subtitle'] : __('Este conteúdo está disponível apenas para membros registrados. Faça login ou crie uma conta para acessar.', 'tenores');
	}

	set_query_var('tenores_restricted_title', $title);
	set_query_var('tenores_restricted_subtitle', $subtitle);
	set_query_var('tenores_restricted_reason', $denial_reason);
	get_template_part('template-parts/content', 'restricted');

	get_footer();
	return;
}

// Fallback: Check if user must login to view course (Masteriyo native check)
if (function_exists('masteriyo_user_must_login_to_view_course') && masteriyo_user_must_login_to_view_course($course_id)) {
	$settings = function_exists('tenores_get_theme_settings') ? tenores_get_theme_settings() : [];
	$title    = !empty($settings['member_access_title']) ? $settings['member_access_title'] : '';
	$subtitle = !empty($settings['member_access_subtitle']) ? $settings['member_access_subtitle'] : '';

	set_query_var('tenores_restricted_title', $title);
	set_query_var('tenores_restricted_subtitle', $subtitle);
	set_query_var('tenores_restricted_reason', 'not_logged_in');
	get_template_part('template-parts/content', 'restricted');

	get_footer();
	return;
}

masteriyo_get_template('content-single-course.php');

get_footer();

