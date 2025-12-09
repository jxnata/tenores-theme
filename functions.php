<?php

if (is_file(__DIR__ . '/vendor/autoload_packages.php')) {
    require_once __DIR__ . '/vendor/autoload_packages.php';
}

function enqueue_lucide_script()
{
    wp_enqueue_script('lucide', 'https://unpkg.com/lucide@latest', array(), null, false);
}

add_action('wp_enqueue_scripts', 'enqueue_lucide_script');

function tailpress(): TailPress\Framework\Theme
{
    return TailPress\Framework\Theme::instance()
        ->assets(
            fn($manager) => $manager
                ->withCompiler(
                    new TailPress\Framework\Assets\ViteCompiler,
                    fn($compiler) => $compiler
                        ->registerAsset('resources/css/app.css')
                        ->registerAsset('resources/js/app.js')
                        ->editorStyleFile('resources/css/editor-style.css')
                )
                ->enqueueAssets()
        )
        ->features(fn($manager) => $manager->add(TailPress\Framework\Features\MenuOptions::class))
        ->menus(fn($manager) => $manager->add('primary', __('Primary Menu', 'tailpress')))
        ->themeSupport(fn($manager) => $manager->add([
            'title-tag',
            'custom-logo',
            'post-thumbnails',
            'align-wide',
            'wp-block-styles',
            'responsive-embeds',
            'html5' => [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ]
        ]));
}

tailpress();

// Carrega módulos organizados do tema.
require_once __DIR__ . '/inc/helpers.php';
require_once __DIR__ . '/inc/theme-settings.php';
require_once __DIR__ . '/inc/custom-post-types.php';
require_once __DIR__ . '/inc/shortcodes.php';

/**
 * Substitui o texto do link da página inicial por um ícone home (Lucide) em telas maiores que md.
 * Em telas menores (mobile), mantém o título visível.
 */
function tenores_replace_home_menu_icon($title, $item, $args, $depth)
{
    if (isset($args->theme_location) && $args->theme_location === 'primary') {
        $home_url = home_url('/');

        if ($item->url === $home_url || $item->url === trailingslashit($home_url)) {
            return '<i data-lucide="home" class="size-5 hidden md:block"></i><span class="md:hidden">' . $title . '</span>';
        }
    }

    return $title;
}

add_filter('nav_menu_item_title', 'tenores_replace_home_menu_icon', 10, 4);
