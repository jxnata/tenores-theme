<?php

/**
 * Home hero section.
 *
 * @package Tenores
 */

$settings        = tenores_get_theme_settings();
$banner_image_id = !empty($settings['banner']) ? absint($settings['banner']) : 0;
$hero_background = $banner_image_id
    ? wp_get_attachment_image_url($banner_image_id, 'full')
    : get_theme_image_url('banner.png');
$headline        = !empty($settings['headline']) ? $settings['headline'] : 'Fala autêntica<br><span class="text-secondary">Resultados reais</span>';
?>

<section
    class="relative min-h-[720px] lg:min-h-[840px] flex items-center overflow-hidden"
    style="background-image: url('<?php echo esc_url($hero_background); ?>'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/60 to-black/80"></div>

    <div class="relative container mx-auto">
        <h1 class="text-3xl md:text-5xl lg:text-6xl font-black tracking-widest leading-tight uppercase animate-fade-in">
            <?php echo wp_kses($headline, [
                'strong' => ['class' => [], 'style' => []],
                'em'     => ['class' => [], 'style' => []],
                'span'   => ['class' => [], 'style' => []],
                'br'     => [],
                'p'      => ['class' => [], 'style' => []],
            ]); ?>
        </h1>
    </div>

    <div class="absolute inset-x-0 bottom-8 flex justify-center">
        <img src="<?php echo esc_url(get_theme_image_url('icon_scroll.svg')); ?>" alt="Arrow down" class="size-8 animate-bounce">
    </div>
</section>