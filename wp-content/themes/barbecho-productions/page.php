<?php get_header(); ?>

<main class="main" role="main">
    <section class="claim-section">
        <h2>Hacemos cine</h2>
    </section>
    <div class="claim-section-end">
        <img src="https://static.photos/cat"/>
        <img src="https://static.photos/cat"/>
        <img src="https://static.photos/cat"/>
        <img src="https://static.photos/cat"/>
        <img src="https://static.photos/cat"/>
        <img src="https://static.photos/cat"/>
        <img src="https://static.photos/cat"/>
        <img src="https://static.photos/cat"/>
    </div>
    <section class="projects-section">

    </section>
    <?php while ( have_posts() ) : the_post(); ?>

        <?php the_content(); ?>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
