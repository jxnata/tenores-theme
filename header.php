<?php

/**
 * Theme header template.
 *
 * @package TailPress
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class('bg-white text-zinc-900 antialiased'); ?>>
    <?php do_action('tailpress_site_before'); ?>

    <div id="page" class="min-h-screen flex flex-col">
        <?php do_action('tailpress_header'); ?>

        <header class="fixed top-0 left-0 right-0 z-50 <?php echo is_front_page() ? 'bg-black/40 backdrop-blur-sm' : 'bg-black'; ?>">
            <div class="max-w-7xl mx-auto p-4">
                <div class="lg:flex lg:justify-between lg:items-center">
                    <div class="flex justify-between items-center">
                        <div class="[&_img]:max-h-12 [&_img]:w-auto">
                            <?php if (has_custom_logo()): ?>
                                <?php the_custom_logo(); ?>
                            <?php else: ?>
                                <div class="flex items-center gap-2 text-white">
                                    <a href="<?php echo esc_url(home_url('/')); ?>" class="!no-underline lowercase font-medium text-lg text-white">
                                        <?php bloginfo('name'); ?>
                                    </a>
                                    <?php if ($description = get_bloginfo('description')): ?>
                                        <span class="text-sm font-light text-white/80">|</span>
                                        <span class="text-sm font-light text-white/80"><?php echo esc_html($description); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="flex items-center gap-4 lg:hidden">
                            <?php if (function_exists('wc_get_cart_url')): ?>
                                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="flex items-center justify-center text-white hover:text-secondary transition-colors duration-300" aria-label="<?php esc_attr_e('Ver carrinho', 'tailpress'); ?>">
                                    <span data-lucide="shopping-cart" class="size-5"></span>
                                </a>
                            <?php endif; ?>

                            <?php if (has_nav_menu('primary')): ?>
                                <button type="button" aria-label="Toggle navigation" id="primary-menu-toggle" class="text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                    </svg>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div id="primary-navigation" class="hidden lg:flex lg:bg-transparent gap-6 items-center border border-white/20 lg:border-none rounded-xl p-4 lg:p-0">

                        <div class="inline-block w-full lg:w-auto mt-2 lg:mt-0 [&_input]:text-white [&_input]:border-none [&_input]:rounded-none border-b-2 border-white/60 [&_input]:placeholder:text-white/70 [&_input]:bg-transparent [&_svg]:text-white/70"><?php get_search_form(); ?></div>

                        <nav>
                            <?php if (current_user_can('administrator') && !has_nav_menu('primary')): ?>
                                <a href="<?php echo esc_url(admin_url('nav-menus.php')); ?>" class="text-sm text-white"><?php esc_html_e('Edit Menus', 'tailpress'); ?></a>
                            <?php else: ?>
                                <?php
                                wp_nav_menu([
                                    'container_id'    => 'primary-menu',
                                    'container_class' => 'py-4 lg:py-0',
                                    'menu_class'      => 'flex flex-col gap-2 lg:gap-4 lg:flex-row [&_a]:!no-underline [&_a]:text-white uppercase font-bold text-xs [&_a]:hover:text-secondary [&_a]:transition-colors [&_a]:duration-300',
                                    'theme_location'  => 'primary',
                                    'li_class'        => '',
                                    'fallback_cb'     => false,
                                ]);
                                ?>
                            <?php endif; ?>
                        </nav>

                        <?php if (function_exists('wc_get_cart_url')): ?>
                            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="hidden lg:flex items-center justify-center text-white hover:text-secondary transition-colors duration-300" aria-label="<?php esc_attr_e('Ver carrinho', 'tailpress'); ?>">
                                <span data-lucide="shopping-cart" class="size-4"></span>
                            </a>
                        <?php endif; ?>

                        <?php
                        $settings = tenores_get_theme_settings();
                        if (!empty($settings['cto_url']) && !is_user_logged_in()):
                        ?>
                            <a href="<?php echo esc_url($settings['cto_url']); ?>" class="primary-button">
                                QUERO MEU ACESSO
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
        </header>

        <div id="content" class="site-content grow">
            <?php do_action('tailpress_content_start'); ?>
            <main>