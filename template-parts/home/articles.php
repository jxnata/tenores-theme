<?php
/**
 * Home articles section.
 *
 * @package Tenores
 */

$articles_query = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 4,
]);
?>

<section id="artigos" class="bg-dark text-light">
    <div class="container mx-auto py-16 lg:py-20">
        <div class="text-center max-w-2xl mx-auto">
            <p class="text-xs md:text-sm font-semibold uppercase tracking-[0.3em] text-light/70">
                Artigos que dão voz ao seu crescimento
            </p>
            <p class="mt-2 text-xs md:text-sm font-semibold uppercase tracking-[0.25em] text-primary">
                Descubra insights, técnicas e reflexões sobre oratória,<br class="hidden md:block">
                autoconfiança e comunicação inspiradora.
            </p>
        </div>

        <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            <?php if ($articles_query->have_posts()) : ?>
                <?php while ($articles_query->have_posts()) : $articles_query->the_post(); ?>
                    <article class="flex flex-col rounded-3xl bg-light/5 border border-light/10 overflow-hidden">
                        <div class="aspect-[4/3] bg-light/10 overflow-hidden">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium_large', ['class' => 'h-full w-full object-cover']); ?>
                            <?php else : ?>
                                <img
                                    src="<?php echo esc_url(get_theme_image_url('icon_microphone.svg')); ?>"
                                    alt="<?php the_title_attribute(); ?>"
                                    class="h-full w-full object-cover">
                            <?php endif; ?>
                        </div>
                        <div class="flex flex-1 flex-col px-5 py-5 gap-3">
                            <h3 class="text-sm font-semibold leading-snug text-light">
                                <?php the_title(); ?>
                            </h3>
                            <p class="text-xs text-light/80 line-clamp-3">
                                <?php echo wp_kses_post(wp_trim_words(get_the_excerpt(), 18)); ?>
                            </p>
                            <div class="mt-auto pt-3">
                                <a href="<?php the_permalink(); ?>"
                                   class="inline-flex items-center justify-center rounded-full bg-primary px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.2em] text-dark !no-underline">
                                    Explorar artigo
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <div class="md:col-span-2 lg:col-span-4 text-center text-sm text-light/70">
                    Em breve novos artigos sobre comunicação e oratória.
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>


