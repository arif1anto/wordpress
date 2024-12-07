<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_custom' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '>Kz{kgpJDs$;j7qCr6[H)_{.|m9.FEoK?]xN2#n3H,.[^BZ B3]+}GXomLtEN]4]' );
define( 'SECURE_AUTH_KEY',  'hi]#bm2slL5[s2:}nKb^S(r5MHko C|CY:eaO?EA3eH/tw-2&M9@gnADl?FaIs{%' );
define( 'LOGGED_IN_KEY',    '5ytNQE&RaKQQ{4D8~;.BVp!ug#&Vfd9{_7[#L^kX<4%=H{WlUXcM<dQ6e4<eevU6' );
define( 'NONCE_KEY',        'JVTq; a~}vj1e^MBHi=8,yh:Z-_>0THEq_}M&U|#d_.SR?+{$f5]Km qwiDnKXp,' );
define( 'AUTH_SALT',        '{;Moc!=`yZJ~id@c@DvfM6pHBgoF0&*B;D=VmVzbQSlC9N6eQX07,1C%A_9DtgW1' );
define( 'SECURE_AUTH_SALT', '-{v_~<0ZsKJtGOJ/9dnqepgAe!uh]`0x_RI3F zI8Epa:<2ss}5>fLg+~cc!f_ b' );
define( 'LOGGED_IN_SALT',   '-Y8#S;xQ.VPF1lb57$B9nrh_&$5[ 64]Rv]nB<Sl@.~f<f5WVQ-NZF*QwFoG@h`g' );
define( 'NONCE_SALT',       ':el^vXkZgL!bfthvRisv+3%mt#a$Q</~m59OdwWrzicP,m[R:wlF*wj3yyiOoYA*' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
