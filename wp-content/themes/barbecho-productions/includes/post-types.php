<?php

function bp_register_projects() {
    register_post_type('proyecto', [
        'labels' => [
            'name'  => __('Proyectos', 'barbecho'),
            'singular_name' => __('Proyecto', 'barbecho'),
            'add_new_item' => __('Añadir proyecto', 'barbecho'),
        ],
       'public' => true,
       'has_archive' => 'proyectos',
       'rewrite' => ['slug' => 'proyectos'],
       'menu_icon' => 'dashicons-portfolio',
       'supports' => ['title', 'thumbnail', 'excerpt'],
       'show_in_rest' => true
    ]);
}

add_action( 'init', 'bp_register_projects' );

function bp_noticias_rewrite() {
    add_rewrite_rule(
        '^noticias/([^/]+)/?$',
        'index.php?name=$matches[1]',
        'top'
    );
}

add_action('init', 'bp_noticias_rewrite');

function bp_noticias_post_link($permalink, $post) {
    if ($post && $post->post_type === 'post') {
        return home_url('/noticias/' . $post->post_name . '/');
    }

    return $permalink;
}

add_filter('post_link', 'bp_noticias_post_link', 10, 2);

function bp_noticias_flush_rewrite_rules() {
    $rewrite_version = 'noticias-permalink-v1';

    if (get_option('bp_noticias_rewrite_version') !== $rewrite_version) {
        flush_rewrite_rules();
        update_option('bp_noticias_rewrite_version', $rewrite_version);
    }
}

add_action('init', 'bp_noticias_flush_rewrite_rules');

function bp_remove_page_editor() {
    remove_post_type_support('page', 'editor');
}

add_action('init', 'bp_remove_page_editor');
