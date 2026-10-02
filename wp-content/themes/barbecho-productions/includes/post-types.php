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

function bp_remove_page_editor() {
    remove_post_type_support('page', 'editor');
}

add_action('init', 'bp_remove_page_editor');
