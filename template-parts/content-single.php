<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="mx-auto flex max-w-5xl flex-col text-center pt-24">
        <h1 class="mt-6 text-5xl font-extrabold tracking-tight uppercase text-dark sm:text-6xl"><?php the_title(); ?></h1>

        <?php if (! is_page()): ?>
            <time datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished" class="order-first text-sm text-zinc-950"><?php echo get_the_date(); ?></time>
        <?php endif; ?>
    </header>

    <?php if (has_post_thumbnail()): ?>
        <div class="mt-10 sm:mt-20 mx-auto max-w-5xl rounded-3xl bg-light overflow-hidden">
            <?php the_post_thumbnail('large', ['class' => 'aspect-16/10 w-full object-cover']); ?>
        </div>
    <?php endif; ?>

    <div class="entry-content mx-auto max-w-5xl mt-10 sm:mt-20">
        <?php the_content(); ?>
    </div>
</article>