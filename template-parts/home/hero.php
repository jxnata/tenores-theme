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

// Redes sociais disponíveis
$social_links = [
    'linkedin'  => !empty($settings['social_linkedin']) ? esc_url($settings['social_linkedin']) : '',
    'facebook'  => !empty($settings['social_facebook']) ? esc_url($settings['social_facebook']) : '',
    'instagram' => !empty($settings['social_instagram']) ? esc_url($settings['social_instagram']) : '',
    'youtube'   => !empty($settings['social_youtube']) ? esc_url($settings['social_youtube']) : '',
];

// Filtrar apenas redes sociais com links configurados
$active_social_links = array_filter($social_links);
?>

<section
    class="relative min-h-[720px] lg:min-h-[840px] flex items-center overflow-hidden"
    style="background-image: url('<?php echo esc_url($hero_background); ?>'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/60 to-black/80"></div>

    <div class="relative container mx-auto px-4">
        <h1 class="mr-6 text-3xl md:text-5xl lg:text-6xl font-black tracking-widest leading-tight uppercase animate-fade-in">
            <?php echo wp_kses($headline, [
                'strong' => ['class' => [], 'style' => []],
                'em'     => ['class' => [], 'style' => []],
                'span'   => ['class' => [], 'style' => []],
                'br'     => [],
                'p'      => ['class' => [], 'style' => []],
            ]); ?>
        </h1>
    </div>

    <?php if (!empty($active_social_links)) : ?>
        <div class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 flex flex-col items-center gap-6">
            <span class="text-white text-xs font-bold uppercase tracking-widest writing-vertical-rl select-none">
                <?php esc_html_e('MANTENHA-SE CONECTADO', 'tenores'); ?>
            </span>
            <div class="flex flex-col gap-4">
                <?php if (!empty($social_links['linkedin'])) : ?>
                    <a href="<?php echo esc_url($social_links['linkedin']); ?>" target="_blank" rel="noopener noreferrer" class="text-white hover:text-primary transition-colors duration-300" aria-label="<?php esc_attr_e('LinkedIn', 'tenores'); ?>">
                        <i data-lucide="linkedin" class="size-5"></i>
                    </a>
                <?php endif; ?>
                <?php if (!empty($social_links['instagram'])) : ?>
                    <a href="<?php echo esc_url($social_links['instagram']); ?>" target="_blank" rel="noopener noreferrer" class="text-white hover:text-primary transition-colors duration-300" aria-label="<?php esc_attr_e('Instagram', 'tenores'); ?>">
                        <i data-lucide="instagram" class="size-5"></i>
                    </a>
                <?php endif; ?>
                <?php if (!empty($social_links['youtube'])) : ?>
                    <a href="<?php echo esc_url($social_links['youtube']); ?>" target="_blank" rel="noopener noreferrer" class="text-white hover:text-primary transition-colors duration-300" aria-label="<?php esc_attr_e('YouTube', 'tenores'); ?>">
                        <i data-lucide="youtube" class="size-5"></i>
                    </a>
                <?php endif; ?>
                <?php if (!empty($social_links['facebook'])) : ?>
                    <a href="<?php echo esc_url($social_links['facebook']); ?>" target="_blank" rel="noopener noreferrer" class="text-white hover:text-primary transition-colors duration-300" aria-label="<?php esc_attr_e('Facebook', 'tenores'); ?>">
                        <i data-lucide="facebook" class="size-5"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="absolute inset-x-0 bottom-8 flex justify-center">
        <img src="<?php echo esc_url(get_theme_image_url('icon_scroll.svg')); ?>" alt="Arrow down" class="size-8 animate-bounce">
    </div>
</section>