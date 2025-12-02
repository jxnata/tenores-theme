<?php

/**
 * Home hero section.
 *
 * @package Tenores
 */

$hero_background = get_theme_image_url('banner.png');
$settings        = tenores_get_theme_settings();
$headline        = !empty($settings['headline']) ? $settings['headline'] : 'Fala autêntica<br><span class="text-primary">Resultados reais</span>';
?>

<section
    class="relative min-h-[720px] lg:min-h-[840px] flex items-end overflow-hidden"
    style="background-image: url('<?php echo esc_url($hero_background); ?>'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/60 to-black/80"></div>

    <div class="relative container mx-auto pb-20 lg:pb-28">
        <div class="max-w-2xl">
            <p class="tracking-[0.3em] text-xs md:text-sm uppercase text-light/80 mb-4">
                fala autêntica
            </p>
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold leading-tight">
                <?php echo wp_kses($headline, [
                    'strong' => ['class' => [], 'style' => []],
                    'em'     => ['class' => [], 'style' => []],
                    'span'   => ['class' => [], 'style' => []],
                    'br'     => [],
                    'p'      => ['class' => [], 'style' => []],
                ]); ?>
            </h1>

            <div class="mt-10 flex flex-wrap items-center gap-4">
                <a href="#oferta"
                    class="inline-flex items-center justify-center rounded-full bg-primary px-6 py-3 text-sm font-semibold uppercase tracking-[0.2em] text-dark !no-underline">
                    Quero meu acesso
                </a>

                <a href="#artigos"
                    class="inline-flex items-center justify-center rounded-full border border-light/60 px-6 py-3 text-sm font-semibold uppercase tracking-[0.2em] text-light !no-underline">
                    Conheça a Tenores
                </a>
            </div>
        </div>
    </div>

    <div class="absolute inset-x-0 bottom-6 flex justify-center">
        <div class="flex flex-col items-center gap-2 text-light/70 text-xs">
            <span class="size-10 rounded-full border border-light/40 flex items-center justify-center">
                <span class="size-1.5 rounded-full bg-light/80"></span>
            </span>
            <span>Role para ver mais</span>
        </div>
    </div>
</section>