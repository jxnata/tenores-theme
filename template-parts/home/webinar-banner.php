<?php

/**
 * Home webinar banner section.
 *
 * @package Tenores
 */

$settings = tenores_get_theme_settings();
$webinar_enabled = $settings['webinar_enabled'];
$webinar_date =  strtotime($settings['webinar_date']);
$webinar_date_i18n = $webinar_date ? date_i18n(get_option('date_format'), $webinar_date) : $webinar_date;
$in_future = $webinar_date > time()
?>

<?php if ($webinar_enabled && $in_future) : ?>
    <section class="bg-dark min-h-40 flex items-center">
        <div class="container mx-auto py-4 lg:py-5 flex flex-col lg:flex-row items-center justify-between gap-4">
            <p class="text-base md:text-lg font-black uppercase tracking-wider text-light text-center lg:text-left">
                Participe do nosso webinar 100% gratuito - <?php echo esc_html($webinar_date_i18n); ?>!
            </p>

            <a href="<?php echo esc_url($settings['webinar_url']); ?>" class="primary-button">
                <?php esc_html_e('Quero participar', 'tenores'); ?>
            </a>
        </div>
    </section>
<?php endif; ?>