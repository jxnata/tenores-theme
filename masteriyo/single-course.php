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

masteriyo_get_template('content-single-course.php');

get_footer();
