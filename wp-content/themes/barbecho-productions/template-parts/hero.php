<?php
$title = $args['title'] ?? get_the_title();
?>
<section class="hero container js-hero">
    <div class="hero__vertical-line js-hero-line-vertical hero__line"></div>
    <h1 class="hero__title js-hero-title"><?php echo esc_html( $title ); ?></h1>
    <div class="hero__bottom-offset">
        <div class="hero__bottom-offset__horizontal-line js-hero-line-horizontal hero__line"></div>
    </div>
</section>
