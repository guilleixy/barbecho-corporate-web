<?php

/**
 * Register nav menus
 *
 * @return void
 */

function barbecho_register_nav_menus() {
    register_nav_menus([
        'header' => 'Header',
        'footer' => 'Footer',
    ]);
}

add_action( 'after_setup_theme', 'barbecho_register_nav_menus', 0 );


/**
 * Nav menu args
 *
 * @param array $args
 * @return void
 */

function barbecho_nav_menu_args( $args ) {
    $args['container'] = false;
    $args['container_class'] = false;
    $args['menu_id'] = false;
    $args['items_wrap'] = '<ul class="%2$s">%3$s</ul>';

    return $args;
}

add_filter('wp_nav_menu_args', 'barbecho_nav_menu_args');
