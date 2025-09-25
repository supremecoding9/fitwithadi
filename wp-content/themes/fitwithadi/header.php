<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main-content"><?php esc_html_e( 'Skip to content', 'fitwithadi' ); ?></a>
<header class="site-header" id="top">
    <div class="site-header__inner container">
        <a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Fit With Adi home', 'fitwithadi' ); ?>">
            <img class="site-logo__image" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo.svg' ); ?>" alt="<?php esc_attr_e( 'Fit With Adi', 'fitwithadi' ); ?>" width="160" height="48">
        </a>
        <button class="nav-toggle" aria-controls="primary-navigation" aria-expanded="false">
            <span class="nav-toggle__label"><?php esc_html_e( 'Menu', 'fitwithadi' ); ?></span>
            <span class="nav-toggle__icon" aria-hidden="true"></span>
        </button>
        <nav class="site-nav" id="primary-navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'fitwithadi' ); ?>">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'site-nav__list',
                    'fallback_cb'    => 'fitwithadi_fallback_menu',
                )
            );
            ?>
            <div class="site-nav__cta">
                <?php
                $member_access_link = function_exists( 'fitwithadi_get_page_link' ) ? fitwithadi_get_page_link( 'member-access' ) : '#';
                ?>
                <a class="btn btn--small" href="<?php echo esc_url( $member_access_link ); ?>"><?php esc_html_e( 'Join FitWithAdi', 'fitwithadi' ); ?></a>
            </div>
        </nav>
    </div>
</header>

