<?php

/**
 * Home offer section.
 *
 * @package Tenores
 */

$settings = tenores_get_theme_settings();

$subscription_price_html = '';
$subscription_product_id = !empty($settings['subscription_product_id']) ? absint($settings['subscription_product_id']) : 0;

// Busca o preço do produto de assinatura
if ($subscription_product_id && function_exists('wc_get_product')) {
    $subscription_product = wc_get_product($subscription_product_id);

    if ($subscription_product) {
        $subscription_price = (float) $subscription_product->get_price();

        if ($subscription_price > 0) {
            if (function_exists('wc_price')) {
                $subscription_price_html = wc_price($subscription_price);
            } else {
                $subscription_price_html = 'R$ ' . number_format($subscription_price, 2, ',', '.');
            }
        }
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
                <?php if ($subscription_price_html) : ?>
                    <div class="w-full flex flex-col gap-2 flex-1 items-center lg:items-start">
                        <p class="mt-1 text-2xl md:text-3xl lg:text-4xl font-regular tracking-tight text-light/60">
                            <span class="font-bold text-light"><?php echo wp_kses_post($subscription_price_html); ?></span>/mês
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