<?php
/**
 * Fit With Adi theme functions and definitions.
 *
 * @package FitWithAdi
 */

$fitwithadi_theme = wp_get_theme();
define( 'FITWITHADI_VERSION', $fitwithadi_theme->get( 'Version' ) );

if ( ! function_exists( 'fitwithadi_setup' ) ) {
    /**
     * Theme setup.
     */
    function fitwithadi_setup() {
        load_theme_textdomain( 'fitwithadi', get_template_directory() . '/languages' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support(
            'html5',
            array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
        );
        register_nav_menus(
            array(
                'primary' => __( 'Primary Menu', 'fitwithadi' ),
            )
        );
    }
}
add_action( 'after_setup_theme', 'fitwithadi_setup' );

/**
 * Enqueue scripts and styles.
 */
function fitwithadi_scripts() {
    wp_enqueue_style(
        'fitwithadi-fonts',
        'https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'fitwithadi-main',
        get_template_directory_uri() . '/assets/css/main.css',
        array(),
        FITWITHADI_VERSION
    );

    wp_enqueue_script(
        'fitwithadi-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        FITWITHADI_VERSION,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'fitwithadi_scripts' );

/**
 * Provide a fallback navigation menu for anchor links.
 */
function fitwithadi_fallback_menu() {
    echo '<ul class="site-nav__list">';
    echo '<li><a href="#about">About</a></li>';
    echo '<li><a href="#services">Training</a></li>';
    echo '<li><a href="#experience">Experience</a></li>';
    echo '<li><a href="#testimonials">Success Stories</a></li>';
    echo '<li><a href="#contact">Contact</a></li>';
    echo '</ul>';
}

