<?php
get_header();
?>
<main class="main" role="main">
    <?php
    get_template_part('template-parts/hero', null, [
        'title' => 'Proyectos'
    ])
    ?>
    <section class="grid-proyectos">
        <?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('card-proyecto'); ?>>

            <?php if ( has_post_thumbnail() ) : ?>
            <div class="imagen-proyecto">
                <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium'); ?>
                </a>
            </div>
            <?php endif; ?>

            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="extracto">
            <?php the_excerpt(); ?>
            </div>

        </article>
        <?php endwhile; ?>
    </section>

    <?php the_posts_pagination(); ?>
</main>
<?php get_footer(); ?>
