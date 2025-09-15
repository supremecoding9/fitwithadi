<?php
define( 'WP_CACHE', true );

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'o0H1YudoZ9nfAU' );

/** Database username */
define( 'DB_USER', 'o0H1YudoZ9nfAU' );

/** Database password */
define( 'DB_PASSWORD', 'FlOHtPLPwQHvH4' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3306' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'GQ#F$`?PzN;pt`<i?X^&kR}635a=;h;vKJ0?O^0]Xayzfs`{D&ICyJTEU;CI]YV*' );
define( 'SECURE_AUTH_KEY',   '+ofehyJ~Ng+f^yUQMeVIr&ztucN7,y|+{-DMY<N(_.cen:` x;-N/x3Gp}+/:|2O' );
define( 'LOGGED_IN_KEY',     'msi%TMI0,g{KA8tq)J|tZ5l(4QyG>u=Q?: dF}&_?f8 =14!mzjGYJu3- >D?F|l' );
define( 'NONCE_KEY',         'Wj}50:kQzuWr:yXp&$npXt$I5?V~%G0v{NsSqOR_v.J=Us%{d!jXi2Uwh)z,lSPL' );
define( 'AUTH_SALT',         ':wCCzc<f!JxMVi-<h-D8;*`f^e3CqOq{+PATn5~@ S*K(.Z$4.7#AM6S6cPi8W}z' );
define( 'SECURE_AUTH_SALT',  'DyTasf(F&qRt~p%mp;pi@I)moOTp]4}OU07J,jnw63yqd<;ZpW0>Xe2qieTkv3sb' );
define( 'LOGGED_IN_SALT',    'wU-1%U>[{f9I6(vWl`Na2]?6O?[]xcg ]%[X*I>rRDIT!jLCsA&Hv+=9Mpg]~uQ#' );
define( 'NONCE_SALT',        'A!3[S9K*/vXk`pmJ^1nt75eYj!plQ.OQ2,qST-<7_NHeH+Xvmo9TMZ^f$3$l&qkb' );
define( 'WP_CACHE_KEY_SALT', '5=3.cO_}SAXZTiBKI|~SyjNyj&y{%x;Q|8G0QR)+ Ut0]:*_[tr!;1ld^Z#.1?x)' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
