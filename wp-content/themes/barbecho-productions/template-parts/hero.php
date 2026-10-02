<?php
$title = $args['title'] ?? get_the_title();
?>
<section class="hero container">

    <h1 class="hero__title js-split-up js-hero-lines"><?php echo esc_html( $title ); ?></h1>
</section>
