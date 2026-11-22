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

function bp_register_noticias() {
    register_post_type('noticia', [
        'labels' => [
            'name' => __('Noticias', 'barbecho'),
            'singular_name' => __('Noticia', 'barbecho'),
            'add_new_item' => __('Añadir noticia', 'barbecho'),
            'add_new' => __('Añadir noticia', 'barbecho'),
        ],
        'public' => true,
        'has_archive' => 'noticias',
        'rewrite' => ['slug' => 'noticias'],
        'menu_icon' => 'dashicons-megaphone',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'taxonomies' => ['category', 'post_tag'],
        'show_in_rest' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
    ]);
}

add_action('init', 'bp_register_noticias');

function bp_migrate_posts_to_noticias() {
    if (get_option('bp_noticias_migrated_v1')) {
        return;
    }

    $posts = get_posts([
        'post_type' => 'post',
        'post_status' => 'any',
        'numberposts' => -1,
        'fields' => 'ids',
    ]);

    foreach ($posts as $post_id) {
        wp_update_post([
            'ID' => $post_id,
            'post_type' => 'noticia',
        ]);
    }

    flush_rewrite_rules();
    update_option('bp_noticias_migrated_v1', '1');
}

add_action('init', 'bp_migrate_posts_to_noticias');

function bp_remove_page_editor() {
    remove_post_type_support('page', 'editor');
}

add_action('init', 'bp_remove_page_editor');
