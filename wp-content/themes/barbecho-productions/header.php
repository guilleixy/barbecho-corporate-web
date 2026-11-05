<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <?php wp_body_open(); ?>
        <header class="header" role="banner">
            <div class="header__navigation gap-xs">
                <nav role="navigation">
                    <?php wp_nav_menu(['theme_location' => 'header', 'menu_class' => 'nav nav--header']); ?>
                </nav>
                <div class="">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header__logo">
                        barbecho
                    </a>
                </div>
            </div>
            <a href="#" class="nav-burger js-menu-toggle">
                <span class="nav-burger__line"></span>
                <span class="nav-burger__line"></span>
                <span class="nav-burger__line"></span>
            </a>
        </header>
