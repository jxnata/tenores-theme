<?php

/**
 * Home benefits section.
 *
 * @package Tenores
 */
?>

<section id="benefits" class="bg-dark text-light">
    <div class="container px-0 mx-auto py-16 lg:py-20 overflow-hidden">
        <div class="text-center max-w-2xl mx-auto">
            <p class="text-sm md:text-base font-bold uppercase text-light mb-6">
                Pronto para mudar?
            </p>
            <p class="text-sm md:text-base font-black uppercase text-primary mb-4">
                Descubra agora os motivos que vão fazer<br class="hidden md:block">
                você começar hoje.
            </p>
        </div>

        <div
            id="benefits-carousel"
            class="mt-10"
            data-carousel="true"
            data-carousel-step="1"
            data-carousel-interval="6000">
            <div class="flex flex-row transition-transform duration-500 ease-out will-change-transform" data-carousel-track>
                <?php
                $benefits = [
                    [
                        'icon' => get_theme_image_url('icon_microphone.svg'),
                        'title' => 'Confiança para falar em público',
                        'text'  => 'Segurança e presença para se expressar com naturalidade e impacto diante de qualquer público.',
                    ],
                    [
                        'icon' => get_theme_image_url('icon_ballon.svg'),
                        'title' => 'Comunicação clara e envolvente',
                        'text'  => 'Capacidade de transmitir ideias com clareza, emoção e conexão genuína com quem ouve.',
                    ],
                    [
                        'icon' => get_theme_image_url('icon_talk.svg'),
                        'title' => 'Controle da voz e da expressão corporal',
                        'text'  => 'Domínio da voz, postura e gestos para comunicar autoridade e autenticidade.',
                    ],
                    [
                        'icon' => get_theme_image_url('icon_rocket.svg'),
                        'title' => 'Crescimento profissional acelerado',
                        'text'  => 'Habilidade de se destacar em reuniões, apresentações e oportunidades de liderança.',
                    ],
                    [
                        'icon' => get_theme_image_url('icon_arm.svg'),
                        'title' => 'Superação da timidez e do medo de errar',
                        'text'  => 'Coragem para se expor, confiar em si e transformar o medo em autoconfiança.',
                    ],
                    [
                        'icon' => get_theme_image_url('icon_stars.svg'),
                        'title' => 'Capacidade de inspirar e influenciar pessoas',
                        'text'  => 'Força para mover, motivar e gerar impacto positivo por meio da sua comunicação.',
                    ],
                ];

                foreach ($benefits as $benefit): ?>
                    <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 flex flex-row">
                        <div class="rounded-2xl text-dark px-5 pb-6 pt-6 flex flex-col gap-4 shadow-lg shadow-black/20 space-y-2 bg-light w-full ml-8 mr-8 sm:ml-4 sm:mr-4">
                            <h3 class="text-sm font-black uppercase tracking-widest text-primary">
                                <?php echo esc_html($benefit['title']); ?>
                            </h3>
                            <p class="text-sm text-dark/80 leading-relaxed">
                                <?php echo esc_html($benefit['text']); ?>
                            </p>
                            <div class="flex items-center justify-center my-3">
                                <img src="<?php echo esc_url($benefit['icon']); ?>" alt="<?php echo esc_attr($benefit['title']); ?>" class="w-30 h-30">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mt-8 flex items-center justify-center gap-2" data-carousel-pagination></div>
        </div>
</section>