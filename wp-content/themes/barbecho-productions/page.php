<?php get_header(); ?>

<main class="main" role="main">
    <div class=".js-fade-up">holap</div>
    <?php while ( have_posts() ) : the_post(); ?>

        <?php the_content(); ?>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
