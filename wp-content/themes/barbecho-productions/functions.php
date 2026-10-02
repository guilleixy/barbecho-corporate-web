<?php

/**
 * Custom functions
 */

require_once get_template_directory() . '/includes/setup.php';
require_once get_template_directory() . '/includes/admin.php';
require_once get_template_directory() . '/includes/menus.php';
require_once get_template_directory() . '/includes/loaders.php';
require_once get_template_directory() . '/includes/shortcodes.php';
require_once get_template_directory() . '/includes/blocks.php';
require_once get_template_directory() . '/includes/custom.php';
require_once get_template_directory() . '/includes/acf.php';

function theme_gsap_script(){
    // The core GSAP library
    wp_enqueue_script( 'gsap-js', 'https://cdn.jsdelivr.net/npm/gsap@3.15/dist/gsap.min.js', array(), false, true );
    // ScrollTrigger - with gsap.js passed as a dependency
    wp_enqueue_script( 'gsap-st', 'https://cdn.jsdelivr.net/npm/gsap@3.15/dist/ScrollTrigger.min.js', array('gsap-js'), false, true );
    // Your animation code file - with gsap.js passed as a dependency
    wp_enqueue_script( 'gsap-js2', get_template_directory_uri() . 'js/app.js', array('gsap-js'), false, true );
}

add_action( 'wp_enqueue_scripts', 'theme_gsap_script' );
?>
