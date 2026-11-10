<?php get_header(); ?>

<main class="somos" role="main">
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

</main>

<?php get_footer(); ?>
