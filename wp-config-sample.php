<?php
/**
 * Config de ejemplo para instalar FlowDesk en un hosting WordPress manual
 * (fuera de Docker — ver docker-compose.yml para desarrollo local).
 *
 * Copiá este archivo como wp-config.php en la raíz de WordPress y completá los valores.
 * NUNCA commitees el wp-config.php real (ya está en .gitignore).
 */

define( 'DB_NAME', 'flowdesk' );
define( 'DB_USER', 'flowdesk' );
define( 'DB_PASSWORD', 'cambiar-esto' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

// Prefijo de tablas no-default (hardening básico — ver setup-instructions.md).
$table_prefix = 'fd_';

/**
 * Claves y salts únicos — generar los propios en:
 * https://api.wordpress.org/secret-key/1.1/salt/
 * NUNCA reusar las de este archivo de ejemplo.
 */
define( 'AUTH_KEY', 'pon-una-frase-unica-aca' );
define( 'SECURE_AUTH_KEY', 'pon-una-frase-unica-aca' );
define( 'LOGGED_IN_KEY', 'pon-una-frase-unica-aca' );
define( 'NONCE_KEY', 'pon-una-frase-unica-aca' );
define( 'AUTH_SALT', 'pon-una-frase-unica-aca' );
define( 'SECURE_AUTH_SALT', 'pon-una-frase-unica-aca' );
define( 'LOGGED_IN_SALT', 'pon-una-frase-unica-aca' );
define( 'NONCE_SALT', 'pon-una-frase-unica-aca' );

// Hardening — ver wp-content/plugins/flowdesk-toolkit/includes/class-security-hardening.php
// para lo que se resuelve en código (ocultar versión, desactivar XML-RPC, rate-limit de login).
define( 'DISALLOW_FILE_EDIT', true ); // sin editor de temas/plugins desde wp-admin
define( 'WP_DEBUG', false );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';
