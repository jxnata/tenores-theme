<?php

/**
 * Funções auxiliares do tema Tenores.
 */

// Helper function to get image path.
function get_theme_image_url($image_path)
{
	$dist_path     = get_template_directory_uri() . '/dist/images/' . $image_path;
	$resource_path = get_template_directory_uri() . '/resources/images/' . $image_path;

	// Check if we're in production mode by checking if the manifest file exists.
	$manifest_file = get_template_directory() . '/dist/.vite/manifest.json';

	if (file_exists($manifest_file)) {
		// Production mode - use dist images.
		return $dist_path;
	}

	// Development mode - use resources images.
	return $resource_path;
}
