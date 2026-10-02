<?php
$title = $args['title'] ?? get_the_title();
?>
<section class="hero container">
    <div class="hero__vertical-line js-hero-vertical-lines"></div>
    <h1 class="hero__title js-split-up"><?php echo esc_html( $title ); ?></h1>
</section>
