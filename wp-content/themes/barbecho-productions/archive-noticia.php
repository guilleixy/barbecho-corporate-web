<?php get_header(); ?>

<main class="main" role="main">
    <?php get_template_part('template-parts/hero', null, [
        'title' => 'Noticias',
        'thumbnail_id' => null,
    ]); ?>

    <section class="news-section news-section--archive">
        <h1 class="news-section__title text-3xl with-leading-slash">Noticias</h1>

        <?php if (have_posts()) : ?>
            <div class="news-section__grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="news-card">
                        <a class="news-card__link" href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="news-card__thumbnail">
                                    <?php the_post_thumbnail('large'); ?>
                                </div>
                            <?php endif; ?>

                            <h2 class="news-card__title text-lg"><?php the_title(); ?></h2>
                        </a>

                        <time class="news-card__date text-xs" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                            <?php echo esc_html(get_the_date('d/m/Y')); ?>
                        </time>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <p>No hay noticias disponibles.</p>
        <?php endif; ?>
    </section>
</main>

<?php get_footer(); ?>
