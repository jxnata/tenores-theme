<?php

/**
 * Shortcodes do tema Tenores.
 *
 * @package Tenores
 */

/**
 * Shortcode para exibir a seção de oferta.
 *
 * @param array $atts Atributos do shortcode.
 * @return string HTML da seção de oferta.
 */
function tenores_offer_shortcode($atts = []): string
{
	ob_start();
	include get_template_directory() . '/template-parts/home/offer.php';
	return ob_get_clean();
}

add_shortcode('tenores_oferta', 'tenores_offer_shortcode');
