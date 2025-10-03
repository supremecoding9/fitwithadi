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

if ( ! function_exists( 'fitwithadi_get_page_link' ) ) {
    /**
     * Safely retrieve a page permalink by its path.
     *
     * @param string $path Page path/slug.
     *
     * @return string
     */
    function fitwithadi_get_page_link( $path ) {
        if ( empty( $path ) ) {
            return '#';
        }

        $page = get_page_by_path( $path );

        if ( $page ) {
            return get_permalink( $page );
        }

        return '#';
    }
}

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
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'fitwithadi' ) . '</a></li>';
    echo '<li><a href="' . esc_url( fitwithadi_get_page_link( 'content-hub' ) ) . '">' . esc_html__( 'Content Hub', 'fitwithadi' ) . '</a></li>';
    echo '<li><a href="' . esc_url( fitwithadi_get_page_link( 'subscriptions' ) ) . '">' . esc_html__( 'Subscriptions', 'fitwithadi' ) . '</a></li>';
    echo '<li><a href="' . esc_url( fitwithadi_get_page_link( 'member-access' ) ) . '">' . esc_html__( 'Member Access', 'fitwithadi' ) . '</a></li>';
    echo '<li><a href="' . esc_url( fitwithadi_get_page_link( 'testimonials' ) ) . '">' . esc_html__( 'Testimonials', 'fitwithadi' ) . '</a></li>';
    echo '</ul>';
}

/**
 * Register custom post types used by the theme.
 */
function fitwithadi_register_content_types() {
    $labels = array(
        'name'                  => _x( 'Testimonials', 'Post type general name', 'fitwithadi' ),
        'singular_name'         => _x( 'Testimonial', 'Post type singular name', 'fitwithadi' ),
        'menu_name'             => _x( 'Testimonials', 'Admin Menu text', 'fitwithadi' ),
        'name_admin_bar'        => _x( 'Testimonial', 'Add New on Toolbar', 'fitwithadi' ),
        'add_new'               => __( 'Add New', 'fitwithadi' ),
        'add_new_item'          => __( 'Add New Testimonial', 'fitwithadi' ),
        'new_item'              => __( 'New Testimonial', 'fitwithadi' ),
        'edit_item'             => __( 'Edit Testimonial', 'fitwithadi' ),
        'view_item'             => __( 'View Testimonial', 'fitwithadi' ),
        'all_items'             => __( 'All Testimonials', 'fitwithadi' ),
        'search_items'          => __( 'Search Testimonials', 'fitwithadi' ),
        'not_found'             => __( 'No testimonials found.', 'fitwithadi' ),
        'not_found_in_trash'    => __( 'No testimonials found in Trash.', 'fitwithadi' ),
        'featured_image'        => _x( 'Client Photo', 'Overrides the “Featured Image” phrase', 'fitwithadi' ),
        'set_featured_image'    => _x( 'Set client photo', 'Overrides the “Set featured image” phrase', 'fitwithadi' ),
        'remove_featured_image' => _x( 'Remove client photo', 'Overrides the “Remove featured image” phrase', 'fitwithadi' ),
        'use_featured_image'    => _x( 'Use as client photo', 'Overrides the “Use as featured image” phrase', 'fitwithadi' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-testimonial',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'rewrite'            => array( 'slug' => 'stories' ),
        'has_archive'        => false,
    );

    register_post_type( 'fit_testimonial', $args );
}
add_action( 'init', 'fitwithadi_register_content_types' );

/**
 * Register a simple admin page to review members who completed the waiver.
 */
function fitwithadi_register_member_admin_page() {
    add_menu_page(
        __( 'FitWithAdi Members', 'fitwithadi' ),
        __( 'FitWithAdi Members', 'fitwithadi' ),
        'manage_options',
        'fitwithadi-members',
        'fitwithadi_render_member_admin_page',
        'dashicons-groups',
        58
    );
}
add_action( 'admin_menu', 'fitwithadi_register_member_admin_page' );

/**
 * Render the members administration screen.
 */
function fitwithadi_render_member_admin_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $members = get_users(
        array(
            'meta_key'     => 'fitwithadi_waiver_attachment_id',
            'meta_compare' => 'EXISTS',
            'orderby'      => 'registered',
            'order'        => 'DESC',
        )
    );

    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'FitWithAdi Member Directory', 'fitwithadi' ); ?></h1>
        <p><?php esc_html_e( 'Review members who have completed the liability waiver. Click the waiver link to download the signed document.', 'fitwithadi' ); ?></p>
        <?php if ( ! empty( $members ) ) : ?>
            <table class="widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php esc_html_e( 'Member', 'fitwithadi' ); ?></th>
                        <th><?php esc_html_e( 'Email', 'fitwithadi' ); ?></th>
                        <th><?php esc_html_e( 'Registered', 'fitwithadi' ); ?></th>
                        <th><?php esc_html_e( 'Waiver', 'fitwithadi' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ( $members as $member ) {
                        $waiver_id  = get_user_meta( $member->ID, 'fitwithadi_waiver_attachment_id', true );
                        $waiver_url = $waiver_id ? wp_get_attachment_url( $waiver_id ) : '';
                        ?>
                        <tr>
                            <td><?php echo esc_html( $member->display_name ); ?></td>
                            <td><a href="mailto:<?php echo esc_attr( $member->user_email ); ?>"><?php echo esc_html( $member->user_email ); ?></a></td>
                            <td><?php echo esc_html( get_date_from_gmt( $member->user_registered, get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ) ); ?></td>
                            <td>
                                <?php if ( $waiver_url ) : ?>
                                    <a href="<?php echo esc_url( $waiver_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Download waiver', 'fitwithadi' ); ?></a>
                                <?php else : ?>
                                    <?php esc_html_e( 'Not uploaded', 'fitwithadi' ); ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        <?php else : ?>
            <p><?php esc_html_e( 'No members have submitted a waiver yet.', 'fitwithadi' ); ?></p>
        <?php endif; ?>
    </div>
    <?php
}

