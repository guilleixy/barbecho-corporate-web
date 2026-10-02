<?php

function bb_register_projects() {
    register_post_type('proyecto', [
        'labels' => [
            'name'  => __('Proyectos', 'barebones'),
            'singular_name' => __('Proyecto', 'barebones'),
            'add_new_item' => __('Añadir proyecto', 'barebones'),
        ],
       'public' => true,
       'has_archive' => 'proyectos',
       'rewrite' => ['slug' => 'proyectos'],
       'menu_icon' => 'dashicons-portfolio',
       'supports' => ['title', 'thumbnail', 'excerpt'],
       'show_in_rest' => true
    ]);
}

add_action( 'init', 'bb_register_projects' );

function bb_remove_page_editor() {
    remove_post_type_support('page', 'editor');
}

add_action('init', 'bb_remove_page_editor');
