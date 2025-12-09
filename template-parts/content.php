<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="relative pt-6 lg:pt-12 before:absolute before:top-0 before:left-0 before:h-px before:w-6 before:bg-zinc-950 after:absolute after:top-0 after:right-0 after:left-8 after:h-px after:bg-zinc-950/10">
        <div class="relative">
            <div class="pt-4 flex flex-col md:flex-row gap-4">
                <dl class="w-full md:w-1/3">
                    <?php if (has_post_thumbnail()): ?>
                        <dd class="lg:static">
                            <div class="overflow-hidden rounded-xl bg-light">
                                <?php the_post_thumbnail('medium', ['class' => 'w-full h-auto object-cover aspect-4/3']); ?>
                            </div>
                        </dd>
                    <?php endif; ?>
                </dl>
                <div class="w-full md:w-2/3">
                    <h2 class="text-2xl mb-2 font-bold uppercase text-dark"><a href="<?php the_permalink(); ?>" class="!no-underline"><?php the_title(); ?></a></h2>
                    <dt class="sr-only"><?php _e('Published', 'tailpress'); ?></dt>
                    <dd class="text-sm text-zinc-950">
                        <time datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished" class="text-sm text-zinc-700"><?php echo get_the_date(); ?></time>
                    </dd>
                    <div class="mt-6 max-w-2xl text-base text-zinc-600">
                        <?php the_excerpt(); ?>
                    </div>
                    <a class="mt-8 inline-flex text-dark font-semibold gap-2 !no-underline" aria-label="<?php echo esc_attr(sprintf(__('Ler artigo: %s', 'tailpress'), get_the_title())); ?>" href="<?php the_permalink(); ?>">
                        → <span class="underline"><?php _e('Ler artigo', 'tailpress'); ?></span>
                    </a>
                </div>
            </div>
        </div>
</article>