<?php

/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress_i236nf4hn5');

/** MySQL database username */
define('DB_USER', 'yD9HOsJbatPSTK5');

/** MySQL database password */
define('DB_PASSWORD', 'CmHnXFdnSQPjFEfp');

/** MySQL hostname */
define('DB_HOST', 'eleanorninacom.ipagemysql.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'gZe/UU^LwG@KO+n^T?MwNyxf_sk&@BkhJCJI$-t+LGMg^tF;Dy[)Bdx)P-AjswsM=J(IQD@Fxj*B{zar^uw_dR;EJla]Lw/hZqiVJGN=Bz<}(jZwcDaJLD;L+YAhzdmo');
define('SECURE_AUTH_KEY', ')wXR@PP);}I>wg?WpqgLM]vWqZMYGO^Y;PqL+Vj*?Cbbd?@(iSRg_Ipfnd)U*ko^-eyWet!+$=PIXI<X<D=&![YjvClm}Ht{xOVy_AsJKIrPKCCmi($c>>>M^L}XVz{x');
define('LOGGED_IN_KEY', 'w&Gu%[QtPqvYAba/_JFkrFN{=NAU|{V!b(*;zczJ=+g&M;I&pFFrfJfxAs&bxTl(X@[@>;|wCce$WTjogB|_jII/-+TCT|>W>{D_KcHtUY-Lju|nsT%HAAV*}(|WzGf|');
define('NONCE_KEY', '_QXnFmFTat=;zyjo;]vN^JPpyXozBZm$[&uv+lpHoaWlSM<X;(yF}HKi%=^F{[@H(+o()eAQ/rOEX%kZEo^hRUBFLOFt/^NP;yZMwtRBjT}m%S=V^L{G||]|[;LQ|M$+');
define('AUTH_SALT', '*!dy;(WH?Z}&S;D>-)/n%%HPvRdb^Ite-]jfmLiyoVD(rAGWQRG;[Vu/sycZ-&P?yQj]u)Mw>y@]vm/!Im*dnzMNKOy*c*=nW!IB{Ep;Eg}[KenzM>dO(uMF(mxg>rGr');
define('SECURE_AUTH_SALT', 'b]F!W]hg&T|+iMRZLjfgTMUVLsVkL|Yn*L(fNQ?yx[_OvTAC&)<$EPy(Tb=vc_ydDb[XznZYjt[LbH)fWG[Gv_&vu)BJ>RRvyVwsXK*ARPwQ-mBAPLuuRiy!^;S=dkGN');
define('LOGGED_IN_SALT', 'cuna{/xnR&]f>iTW!KiTdL<<FJFVxK-OH|_J$q}Iv!ny[EFMq!b@$|DJem^@-QVNYR}(HyfgqoUM?IK}a-fCHO_=fi&V*QO]<^V^&=pAdOm>u%Tftge*$bg/&P<OI;&V');
define('NONCE_SALT', 'V&QgYaA+M!PDqhr*Vb>dlk-(s]VTnpXL(]-{c@]vlvJT{$H=!G)WyFB)a|vS&}tjYxE&MAG|@*>zeDG^LCU+fQgERwdI>myeJ&ra]?WWTmcONbEWE_?rRK(/k}K&URy&');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_hvzg_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

/**
 * Include tweaks requested by hosting providers.  You can safely
 * remove either the file or comment out the lines below to get
 * to a vanilla state.
 */
if (file_exists(ABSPATH . 'hosting_provider_filters.php')) {
	include('hosting_provider_filters.php');
}
