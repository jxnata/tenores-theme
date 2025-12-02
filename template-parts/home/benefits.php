<?php
/**
 * Home benefits section.
 *
 * @package Tenores
 */
?>

<section class="bg-dark text-light">
    <div class="container mx-auto py-16 lg:py-20">
        <div class="text-center max-w-2xl mx-auto">
            <p class="text-xs md:text-sm font-semibold uppercase tracking-[0.3em] text-light/70">
                Pronto para mudar?
            </p>
            <p class="mt-2 text-xs md:text-sm font-semibold uppercase tracking-[0.25em] text-primary">
                Descubra agora os motivos que vão fazer<br class="hidden md:block">
                você começar hoje.
            </p>
        </div>

        <div class="mt-10 grid gap-6 md:grid-cols-3 lg:grid-cols-6">
            <?php
            $benefits = [
                [
                    'icon' => 'mic-2',
                    'title' => 'Confiança para falar em público',
                    'text'  => 'Supere a insegurança e perca o medo de se expor em qualquer situação.',
                ],
                [
                    'icon' => 'message-circle',
                    'title' => 'Comunicação clara e envolvente',
                    'text'  => 'Capacidade de transmitir ideias com emoção, clareza e conexão genuína.',
                ],
                [
                    'icon' => 'activity',
                    'title' => 'Controle da voz e da expressão corporal',
                    'text'  => 'Domine o tom de voz, gestos e postura para falar com autoridade.',
                ],
                [
                    'icon' => 'rocket',
                    'title' => 'Crescimento profissional acelerado',
                    'text'  => 'Habilidades de oratória que abrem portas e destacam você em qualquer ambiente.',
                ],
                [
                    'icon' => 'shield-check',
                    'title' => 'Superação da timidez e do medo de errar',
                    'text'  => 'Coragem para se colocar, confiar em si e se comunicar com segurança.',
                ],
                [
                    'icon' => 'stars',
                    'title' => 'Capacidade de inspirar e influenciar pessoas',
                    'text'  => 'Fale com impacto, mova pessoas à ação e marque presença por onde passar.',
                ],
            ];

            foreach ($benefits as $benefit): ?>
                <div class="rounded-2xl bg-light text-dark px-5 pb-6 pt-6 flex flex-col gap-4 shadow-lg shadow-black/20">
                    <div class="inline-flex size-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                        <i data-lucide="<?php echo esc_attr($benefit['icon']); ?>" class="size-5"></i>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-xs md:text-sm font-extrabold uppercase tracking-[0.18em]">
                            <?php echo esc_html($benefit['title']); ?>
                        </h3>
                        <p class="text-xs md:text-sm text-dark/80 leading-relaxed">
                            <?php echo esc_html($benefit['text']); ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


