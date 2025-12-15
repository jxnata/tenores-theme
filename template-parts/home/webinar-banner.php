<?php

/**
 * Home webinar banner section.
 *
 * @package Tenores
 */

$settings = tenores_get_theme_settings();
?>

<?php if ($settings['webinar_enabled'] === 1) : ?>
    <section class="bg-dark min-h-40 flex items-center">
        <div class="container mx-auto py-4 lg:py-5 flex flex-col lg:flex-row items-center justify-between gap-4">
            <p class="text-base md:text-lg font-black uppercase tracking-wider text-light text-center lg:text-left">
                <?php
                $webinar_timestamp = ! empty($settings['webinar_date']) ? strtotime($settings['webinar_date']) : false;
                $webinar_date_i18n = $webinar_timestamp ? date_i18n(get_option('date_format'), $webinar_timestamp) : $settings['webinar_date'];
                ?>
                Participe do nosso webinar 100% gratuito - <?php echo esc_html($webinar_date_i18n); ?>!
            </p>

            <a href="<?php echo esc_url($settings['webinar_url']); ?>" class="primary-button">
                <?php esc_html_e('Quero participar', 'tenores'); ?>
            </a>
        </div>
    </section>
<?php endif; ?>