<?php

/**
 * Masteriyo LMS support for Tenores theme.
 *
 * @package Tenores
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Check if Masteriyo is active.
 */
function tenores_is_masteriyo_active(): bool
{
	return class_exists('Masteriyo\Masteriyo') || defined('MASTERIYO_VERSION');
}

/**
 * Declare Masteriyo theme support.
 */
function tenores_masteriyo_setup(): void
{
	if (!tenores_is_masteriyo_active()) {
		return;
	}

	add_theme_support('masteriyo');
}

add_action('after_setup_theme', 'tenores_masteriyo_setup');

/**
 * Remove default Masteriyo styles.
 */
function tenores_dequeue_masteriyo_styles(): void
{
	if (!tenores_is_masteriyo_active()) {
		return;
	}

	wp_dequeue_style('masteriyo-public');
	wp_dequeue_style('masteriyo-single-course');
	wp_dequeue_style('masteriyo-course-archive');
}

add_action('wp_enqueue_scripts', 'tenores_dequeue_masteriyo_styles', 100);

/**
 * Custom breadcrumb for Masteriyo course pages.
 */
function tenores_masteriyo_breadcrumb(): void
{
	$home_url    = home_url('/');
	$courses_url = function_exists('masteriyo_get_page_permalink') ? masteriyo_get_page_permalink('courses') : home_url('/courses/');

	echo '<nav class="text-sm font-semibold mb-6 [&_a]:transition-all [&_a]:duration-300">';
	echo '<a href="' . esc_url($home_url) . '" class="hover:text-primary !no-underline"><i data-lucide="home" class="inline-block size-4 align-text-bottom"></i></a>';
	echo ' <span class="mx-2"><i data-lucide="chevron-right" class="inline-block size-4 align-text-bottom"></i></span> ';

	if (is_singular('mto-course')) {
		echo '<a href="' . esc_url($courses_url) . '" class="hover:text-primary !no-underline">' . esc_html__('Cursos', 'tenores') . '</a>';

		global $course;
		if ($course && method_exists($course, 'get_categories')) {
			$categories = $course->get_categories();
			if (!empty($categories)) {
				$category = is_array($categories) ? reset($categories) : $categories;
				if (is_object($category) && isset($category->name)) {
					echo ' <span class="mx-2"><i data-lucide="chevron-right" class="inline-block size-4 align-text-bottom"></i></span> ';
					$term_link = get_term_link($category);
					if (!is_wp_error($term_link)) {
						echo '<a href="' . esc_url($term_link) . '" class="hover:text-primary !no-underline">' . esc_html($category->name) . '</a>';
					} else {
						echo '<span>' . esc_html($category->name) . '</span>';
					}
				}
			}
		}
	} else {
		echo '<span class="font-semibold">' . esc_html__('Cursos', 'tenores') . '</span>';
	}

	echo '</nav>';
}

/**
 * Get primary course category.
 */
function tenores_get_masteriyo_course_category($course): string
{
	if (!$course) {
		return '';
	}

	// Tenta obter categorias via método get_categories('name') que retorna array de nomes
	if (method_exists($course, 'get_categories')) {
		$categories = $course->get_categories('name');

		if (!empty($categories)) {
			if (is_array($categories)) {
				$category = reset($categories);
				if (is_string($category)) {
					return $category;
				}
				if (is_object($category) && isset($category->name)) {
					return $category->name;
				}
			}
			if (is_string($categories)) {
				return $categories;
			}
		}

		// Tenta sem parâmetro
		$categories = $course->get_categories();
		if (!empty($categories)) {
			$category = is_array($categories) ? reset($categories) : $categories;
			if (is_object($category) && isset($category->name)) {
				return $category->name;
			}
			if (is_string($category)) {
				return $category;
			}
		}
	}

	// Fallback: busca via taxonomia do WordPress
	if (method_exists($course, 'get_id')) {
		$terms = get_the_terms($course->get_id(), 'course_cat');
		if ($terms && !is_wp_error($terms)) {
			return $terms[0]->name;
		}
	}

	return '';
}

/**
 * Get course featured image URL.
 */
function tenores_get_masteriyo_course_image($course, string $size = 'large'): string
{
	if (!$course) {
		return '';
	}

	$image_id = 0;

	if (method_exists($course, 'get_featured_image')) {
		$image_id = $course->get_featured_image();
	} elseif (method_exists($course, 'get_image_id')) {
		$image_id = $course->get_image_id();
	}

	if ($image_id) {
		$url = wp_get_attachment_image_url($image_id, $size);
		if ($url) {
			return $url;
		}
	}

	// Fallback to post thumbnail
	if (method_exists($course, 'get_id')) {
		$thumbnail_url = get_the_post_thumbnail_url($course->get_id(), $size);
		if ($thumbnail_url) {
			return $thumbnail_url;
		}
	}

	return '';
}

/**
 * Get course price display.
 */
function tenores_get_masteriyo_course_price($course): string
{
	if (!$course) {
		return '';
	}

	if (method_exists($course, 'get_price')) {
		$price = $course->get_price();

		if (empty($price) || $price == 0) {
			return __('Gratuito', 'tenores');
		}

		if (function_exists('masteriyo_price')) {
			return masteriyo_price($price);
		}

		return wc_price($price);
	}

	return '';
}

/**
 * Check if course is free.
 */
function tenores_is_masteriyo_course_free($course): bool
{
	if (!$course || !method_exists($course, 'get_price')) {
		return false;
	}

	$price = $course->get_price();
	return empty($price) || $price == 0;
}

/**
 * Get course duration in minutes.
 */
function tenores_get_masteriyo_course_duration($course): string
{
	if (!$course) {
		return '';
	}

	if (method_exists($course, 'get_duration')) {
		return $course->get_duration();
	}

	return '';
}

/**
 * Format course duration from minutes to hours and minutes.
 *
 * @param int|string $minutes Duration in minutes.
 * @return string Formatted duration (e.g., "1 hora e 15 minutos").
 */
function tenores_format_course_duration($minutes): string
{
	$minutes = (int) $minutes;

	if ($minutes <= 0) {
		return '';
	}

	$hours = floor($minutes / 60);
	$remaining_minutes = $minutes % 60;

	$parts = [];

	if ($hours > 0) {
		$parts[] = sprintf(
			_n('%d hora', '%d horas', $hours, 'tenores'),
			$hours
		);
	}

	if ($remaining_minutes > 0) {
		$parts[] = sprintf(
			_n('%d minuto', '%d minutos', $remaining_minutes, 'tenores'),
			$remaining_minutes
		);
	}

	if (empty($parts)) {
		return '';
	}

	return implode(' e ', $parts);
}

/**
 * Get featured Masteriyo course settings.
 */
function tenores_get_featured_masteriyo_course(): array
{
	$settings = tenores_get_theme_settings();

	$course_id = !empty($settings['featured_masteriyo_course']) ? absint($settings['featured_masteriyo_course']) : 0;
	$banner_id = !empty($settings['featured_masteriyo_banner']) ? absint($settings['featured_masteriyo_banner']) : 0;
	$title     = !empty($settings['featured_masteriyo_title']) ? $settings['featured_masteriyo_title'] : '';
	$subtitle  = !empty($settings['featured_masteriyo_subtitle']) ? $settings['featured_masteriyo_subtitle'] : '';

	if (!$course_id || !tenores_is_masteriyo_active()) {
		return [];
	}

	if (!function_exists('masteriyo_get_course')) {
		return [];
	}

	$course = masteriyo_get_course($course_id);

	if (!$course) {
		return [];
	}

	$banner_url = $banner_id ? wp_get_attachment_image_url($banner_id, 'full') : '';

	return [
		'course'   => $course,
		'banner'   => $banner_url,
		'title'    => $title,
		'subtitle' => $subtitle,
	];
}

/**
 * Get course enroll button URL.
 */
function tenores_get_masteriyo_enroll_url($course): string
{
	if (!$course) {
		return '#';
	}

	if (method_exists($course, 'get_permalink')) {
		return $course->get_permalink();
	}

	if (method_exists($course, 'get_id')) {
		return get_permalink($course->get_id());
	}

	return '#';
}

/**
 * Check if user is enrolled in course.
 */
function tenores_is_user_enrolled_in_masteriyo_course($course_id): bool
{
	if (!is_user_logged_in() || !function_exists('masteriyo_is_user_already_enrolled')) {
		return false;
	}

	return masteriyo_is_user_already_enrolled(get_current_user_id(), $course_id);
}

/**
 * Add custom meta box for course short description.
 */
function tenores_add_course_meta_box(): void
{
	add_meta_box(
		'tenores_course_details',
		__('Detalhes do Curso (Tenores)', 'tenores'),
		'tenores_render_course_meta_box',
		'mto-course',
		'normal',
		'high'
	);
}

add_action('add_meta_boxes', 'tenores_add_course_meta_box');

/**
 * Render the course meta box.
 */
function tenores_render_course_meta_box($post): void
{
	wp_nonce_field('tenores_course_meta_box', 'tenores_course_meta_box_nonce');

	$short_description = get_post_meta($post->ID, '_tenores_course_short_description', true);
?>
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="tenores_course_short_description">
					<?php esc_html_e('Descrição Curta', 'tenores'); ?>
				</label>
			</th>
			<td>
				<textarea
					id="tenores_course_short_description"
					name="tenores_course_short_description"
					rows="4"
					class="large-text"
					placeholder="<?php esc_attr_e('Digite uma descrição curta para o curso...', 'tenores'); ?>"><?php echo esc_textarea($short_description); ?></textarea>
				<p class="description">
					<?php esc_html_e('Esta descrição será exibida no header da página do curso, abaixo do título.', 'tenores'); ?>
				</p>
			</td>
		</tr>
	</table>
<?php
}

/**
 * Save course meta box data.
 */
function tenores_save_course_meta_box($post_id): void
{
	if (!isset($_POST['tenores_course_meta_box_nonce'])) {
		return;
	}

	if (!wp_verify_nonce($_POST['tenores_course_meta_box_nonce'], 'tenores_course_meta_box')) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (isset($_POST['tenores_course_short_description'])) {
		update_post_meta(
			$post_id,
			'_tenores_course_short_description',
			sanitize_textarea_field($_POST['tenores_course_short_description'])
		);
	}
}

add_action('save_post_mto-course', 'tenores_save_course_meta_box');

/**
 * Add Cursos menu item to WordPress admin.
 */
function tenores_add_cursos_admin_menu(): void
{
	add_menu_page(
		__('Cursos', 'tenores'),
		__('Cursos', 'tenores'),
		'edit_posts',
		'edit.php?post_type=mto-course',
		'',
		'dashicons-welcome-learn-more',
		25
	);
}

add_action('admin_menu', 'tenores_add_cursos_admin_menu');

/**
 * Add "Editar Conteúdo" link to course row actions.
 */
function tenores_add_course_row_actions(array $actions, $post): array
{
	if ($post->post_type !== 'mto-course') {
		return $actions;
	}

	$edit_content_url = admin_url('admin.php?page=masteriyo#/courses/' . $post->ID . '/edit');

	$actions['edit_content'] = sprintf(
		'<a href="%s">%s</a>',
		esc_url($edit_content_url),
		esc_html__('Editar Conteúdo', 'tenores')
	);

	return $actions;
}

add_filter('post_row_actions', 'tenores_add_course_row_actions', 10, 2);

/**
 * Get course short description (custom field or fallback).
 *
 * @param object $course Masteriyo course object.
 * @return string Short description.
 */
function tenores_get_masteriyo_short_description($course): string
{
	if (!$course) {
		return '';
	}

	$course_id = method_exists($course, 'get_id') ? $course->get_id() : 0;

	if (!$course_id) {
		return '';
	}

	// Primeiro, tenta obter a descrição curta personalizada do tema
	$custom_description = get_post_meta($course_id, '_tenores_course_short_description', true);

	if (!empty($custom_description)) {
		return $custom_description;
	}

	// Fallback: descrição curta do Masteriyo
	if (method_exists($course, 'get_short_description')) {
		$short_desc = $course->get_short_description();
		if (!empty($short_desc)) {
			return $short_desc;
		}
	}

	// Fallback: highlights do Masteriyo (remove tags ul/li)
	if (method_exists($course, 'get_highlights')) {
		$highlights = $course->get_highlights();
		if (!empty($highlights)) {
			// Remove tags HTML e retorna texto limpo
			return $highlights;
		}
	}

	return '';
}
