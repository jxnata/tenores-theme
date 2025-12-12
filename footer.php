<?php

/**
 * Theme footer template.
 *
 * @package TailPress
 */
?>
<?php $settings = tenores_get_theme_settings(); ?>

</main>

<?php do_action('tailpress_content_end'); ?>
</div>

<?php do_action('tailpress_content_after'); ?>

<footer id="colophon" class="bg-dark <?php echo is_front_page() ? 'pt-12' : 'mt-12'; ?> text-white font-semibold" role="contentinfo">

    <div class="w-full">
        <div class="container mx-auto py-8">
            <?php do_action('tailpress_footer'); ?>
            <div class="text-sm flex items-center justify-center">
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
        </div>
    </div>

    <?php if (!empty($settings['footer_menu_primary'])): ?>
        <div class="w-full border-t border-primary">
            <div class="container mx-auto py-10 px-4">
                <?php
                wp_nav_menu([
                    'menu'         => $settings['footer_menu_primary'],
                    'container'   => false,
                    'menu_class'  => 'text-sm flex flex-wrap items-center justify-center gap-4 sm:gap-6 md:gap-8 lg:gap-16',
                    'fallback_cb' => false,
                    'items_wrap'  => '<ul class="%2$s">%3$s</ul>',
                    'walker'      => new class extends Walker_Nav_Menu {
                        function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
                        {
                            $output .= sprintf(
                                '<li class="text-center"><a href="%s" class="hover:text-primary !no-underline transition-colors duration-300 whitespace-nowrap">%s</a></li>',
                                esc_url($item->url),
                                esc_html($item->title)
                            );
                        }
                    },
                ]);
                ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($settings['footer_menu_secondary'])): ?>
        <div class="w-full border-t border-primary">
            <div class="container mx-auto py-10 px-4">
                <?php
                wp_nav_menu([
                    'menu'         => $settings['footer_menu_secondary'],
                    'container'   => false,
                    'menu_class'  => 'text-sm flex flex-wrap items-center justify-center gap-4 sm:gap-6 md:gap-8 lg:gap-16',
                    'fallback_cb' => false,
                    'items_wrap'  => '<ul class="%2$s">%3$s</ul>',
                    'walker'      => new class extends Walker_Nav_Menu {
                        function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
                        {
                            $output .= sprintf(
                                '<li class="text-center"><a href="%s" class="hover:text-primary !no-underline transition-colors duration-300 whitespace-nowrap">%s</a></li>',
                                esc_url($item->url),
                                esc_html($item->title)
                            );
                        }
                    },
                ]);
                ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="w-full border-t border-primary">
        <div class="container mx-auto py-10 px-4">
            <div class="text-sm flex flex-wrap items-center justify-center gap-4 sm:gap-6 md:gap-8 lg:gap-16">
                <a href="mailto:<?php echo esc_url($settings['contact_email']); ?>" class="hover:text-primary !no-underline transition-colors duration-300 text-center whitespace-nowrap">
                    <?php echo esc_html($settings['contact_email']); ?>
                </a>
                <a href="tel:<?php echo esc_url($settings['contact_phone']); ?>" class="hover:text-primary !no-underline transition-colors duration-300 text-center whitespace-nowrap">
                    <?php echo esc_html($settings['contact_phone']); ?>
                </a>
            </div>
        </div>
    </div>

    <div class="w-full border-t border-primary">
        <div class="container mx-auto py-10">
            <div class="text-sm flex flex-col items-center justify-center">
                <span>&copy; <?php bloginfo('name'); ?> <?php echo esc_html(date_i18n('Y')); ?></span>
                <span>Todos os direitos reservados</span>
            </div>
        </div>
    </div>

</footer>
</div>

<?php
// Botão flutuante do carrinho
if (class_exists('WooCommerce')) {
    $cart_count = WC()->cart->get_cart_contents_count();
    $cart_url = wc_get_cart_url();
    $ajax_url = admin_url('admin-ajax.php');
?>
    <div id="floating-cart-container" data-ajax-url="<?php echo esc_url($ajax_url); ?>" style="<?php echo $cart_count > 0 ? '' : 'display: none;'; ?>">
        <a href="<?php echo esc_url($cart_url); ?>" class="floating-cart-button" aria-label="<?php echo esc_attr__('Ver carrinho', 'tenores'); ?>">
            <i data-lucide="shopping-cart" class="size-6"></i>
            <span class="floating-cart-badge" data-cart-count="<?php echo esc_attr($cart_count); ?>">
                <?php echo esc_html($cart_count > 0 ? $cart_count : '0'); ?>
            </span>
        </a>
    </div>
<?php
}
?>

<?php wp_footer(); ?>
</body>

</html>