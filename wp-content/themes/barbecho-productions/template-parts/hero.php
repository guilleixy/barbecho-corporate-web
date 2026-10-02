<?php
$title = $args['title'] ?? get_the_title();
?>
<section class="hero container">
    <div class="hero__vertical-line js-hero-vertical-lines"></div>
    <h1 class="hero__title js-split-up"><?php echo esc_html( $title ); ?></h1>
    <div class="hero__bottom-offset">
        <div class="hero__bottom-offset__horizontal-line js-hero-horizontal-lines"></div>
    </div>
</section>
