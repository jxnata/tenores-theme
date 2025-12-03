<?php

/**
 * Home testimonial section.
 *
 * @package Tenores
 */

$testimonial_query = new WP_Query([
    'post_type'      => 'tenores_testimonial',
    'posts_per_page' => 1,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);
?>

<section class="bg-dark text-light">
    <div class="container mx-auto py-16 lg:py-20 flex flex-col gap-12">
        <div>
            <img src="<?php echo esc_url(get_theme_image_url('s_icon_quote.svg')); ?>" alt="Quote" class="w-16 h-16">
            <h3 class="text-2xl tracking-widest font-bold leading-relaxed w-full [&_span]:text-primary">
                A <span>Tenores</span> nasceu para transformar o modo de falar em público em
                <span>poder</span> e
                <span>autoconfiança</span>.
            </h3>
            <p class="text-lg text-light font-bold leading-relaxed mt-4">
                Gilvan Bueno
            </p>
        </div>

        <p class="text-base font-black uppercase tracking-widest text-primary mt-8 text-center">O que estão falando sobre nós</p>

        <?php if ($testimonial_query->have_posts()) : ?>
            <div
                id="testimonial-carousel"
                class="mt-10"
                data-carousel="true"
                data-carousel-visible="1"
                data-carousel-step="1"
                data-carousel-interval="6000">
                <div class="flex flex-row transition-transform duration-500 ease-out will-change-transform" data-carousel-track>
                    <?php while ($testimonial_query->have_posts()) : $testimonial_query->the_post(); ?>
                        <div class="bg-[#121E2B] p-8 lg:p-10 w-full mx-4">
                            <div class="flex flex-col md:flex-row gap-8 items-center">
                                <div class="shrink-0">
                                    <div class="size-48 rounded-full overflow-hidden border border-light/20 bg-light/10">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('medium', ['class' => 'h-full w-full object-cover']); ?>
                                        <?php else : ?>
                                            <img
                                                src="<?php echo esc_url(get_theme_image_url('icon_stars.png')); ?>"
                                                alt="<?php the_title_attribute(); ?>"
                                                class="h-full w-full object-cover">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="space-y-3 text-sm md:text-base text-light/90">
                                    <p class="font-semibold">
                                        <?php echo wp_kses_post(get_the_content()); ?>
                                    </p>
                                    <p class="text-base font-semibold text-primary">
                                        <?php the_title(); ?>
                                        <?php
                                        $role = tenores_get_testimonial_role(get_the_ID());
                                        if ($role) :
                                        ?>
                                            — <?php echo esc_html($role); ?>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
                <div class="mt-8 flex items-center justify-center gap-2" data-carousel-pagination></div>
            </div>
        <?php else : ?>
            <p class="bg-[#121E2B] p-8 lg:p-10 w-full mx-4 text-light">
                Em breve você verá aqui histórias reais de alunos que transformaram a forma de se comunicar com a Tenores.
            </p>
        <?php endif; ?>
    </div>
</section>