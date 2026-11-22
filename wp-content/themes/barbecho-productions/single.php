<?php get_header(); ?>

<main class="main" role="main">
    <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class('post'); ?>>
            <header class="post__header">
                <div class="post__header-inner">
                    <div class="post__meta">
                        <?php
                        $categories = get_the_category();
                        if ($categories) :
                            ?>
                            <span class="post__category"><?php echo esc_html($categories[0]->name); ?></span>
                        <?php endif; ?>
                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                            <?php echo esc_html(get_the_date('d/m/Y')); ?>
                        </time>
                    </div>
                    <h1 class="post__title text-3xl"><?php the_title(); ?></h1>
                </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="post__thumbnail">
                    <?php the_post_thumbnail('full'); ?>
                </div>
            <?php endif; ?>

            <div class="post__content">
                <div class="post__content-inner">
                    <?php the_content(); ?>
                </div>
            </div>
        </article>
    <?php endwhile; ?>

    <?php
    $other_news = new WP_Query([
        'post_type'      => 'noticia',
        'post_status'    => 'publish',
        'posts_per_page' => 3,
        'post__not_in'   => [get_queried_object_id()],
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
    ?>
    <?php if ($other_news->have_posts()) : ?>
        <section class="news-section post__other-news">
            <h2 class="news-section__title text-3xl with-leading-slash">Otras noticias</h2>

            <div class="news-section__grid">
                <?php while ($other_news->have_posts()) : $other_news->the_post(); ?>
                    <article class="news-card">
                        <a class="news-card__link" href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="news-card__thumbnail">
                                    <?php the_post_thumbnail('large'); ?>
                                </div>
                            <?php endif; ?>

                            <h3 class="news-card__title text-lg"><?php the_title(); ?></h3>
                        </a>

                        <time class="news-card__date text-xs" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                            <?php echo esc_html(get_the_date('d/m/Y')); ?>
                        </time>
                    </article>
                <?php endwhile; ?>
            </div>
        </section>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
