<?php

/**
 * Home "voice is gold" section.
 *
 * @package Tenores
 */

$settings = tenores_get_theme_settings();
?>

<section class="bg-primary text-dark">
    <div class="container mx-auto py-12 lg:py-16 grid gap-10 lg:grid-cols-[minmax(0,2fr)_minmax(0,3fr)] items-start">
        <div>
            <h2 class="mt-2 text-3xl md:text-4xl lg:text-5xl font-black leading-tight uppercase [&_span]:text-secondary">
                <span>Sua voz</span><br>
                É uma <span>mina</span><br>
                de <span>ouro</span><br>
                <span>inexplorada</span>
            </h2>

            <div class="mt-8">
                <a href="<?php echo esc_url($settings['cto_url']); ?>" class="secondary-button">
                    <?php esc_html_e('Quero meu acesso', 'tenores'); ?>
                </a>
            </div>
        </div>

        <p class="text-base md:text-lg font-medium leading-relaxed text-light space-y-4 max-w-xl">
            E dentro dela existe um potencial que pode transformar sua vida pessoal e profissional. Quando você aprende a se comunicar com confiança, clareza e emoção, descobre que falar não é apenas transmitir palavras, mas construir conexões, inspirar pessoas e abrir portas que o silêncio jamais abriria. Na escola TENORES, ajudamos você a lapidar essa riqueza interior, dominar sua expressão e transformar sua voz na ferramenta mais poderosa que possui: a de influenciar, encantar e ser lembrado.
    </div>
    </div>
</section>