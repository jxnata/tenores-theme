<?php

/**
 * Home articles section.
 *
 * @package Tenores
 */

$articles_query = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 12,
]);
?>

<section id="artigos" class="bg-dark text-light">
    <div class="container px-0 mx-auto py-16 lg:py-20 overflow-hidden">
        <div class="text-center max-w-2xl mx-auto">
            <p class="text-base font-semibold uppercase tracking-widest text-light text-center">
                Artigos que dão voz ao seu crescimento
            </p>
            <p class="text-base font-black uppercase tracking-widest text-primary mt-8 text-center">
                Descubra insights, técnicas e reflexões sobre oratória,<br class="hidden md:block">
                autoconfiança e comunicação inspiradora.
            </p>
        </div>

        <div
            id="articles-carousel"
            class="mt-10"
            data-carousel="true"
            data-carousel-step="1"
            data-carousel-interval="6000">
            <div class="flex flex-row transition-transform duration-500 ease-out will-change-transform" data-carousel-track>
                <?php if ($articles_query->have_posts()) : ?>
                    <?php while ($articles_query->have_posts()) : $articles_query->the_post(); ?>
                        <div class="w-full h-full aspect-[3/4] sm:w-1/2 md:w-1/3 lg:w-1/4 flex flex-row">
                            <article
                                class="rounded-2xl text-dark p-4 flex flex-col gap-4 shadow-lg shadow-black/20 space-y-2 bg-light w-full mx-8 sm:mx-4 transition-all duration-300 hover:scale-105 hover:shadow-xl"
                                style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>'); background-size: cover; background-position: center;">
                                <div class="flex flex-1 flex-col gap-3 pt-4">
                                    <h3 class="text-base font-bold leading-snug text-primary uppercase tracking-widest">
                                        <?php the_title(); ?>
                                    </h3>
                                    <p class="text-sm text-light line-clamp-3">
                                        <?php echo wp_kses_post(wp_trim_words(get_the_excerpt(), 18)); ?>
                                    </p>
                                    <div class="mt-auto pt-3 mx-auto">
                                        <a href="<?php the_permalink(); ?>" class="primary-button transition-all duration-300 hover:scale-110">
                                            Explorar artigo
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <div class="md:col-span-2 lg:col-span-4 text-center text-sm text-light/70">
                        Em breve novos artigos sobre comunicação e oratória.
                    </div>
                <?php endif; ?>
            </div>
            <div class="mt-8 flex items-center justify-center gap-2" data-carousel-pagination></div>
        </div>
    </div>
</section>