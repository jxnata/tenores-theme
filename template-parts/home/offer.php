<?php

/**
 * Home offer section.
 *
 * @package Tenores
 */

$settings = tenores_get_theme_settings();

$featured_course  = function_exists('tenores_get_featured_course') ? tenores_get_featured_course() : [];
$featured_product = (!empty($featured_course['product']) && class_exists('WooCommerce')) ? $featured_course['product'] : null;

$discount_percentage             = null;
$original_price_html             = '';
$current_price_html              = '';
$original_installment_price_html = '';
$current_installment_price_html  = '';
$installments_count              = !empty($settings['installments_count']) ? max(1, (int) $settings['installments_count']) : 12;

if ($featured_product && is_object($featured_product) && method_exists($featured_product, 'get_regular_price')) {
    $regular_price = (float) $featured_product->get_regular_price();
    $sale_price    = (float) $featured_product->get_sale_price();
    $current_price = $sale_price > 0 ? $sale_price : (float) $featured_product->get_price();

    if ($regular_price > 0) {
        $original_price_html             = wc_price($regular_price);
        $original_installment_price_html = $installments_count > 0 ? wc_price($regular_price / $installments_count) : '';
    }

    if ($current_price > 0) {
        $current_price_html             = wc_price($current_price);
        $current_installment_price_html = $installments_count > 0 ? wc_price($current_price / $installments_count) : '';
    }

    if ($regular_price > 0 && $current_price > 0 && $current_price < $regular_price) {
        $discount_percentage = (int) round((($regular_price - $current_price) / $regular_price) * 100);
    }
}
?>

<section id="oferta" class="bg-dark text-light">
    <div class="container mx-auto py-16 lg:py-20">
        <p class="text-base font-black uppercase tracking-widest text-primary mt-8 text-center">
            Aproveite esta oferta exclusiva hoje e garanta:
        </p>

        <div class="mt-8 rounded-3xl bg-tertiary text-light px-8 py-10 lg:px-10 lg:py-12 shadow-2xl shadow-black/30 w-full transition-all duration-300 hover:shadow-3xl">
            <div class="flex flex-col lg:flex-row gap-12 lg:gap-8 items-center">
                <?php if ($featured_product) : ?>
                    <div class="w-full flex flex-col gap-2 flex-1 items-center lg:items-start">
                        <p class="w-fit text-6xl text-center lg:text-left lg:text-7xl xl:text-8xl font-black leading-tight tracking-widest border-b border-light/60 animate-pulse">
                            <?php if ($discount_percentage) : ?>
                                <?php echo esc_html($discount_percentage); ?>% OFF
                            <?php endif; ?>
                        </p>
                        <p class="mt-4 text-sm md:text-lg font-semibold tracking-wider">
                            <?php if ($original_installment_price_html && $current_installment_price_html) : ?>
                                De <?php echo esc_html($installments_count); ?>x de <span class="line-through text-light/60"><?php echo wp_kses_post($original_installment_price_html); ?></span> por
                            <?php endif; ?>
                        </p>
                        <p class="mt-1 text-2xl md:text-3xl lg:text-4xl font-regular tracking-tight text-light/60">
                            <?php if ($current_installment_price_html) : ?>
                                <?php echo esc_html($installments_count); ?>x de <span class="font-bold text-light"><?php echo wp_kses_post($current_installment_price_html); ?></span>/mês
                            <?php endif; ?>
                        </p>
                        <p class="mt-1 text-base md:text-lg text-primary font-semibold">
                            <?php if ($current_price_html) : ?>
                                ou à vista de <?php echo wp_kses_post($current_price_html); ?>
                            <?php endif; ?>
                        </p>
                    </div>
                <?php endif; ?>

                <div class="space-y-3 text-xs md:text-sm text-light font-semibold w-full flex-1">
                    <div class="flex gap-3 items-center">
                        <span class="size-12 flex items-center justify-center">
                            <img class="h-8 w-12 object-contain" src="<?php echo esc_url(get_theme_image_url('s_icon_microphone.svg')); ?>">
                        </span>
                        <p>Aprenda técnicas práticas para falar com segurança, clareza e impacto em qualquer situação.</p>
                    </div>
                    <div class="flex gap-3 items-center">
                        <span class="size-12 flex items-center justify-center">
                            <img class="h-full w-12 object-contain" src="<?php echo esc_url(get_theme_image_url('s_icon_talk.svg')); ?>">
                        </span>
                        <p>Destrave sua comunicação com exercícios simples e resultados visíveis desde as primeiras aulas.</p>
                    </div>
                    <div class="flex gap-3 items-center">
                        <span class="size-12 flex items-center justify-center">
                            <img class="h-full w-12 object-contain" src="<?php echo esc_url(get_theme_image_url('s_icon_brain.svg')); ?>">
                        </span>
                        <p>Receba um acompanhamento que respeita seu ritmo e seus objetivos pessoais e profissionais.</p>
                    </div>
                    <div class="flex gap-3 items-center">
                        <span class="size-12 flex items-center justify-center">
                            <img class="h-full w-12 object-contain" src="<?php echo esc_url(get_theme_image_url('s_icon_specialist.svg')); ?>">
                        </span>
                        <p>Aprenda com especialistas que já enfrentaram o medo e transformaram a voz em poder.</p>
                    </div>
                    <div class="flex gap-3 items-center">
                        <span class="size-12 flex items-center justify-center">
                            <img class="h-full w-12 object-contain" src="<?php echo esc_url(get_theme_image_url('s_icon_rocket.svg')); ?>">
                        </span>
                        <p>Do iniciante ao avançado, a Tenores oferece caminhos sob medida para cada fase da jornada.</p>
                    </div>
                    <div class="flex gap-3 items-center">
                        <span class="size-16 flex items-center justify-center">
                            <img class="h-16 w-12 object-contain" src="<?php echo esc_url(get_theme_image_url('s_icon_friends.svg')); ?>">
                        </span>
                        <p>Participe de um ambiente acolhedor, troque experiências e pratique com quem está na mesma transformação que você.</p>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex justify-center">
                <a href="<?php echo esc_url($settings['cto_url']); ?>" class="secondary-button">
                    Quero meu acesso
                </a>
            </div>
        </div>
    </div>
</section>