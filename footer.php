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
            <div class="container mx-auto py-10">
                <?php
                wp_nav_menu([
                    'menu'         => $settings['footer_menu_primary'],
                    'container'   => false,
                    'menu_class'  => 'text-sm flex items-center justify-center gap-8 md:gap-16',
                    'fallback_cb' => false,
                    'items_wrap'  => '<ul class="%2$s">%3$s</ul>',
                    'walker'      => new class extends Walker_Nav_Menu {
                        function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
                        {
                            $output .= sprintf(
                                '<li><a href="%s" class="hover:text-primary !no-underline transition-colors duration-300">%s</a></li>',
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
            <div class="container mx-auto py-10">
                <?php
                wp_nav_menu([
                    'menu'         => $settings['footer_menu_secondary'],
                    'container'   => false,
                    'menu_class'  => 'text-sm flex items-center justify-center gap-8 md:gap-16',
                    'fallback_cb' => false,
                    'items_wrap'  => '<ul class="%2$s">%3$s</ul>',
                    'walker'      => new class extends Walker_Nav_Menu {
                        function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
                        {
                            $output .= sprintf(
                                '<li><a href="%s" class="hover:text-primary !no-underline transition-colors duration-300">%s</a></li>',
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
        <div class="container mx-auto py-10">
            <div class="text-sm flex items-center justify-center gap-8 md:gap-16">
                <a href="mailto:<?php echo esc_url($settings['contact_email']); ?>" class="hover:text-primary !no-underline transition-colors duration-300">
                    <?php echo esc_html($settings['contact_email']); ?>
                </a>
                <a href="tel:<?php echo esc_url($settings['contact_phone']); ?>" class="hover:text-primary !no-underline transition-colors duration-300">
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

<?php wp_footer(); ?>
</body>

</html>