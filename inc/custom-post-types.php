<?php

/**
 * Custom post types do tema Tenores.
 */

const TENORES_TESTIMONIAL_ROLE_META = '_tenores_testimonial_role';

/**
 * Custom post type: Depoimentos.
 */
function tenores_register_testimonial_cpt(): void
{
	$labels = [
		'name'                     => __('Depoimentos', 'tenores'),
		'singular_name'            => __('Depoimento', 'tenores'),
		'menu_name'                => __('Depoimentos', 'tenores'),
		'name_admin_bar'           => __('Depoimento', 'tenores'),
		'add_new'                  => __('Adicionar novo', 'tenores'),
		'add_new_item'             => __('Adicionar novo depoimento', 'tenores'),
		'edit_item'                => __('Editar depoimento', 'tenores'),
		'new_item'                 => __('Novo depoimento', 'tenores'),
		'view_item'                => __('Ver depoimento', 'tenores'),
		'view_items'               => __('Ver depoimentos', 'tenores'),
		'search_items'             => __('Buscar depoimentos', 'tenores'),
		'not_found'                => __('Nenhum depoimento encontrado.', 'tenores'),
		'not_found_in_trash'       => __('Nenhum depoimento na lixeira.', 'tenores'),
		'all_items'                => __('Todos os depoimentos', 'tenores'),
		'archives'                 => __('Arquivos de depoimentos', 'tenores'),
		'attributes'               => __('Atributos do depoimento', 'tenores'),
		'insert_into_item'         => __('Inserir no depoimento', 'tenores'),
		'uploaded_to_this_item'    => __('Enviado para este depoimento', 'tenores'),
		'filter_items_list'        => __('Filtrar lista de depoimentos', 'tenores'),
		'items_list'               => __('Lista de depoimentos', 'tenores'),
		'items_list_navigation'    => __('Navegação da lista de depoimentos', 'tenores'),
	];

	$args = [
		'labels'             => $labels,
		'public'             => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'has_archive'        => false,
		'rewrite'            => ['slug' => 'depoimentos'],
		'supports'           => ['title', 'editor', 'thumbnail'],
		'menu_icon'          => 'dashicons-format-quote',
	];

	register_post_type('tenores_testimonial', $args);
}

add_action('init', 'tenores_register_testimonial_cpt');

function tenores_add_testimonial_meta_box(): void
{
	add_meta_box(
		'tenores_testimonial_role',
		__('Função / Cargo', 'tenores'),
		'tenores_render_testimonial_meta_box',
		'tenores_testimonial',
		'normal',
		'default'
	);
}

add_action('add_meta_boxes', 'tenores_add_testimonial_meta_box');

function tenores_render_testimonial_meta_box(WP_Post $post): void
{
	$role = get_post_meta($post->ID, TENORES_TESTIMONIAL_ROLE_META, true);

	wp_nonce_field('tenores_save_testimonial_role', 'tenores_testimonial_role_nonce');
?>
	<p>
		<label for="tenores_testimonial_role_field" class="screen-reader-text">
			<?php esc_html_e('Função / Cargo', 'tenores'); ?>
		</label>
		<input
			type="text"
			id="tenores_testimonial_role_field"
			name="tenores_testimonial_role_field"
			class="widefat"
			value="<?php echo esc_attr($role); ?>"
			placeholder="<?php esc_attr_e('Ex: Fundadora da Black Sisters in Law', 'tenores'); ?>" />
	</p>
<?php
}

function tenores_save_testimonial_meta(int $post_id): void
{
	if (!isset($_POST['tenores_testimonial_role_nonce'])) {
		return;
	}

	if (!wp_verify_nonce((string) $_POST['tenores_testimonial_role_nonce'], 'tenores_save_testimonial_role')) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (isset($_POST['tenores_testimonial_role_field'])) {
		$role = sanitize_text_field((string) $_POST['tenores_testimonial_role_field']);
		update_post_meta($post_id, TENORES_TESTIMONIAL_ROLE_META, $role);
	}
}

add_action('save_post_tenores_testimonial', 'tenores_save_testimonial_meta');

function tenores_get_testimonial_role(int $post_id): string
{
	$role = get_post_meta($post_id, TENORES_TESTIMONIAL_ROLE_META, true);

	return is_string($role) ? $role : '';
}
