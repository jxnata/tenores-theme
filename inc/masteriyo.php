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

	$course_id = method_exists($course, 'get_id') ? $course->get_id() : 0;

	if (!$course_id) {
		return '#';
	}

	// Verifica se o usuário pode iniciar o curso (já está inscrito)
	if (function_exists('masteriyo_can_start_course')) {
		if (masteriyo_can_start_course($course)) {
			// Busca progresso do curso
			$progress = null;
			if (function_exists('masteriyo_get_course_progress')) {
				$progress = masteriyo_get_course_progress($course_id, get_current_user_id());
			}

			// Se tem progresso, continua de onde parou
			if ($progress && method_exists($course, 'continue_course_url')) {
				return $course->continue_course_url($progress);
			}

			// Senão, inicia o curso
			if (method_exists($course, 'start_course_url')) {
				return $course->start_course_url();
			}
		}
	}

	// Se o curso é gratuito e usuário não está inscrito
	if (tenores_is_masteriyo_course_free($course)) {
		// Se não estiver logado, redireciona para login/registro
		if (!is_user_logged_in()) {
			return wc_get_page_permalink('myaccount');
		}
		// Se estiver logado, permite iniciar
		if (method_exists($course, 'start_course_url')) {
			return $course->start_course_url();
		}
	}

	// Se o curso é pago, verifica se está integrado com WooCommerce
	if (class_exists('Masteriyo\Addons\WcIntegration\Helper')) {
		$product_id = \Masteriyo\Addons\WcIntegration\Helper::is_course_wc_product($course_id);

		if ($product_id && function_exists('wc_get_product')) {
			$product = wc_get_product($product_id);
			if ($product) {
				// Verifica se já está no carrinho
				$is_in_cart = \Masteriyo\Addons\WcIntegration\Helper::is_course_added_to_cart($course_id);

				if ($is_in_cart === true) {
					// Se já está no carrinho, redireciona para o carrinho
					return wc_get_cart_url();
				} else {
					// Retorna URL para adicionar ao carrinho
					return $product->add_to_cart_url();
				}
			}
		}
	}

	// Fallback: método do Masteriyo
	if (method_exists($course, 'add_to_cart_url')) {
		return $course->add_to_cart_url();
	}

	// Fallback: permalink do curso
	if (method_exists($course, 'get_permalink')) {
		return $course->get_permalink();
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
	$current_access = function_exists('tenores_get_content_access') ? tenores_get_content_access($post->ID) : 'public';

	$access_options = [
		'public'      => __('Acesso livre', 'tenores'),
		'members'     => __('Apenas Usuários Registrados', 'tenores'),
		'subscribers' => __('Apenas Assinantes', 'tenores'),
	];
?>
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="tenores_course_access">
					<?php esc_html_e('Controle de Acesso', 'tenores'); ?>
				</label>
			</th>
			<td>
				<select id="tenores_course_access" name="tenores_course_access" class="regular-text">
					<?php foreach ($access_options as $value => $label) : ?>
						<option value="<?php echo esc_attr($value); ?>" <?php selected($current_access, $value); ?>>
							<?php echo esc_html($label); ?>
						</option>
					<?php endforeach; ?>
				</select>
				<p class="description">
					<?php esc_html_e('Defina quem pode acessar este curso. Assinantes são usuários com uma assinatura ativa do produto configurado nas opções do tema.', 'tenores'); ?>
				</p>
			</td>
		</tr>
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

	// Salvar controle de acesso
	if (isset($_POST['tenores_course_access'])) {
		$access = sanitize_text_field($_POST['tenores_course_access']);
		$valid_access = ['public', 'members', 'subscribers'];

		if (in_array($access, $valid_access, true)) {
			update_post_meta($post_id, '_tenores_content_access', $access);
		}
	}

	// Salvar descrição curta
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
 * Customize WooCommerce My Account menu items.
 * Keeps dashboard and adds "Cursos" tab.
 */
function tenores_add_courses_my_account_tab($items): array
{
	if (!tenores_is_masteriyo_active()) {
		return $items;
	}

	// Get dashboard item if exists
	$dashboard = isset($items['dashboard']) ? ['dashboard' => $items['dashboard']] : [];

	// Remove dashboard from original array to reorder
	unset($items['dashboard']);

	// Build new items array: Dashboard first, then Cursos, then rest
	$new_items = $dashboard + ['cursos' => __('Cursos', 'tenores')] + $items;

	return $new_items;
}

add_filter('woocommerce_account_menu_items', 'tenores_add_courses_my_account_tab', 10, 1);

/**
 * Register "Cursos" endpoint for My Account page.
 */
function tenores_add_courses_endpoint(): void
{
	if (!tenores_is_masteriyo_active()) {
		return;
	}

	add_rewrite_endpoint('cursos', EP_ROOT | EP_PAGES);
}

add_action('init', 'tenores_add_courses_endpoint');

/**
 * Add query vars for cursos endpoint.
 */
function tenores_add_courses_query_vars($vars): array
{
	if (!tenores_is_masteriyo_active()) {
		return $vars;
	}

	$vars[] = 'cursos';
	return $vars;
}

add_filter('query_vars', 'tenores_add_courses_query_vars', 0);

/**
 * Display content for "Cursos" tab in My Account page.
 */
function tenores_courses_my_account_content(): void
{
	if (!tenores_is_masteriyo_active() || !is_user_logged_in()) {
		return;
	}

	$user_id = get_current_user_id();

	// Busca cursos em que o usuário está inscrito
	$enrolled_courses = [];

	// Busca via WP_Query
	$courses_query = new WP_Query([
		'post_type'      => 'mto-course',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
	]);

	foreach ($courses_query->posts as $post) {
		if (tenores_is_user_enrolled_in_masteriyo_course($post->ID)) {
			if (function_exists('masteriyo_get_course')) {
				$course = masteriyo_get_course($post->ID);
				if ($course) {
					$enrolled_courses[] = $course;
				}
			}
		}
	}

	$settings = tenores_get_theme_settings();

	// Get courses page URL
	$courses_url = '';
	$courses_page_id = !empty($settings['courses_page_id']) ? absint($settings['courses_page_id']) : 0;

	if ($courses_page_id) {
		$courses_url = get_permalink($courses_page_id);
	}

	// Fallback to Masteriyo courses page
	if (empty($courses_url) && function_exists('masteriyo_get_page_permalink')) {
		$courses_url = masteriyo_get_page_permalink('courses');
	}

?>
	<div class="tenores-my-account-courses">
		<?php if (!empty($enrolled_courses)) : ?>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
				<?php
				foreach ($enrolled_courses as $course) :
					$course_id = $course->get_id();
					$course_name = $course->get_name();
					$course_url = $course->get_permalink();
					$course_image = tenores_get_masteriyo_course_image($course, 'medium');
					$course_category = tenores_get_masteriyo_course_category($course);

					// Verifica progresso do curso
					$progress_percentage = 0;
					$progress_obj = null;
					$has_started = false;

					// Verifica se o usuário pode iniciar/continuar o curso (já está inscrito)
					if (function_exists('masteriyo_can_start_course')) {
						if (masteriyo_can_start_course($course)) {
							$has_started = true;
						}
					}

					// Busca progresso do curso usando CourseProgressQuery como no template do Masteriyo
					if (class_exists('\Masteriyo\Query\CourseProgressQuery')) {
						$query = new \Masteriyo\Query\CourseProgressQuery([
							'course_id' => $course_id,
							'user_id'   => $user_id,
						]);
						$progress_obj = current($query->get_course_progress());

						if ($progress_obj && is_object($progress_obj)) {
							$has_started = true;

							// Obtém o summary usando o método get_summary como no template do Masteriyo
							if (method_exists($progress_obj, 'get_summary')) {
								$summary = $progress_obj->get_summary('all');
								if (is_array($summary) && isset($summary['total']['completed'], $summary['total']['total'])) {
									$completed = (int) $summary['total']['completed'];
									$total = (int) $summary['total']['total'];
									if ($total > 0) {
										$progress_percentage = ($completed / $total) * 100;
									}
								}
							}
						}
					}

					// URL para continuar o curso
					$continue_url = '#';
					if ($progress_obj && !is_wp_error($progress_obj) && method_exists($course, 'continue_course_url')) {
						$continue_url = $course->continue_course_url($progress_obj);
					} elseif (method_exists($course, 'start_course_url')) {
						$continue_url = $course->start_course_url();
					}
				?>
					<div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
						<?php if ($course_image) : ?>
							<a href="<?php echo esc_url($course_url); ?>" class="block">
								<img
									src="<?php echo esc_url($course_image); ?>"
									alt="<?php echo esc_attr($course_name); ?>"
									class="w-full h-48 object-cover" />
							</a>
						<?php endif; ?>

						<div class="p-4">
							<?php if ($course_category) : ?>
								<span class="text-primary text-xs font-semibold uppercase tracking-wide mb-2 block">
									<?php echo esc_html($course_category); ?>
								</span>
							<?php endif; ?>

							<h3 class="font-bold text-lg leading-tight mb-2 !mt-0">
								<a href="<?php echo esc_url($course_url); ?>" class="!text-dark hover:text-primary transition-colors !no-underline">
									<?php echo esc_html($course_name); ?>
								</a>
							</h3>

							<?php
							// Sempre mostra progresso se o curso foi iniciado
							if ($has_started) :
								$display_percentage = max(0, min(100, $progress_percentage));
							?>
								<div class="mb-4">
									<div class="flex justify-between items-center mb-2">
										<span class="text-sm font-semibold text-dark"><?php esc_html_e('Progresso', 'tenores'); ?></span>
										<span class="text-sm font-semibold text-primary"><?php echo esc_html(round($display_percentage, 0)); ?>%</span>
									</div>
									<div class="w-full bg-light rounded-full h-2">
										<div
											class="bg-primary h-2 rounded-full transition-all duration-300"
											style="width: <?php echo esc_attr($display_percentage); ?>%"></div>
									</div>
								</div>
							<?php endif; ?>

							<div class="flex gap-2">
								<a
									href="<?php echo esc_url($continue_url); ?>"
									class="primary-button flex-1 text-center">
									<?php esc_html_e('Continuar', 'tenores'); ?>
								</a>
								<a
									href="<?php echo esc_url($course_url); ?>"
									class="secondary-button flex-1 text-center">
									<?php esc_html_e('Ver Curso', 'tenores'); ?>
								</a>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<div class="text-center py-12">
				<p class="text-zinc-600 text-lg mb-4">
					<?php esc_html_e('Você ainda não está inscrito em nenhum curso.', 'tenores'); ?>
				</p>
				<a href="<?= $courses_url ?>" class="primary-button inline-block">
					<?php esc_html_e('Explorar Cursos', 'tenores'); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
<?php
}

add_action('woocommerce_account_cursos_endpoint', 'tenores_courses_my_account_content');

/**
 * Clear WooCommerce notices on page load for course pages.
 */
function tenores_clear_wc_notices_on_course_pages(): void
{
	if (is_singular('mto-course')) {
		wc_clear_notices();
	}
}

add_action('wp', 'tenores_clear_wc_notices_on_course_pages', 1);

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
