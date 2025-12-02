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
    <div class="container mx-auto py-16 lg:py-20 grid gap-12 lg:grid-cols-[minmax(0,3fr)_minmax(0,2fr)] items-center">
        <div class="space-y-6">
            <div class="inline-flex items-center justify-center rounded-full bg-primary/10 px-5 py-2 text-primary text-xs font-semibold uppercase tracking-[0.25em]">
                <i data-lucide="quote" class="mr-2 size-4"></i>
                Tenores
            </div>
            <p class="text-base md:text-lg leading-relaxed max-w-xl">
                A <span class="font-semibold">Tenores</span> nasceu para transformar o modo de falar em público em
                <span class="font-semibold text-primary">poder</span> e
                <span class="font-semibold text-secondary">autoconfiança</span>. Aqui você aprende a usar sua voz como
                ferramenta estratégica para conquistar oportunidades e impactar pessoas.
            </p>
        </div>

        <div class="bg-light/5 rounded-3xl border border-light/10 p-8 lg:p-10">
            <?php if ($testimonial_query->have_posts()) : ?>
                <?php while ($testimonial_query->have_posts()) : $testimonial_query->the_post(); ?>
                    <div class="flex flex-col md:flex-row gap-6 items-center">
                        <div class="shrink-0">
                            <div class="size-28 rounded-2xl overflow-hidden border border-light/20 bg-light/10">
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
                            <p>
                                <?php echo wp_kses_post(get_the_content()); ?>
                            </p>
                            <p class="text-xs md:text-sm font-semibold uppercase tracking-[0.18em] text-primary">
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
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <p class="text-sm md:text-base text-light/80">
                    Em breve você verá aqui histórias reais de alunos que transformaram a forma de se comunicar com a Tenores.
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>