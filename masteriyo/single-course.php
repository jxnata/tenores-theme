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

// Check if user must login to view course
if (function_exists('masteriyo_user_must_login_to_view_course') && masteriyo_user_must_login_to_view_course($course_id)) {
	$settings = function_exists('tenores_get_theme_settings') ? tenores_get_theme_settings() : [];
	$title    = !empty($settings['member_access_title']) ? $settings['member_access_title'] : '';
	$subtitle = !empty($settings['member_access_subtitle']) ? $settings['member_access_subtitle'] : '';

	set_query_var('tenores_restricted_title', $title);
	set_query_var('tenores_restricted_subtitle', $subtitle);
	get_template_part('template-parts/content', 'restricted');

	get_footer();
	return;
}

masteriyo_get_template('content-single-course.php');

get_footer();

