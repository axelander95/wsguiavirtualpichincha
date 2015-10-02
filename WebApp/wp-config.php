<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'db_guiavirtualpichincha');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'root');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', '');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8mb4');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'RQzagI|,X7[p ?uqC5:u9<h_mhDFeokKhn-2#+*a+@jn1H_8W5ENGF9uSrcJ9? W');
define('SECURE_AUTH_KEY', '4/m 4OZ[_6&F>G_2[:oE0r2Dlz|_(c9LCa0-:Z<Gy[UA%Tz1dghk`|1#.W0=!)y(');
define('LOGGED_IN_KEY', 'n0Jpjuj-)hNgn@SW<XeIeTM&z8gw;}J78p;<:c=)r*0Im7pRDE6XiAo{iT.4&(Lv');
define('NONCE_KEY', 'ZB-lcv=87/7%|xhr?<p# >Q+K6/xzx&n!W5h;k Db)ZNfz|-Fj@1_qyIHX2zIB*G');
define('AUTH_SALT', 'o6mQM9/TS}S*Zjq9Y1)NOj~d7{q8/8MB=6/B5Q^`k<MB7?B]&Wb`1GXujgi*Udv3');
define('SECURE_AUTH_SALT', 'K4z>[992F^xC5X:|O{O&Db._3_BP}9}fjTKJT`$`vmuTFCa:}%5w`#6~}9Y wnJV');
define('LOGGED_IN_SALT', '6Fh5h|T-q$kl~.#z=*<F&&S(<76N}eWDOb0=CP_Ud;5`_9Wvm#C6)@DR9FLRn-vC');
define('NONCE_SALT', 'DI.d>TemX&P%+Gy9 G:O#rSC%~U3-/cN~P/fEXHTwx/tKDKTw.`ylZuCEfjR$puu');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'tb_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

