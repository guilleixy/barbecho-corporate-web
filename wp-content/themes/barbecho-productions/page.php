<?php
get_header();
$featured_projects = get_field('featured-projects');
?>

<main class="main" role="main">
    <?php
    $post_id      = get_the_ID();
    $texto_hero   = get_post_meta($post_id, '_bp_page_hero_texto', true);
    $media_id     = get_post_meta($post_id, '_bp_page_hero_media_id', true);
    $title = !empty($texto_hero) ? $texto_hero : get_the_title($post_id);
    get_template_part('template-parts/hero', null, [
        'title' => $title,
        'thumbnail_id'   => $media_id
    ])
    ?>
    <section class="claim-section">
        <div class="claim-section__content">
            <h2 class="text-6xl claim-section__title">Hacemos cine</h2>
            <article>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipiscing elit turpis pulvinar quisque senectus, quam lobortis massa proin leo at volutpat suspendisse class habitasse.
                </p>
            </article>
            <article>
                <p>
                    Tempor vehicula tincidunt et phasellus viverra quam penatibus ullamcorper eget nam, laoreet volutpat ridiculus placerat parturient augue mollis magna varius cubilia.
                </p>
            </article>
        </div>
        <div class="claim-section__images">
            <?php
            $making_of_zorro_uri = get_template_directory_uri() . '/img/making-of-zorro';
            $making_of_zorro_dir = get_template_directory() . '/img/making-of-zorro';
            $making_of_zorro_frames = glob($making_of_zorro_dir . '/*.png');
            usort($making_of_zorro_frames, function ($left, $right) {
                return intval(pathinfo($left, PATHINFO_FILENAME)) <=> intval(pathinfo($right, PATHINFO_FILENAME));
            });
            foreach ($making_of_zorro_frames as $making_of_zorro_frame) :
            ?>
                <img
                    class="claim-section__image"
                    src="<?php echo esc_url($making_of_zorro_uri . '/' . rawurlencode(basename($making_of_zorro_frame))); ?>"
                    alt=""
                    loading="eager"
                >
            <?php endforeach; ?>
        </div>
    </section>
    <div class="claim-section-end">
        <img class="claim-section-end__image" src="https://static.photos/cat"/>
        <img class="claim-section-end__image" src="https://static.photos/cat"/>
        <img class="claim-section-end__image" src="https://static.photos/cat"/>
        <img class="claim-section-end__image" src="https://static.photos/cat"/>
        <img class="claim-section-end__image" src="https://static.photos/cat"/>
        <img class="claim-section-end__image" src="https://static.photos/cat"/>
        <img class="claim-section-end__image" src="https://static.photos/cat"/>
        <img class="claim-section-end__image" src="https://static.photos/cat"/>
    </div>
    <?php if ($featured_projects) : ?>
        <section class="projects-showcase-section">
            <h2 class="projects-showcase-section__title text-5xl with-leading-slash">Proyectos destacados</h3>
            <?php foreach ( $featured_projects as $post ) : ?>
                <?php
                    setup_postdata( $post );
                    $thumbnail = get_field('thumbnail')
                ?>
                <article class="project-showcase">
                    <div>
                        <div class="projects-section__vertical-line">

                        </div>
                    </div>
                    <h4 class="project-showcase__title text-3xl">
                        <?php the_title(); ?>
                    </h4>
                    <?php
                    $miniatura_id = get_post_meta( get_the_ID(), '_bp_proyecto_miniatura', true );

                    if ( $miniatura_id ) :
                        $att_url  = wp_get_attachment_url( $miniatura_id );
                        $att_type = get_post_mime_type( $miniatura_id );
                        $is_video = ( $att_type && strpos( $att_type, 'video' ) !== false );
                        ?>

                        <div class="project-showcase__thumbnail">
                            <div class="project-showcase__thumbnail__wrapper">
                                <?php if ( $is_video ) : ?>
                                    <video src="<?php echo esc_url( $att_url ); ?>" autoplay muted loop playsinline class="miniatura-video" style="max-width:100%; height:auto;"></video>
                                <?php else : ?>
                                    <?php
                                    echo wp_get_attachment_image( $miniatura_id, 'medium', false, array( 'class' => 'miniatura-imagen' ) );
                                    ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
            <?php wp_reset_postdata();?>
        </section>
    <?php endif; ?>

    <section class="awards-section">

    </section>

    <?php
    $news_query = new WP_Query([
        'post_type'      => 'noticia',
        'post_status'    => 'publish',
        'posts_per_page' => 3,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
    ?>
    <?php if ($news_query->have_posts()) : ?>
        <section class="news-section">
            <h2 class="news-section__title text-5xl with-leading-slash">Novedades</h2>

            <div class="news-section__grid">
                <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
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

            <div class="news-section__actions">
                <a class="btn btn--inverse" href="<?php echo esc_url(home_url('/noticias/')); ?>">
                    Ver más
                </a>
            </div>
        </section>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
