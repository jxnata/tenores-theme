<?php

/**
 * WooCommerce support for Tenores theme.
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Declare WooCommerce theme support.
 */
function tenores_woocommerce_setup(): void
{
	add_theme_support('woocommerce');
	add_theme_support('wc-product-gallery-zoom');
	add_theme_support('wc-product-gallery-lightbox');
	add_theme_support('wc-product-gallery-slider');
}

add_action('after_setup_theme', 'tenores_woocommerce_setup');

/**
 * Remove default WooCommerce styles.
 */
function tenores_dequeue_woocommerce_styles(): array
{
	return [];
}

add_filter('woocommerce_enqueue_styles', 'tenores_dequeue_woocommerce_styles');

/**
 * Remove default WooCommerce wrapper.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

/**
 * Remove default WooCommerce sidebar.
 */
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

/**
 * Remove default breadcrumbs.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

/**
 * Remove default result count and ordering.
 */
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

/**
 * Get featured course settings.
 */
function tenores_get_featured_course(): array
{
	$settings = tenores_get_theme_settings();

	$product_id = !empty($settings['featured_course_product']) ? absint($settings['featured_course_product']) : 0;
	$banner_id  = !empty($settings['featured_course_banner']) ? absint($settings['featured_course_banner']) : 0;
	$title      = !empty($settings['featured_course_title']) ? $settings['featured_course_title'] : '';
	$subtitle   = !empty($settings['featured_course_subtitle']) ? $settings['featured_course_subtitle'] : '';

	if (!$product_id || !class_exists('WooCommerce')) {
		return [];
	}

	$product = wc_get_product($product_id);

	if (!$product) {
		return [];
	}

	$banner_url = $banner_id ? wp_get_attachment_image_url($banner_id, 'full') : '';

	return [
		'product'   => $product,
		'banner'    => $banner_url,
		'title'     => $title,
		'subtitle'  => $subtitle,
	];
}

/**
 * Custom breadcrumb for shop pages.
 */
function tenores_shop_breadcrumb(): void
{
	$home_url = home_url('/');
	$shop_url = wc_get_page_permalink('shop');

	echo '<nav class="text-sm font-semibold mb-6 [&_a]:transition-all [&_a]:duration-300">';
	echo '<a href="' . esc_url($home_url) . '" class="hover:text-primary !no-underline"><i data-lucide="home" class="inline-block size-4 align-text-bottom"></i></a>';
	echo ' <span class="mx-2"><i data-lucide="chevron-right" class="inline-block size-4 align-text-bottom"></i></span> ';

	if (is_product()) {
		echo '<a href="' . esc_url($shop_url) . '" class="hover:text-primary !no-underline">' . esc_html__('Cursos', 'tenores') . '</a>';

		$terms = get_the_terms(get_the_ID(), 'product_cat');
		if ($terms && !is_wp_error($terms)) {
			$term = $terms[0];
			echo ' <span class="mx-2"><i data-lucide="chevron-right" class="inline-block size-4 align-text-bottom"></i></span> ';
			echo '<a href="' . esc_url(get_term_link($term)) . '" class="hover:text-primary !no-underline">' . esc_html($term->name) . '</a>';
		}
	} else {
		echo '<span class="font-semibold">' . esc_html__('Cursos', 'tenores') . '</span>';
	}

	echo '</nav>';
}

/**
 * Get primary product category.
 */
function tenores_get_product_category(int $product_id): string
{
	$terms = get_the_terms($product_id, 'product_cat');

	if ($terms && !is_wp_error($terms)) {
		foreach ($terms as $term) {
			if ($term->slug !== 'uncategorized') {
				return $term->name;
			}
		}
		return $terms[0]->name;
	}

	return '';
}

/**
 * Add custom meta fields to WooCommerce products.
 */
function tenores_add_course_meta_fields(): void
{
	global $post;

	echo '<div class="options_group">';

	woocommerce_wp_text_input([
		'id'          => '_tenores_course_duration',
		'label'       => __('Duração do curso', 'tenores'),
		'placeholder' => __('Ex: Duração de 30 meses', 'tenores'),
		'desc_tip'    => true,
		'description' => __('Informe a duração do curso.', 'tenores'),
	]);

	echo '</div>';
}

add_action('woocommerce_product_options_general_product_data', 'tenores_add_course_meta_fields');

/**
 * Save custom meta fields.
 */
function tenores_save_course_meta_fields(int $post_id): void
{
	if (isset($_POST['_tenores_course_duration'])) {
		update_post_meta($post_id, '_tenores_course_duration', sanitize_text_field($_POST['_tenores_course_duration']));
	}
}

add_action('woocommerce_process_product_meta', 'tenores_save_course_meta_fields');

/**
 * Retorna a contagem do carrinho via AJAX.
 */
function tenores_get_cart_count(): void
{
	if (!class_exists('WooCommerce')) {
		wp_send_json_error(['message' => 'WooCommerce não está ativo']);
		return;
	}

	$cart_count = WC()->cart->get_cart_contents_count();

	wp_send_json_success(['count' => $cart_count]);
}

add_action('wp_ajax_tenores_get_cart_count', 'tenores_get_cart_count');
add_action('wp_ajax_nopriv_tenores_get_cart_count', 'tenores_get_cart_count');
