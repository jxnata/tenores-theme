<?php

/**
 * Page template file.
 *
 * @package Tenores
 */

get_header();
?>

<?php if (have_posts()): ?>
    <?php while (have_posts()): the_post(); ?>
        <?php if (has_post_thumbnail()): ?>
            <section
                class="relative min-h-[720px] lg:min-h-[840px] flex items-center overflow-hidden"
                style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>'); background-size: cover; background-position: center;">
                <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/60 to-black/80"></div>

                <div class="relative container mx-auto">
                    <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-white tracking-widest leading-tight uppercase">
                        <?php the_title(); ?>
                    </h1>
                </div>
            </section>

            <div class="container mx-auto my-10 sm:my-20">
                <div class="entry-content mx-auto max-w-3xl">
                    <?php the_content(); ?>
                </div>
            </div>
        <?php else: ?>
            <div class="container mx-auto my-10 sm:my-20">
                <header class="mx-auto flex max-w-5xl flex-col text-center pt-24">
                    <h1 class="mt-6 text-5xl font-black uppercase tracking-tight [text-wrap:balance] text-dark sm:text-6xl"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content mx-auto max-w-3xl mt-10 sm:mt-20">
                    <?php the_content(); ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>

<?php
get_footer();
