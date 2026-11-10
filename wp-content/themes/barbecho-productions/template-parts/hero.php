<?php
$title = $args['title'] ?? get_the_title();
$thumbnail_id = $args['thumbnail_id'];
?>
<section class="hero js-hero">
    <div class="hero__vertical-line js-hero-line-vertical hero__line"></div>
    <h1 class="hero__title js-hero-title"><?php echo esc_html( $title ); ?></h1>
    <div class="hero__bottom-offset">
        <div class="hero__bottom-offset__horizontal-line js-hero-line-horizontal hero__line"></div>
    </div>
    <?php

    if ( $thumbnail_id ) :
        $att_url  = wp_get_attachment_url( $thumbnail_id );
        $att_type = get_post_mime_type( $thumbnail_id );
        $is_video = ( $att_type && strpos( $att_type, 'video' ) !== false );
        ?>
        <div class="hero__thumbnail js-hero-thumbnail">
            <?php if ( $is_video ) : ?>
                <video src="<?php echo esc_url( $att_url ); ?>" autoplay muted loop playsinline class="miniatura-video" style="max-width:100%; height:auto;"></video>
            <?php else : ?>
                <?php
                echo wp_get_attachment_image( $thumbnail_id, 'medium', false, array( 'class' => 'miniatura-imagen' ) );
                ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
