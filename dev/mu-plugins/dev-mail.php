<?php
/**
 * Solo desarrollo local: enruta wp_mail() al contenedor mailpit (docker-compose)
 * en vez de al mail() del sistema, que no existe en la imagen oficial de WP.
 * No se sube a un hosting real — vive en dev/mu-plugins/, fuera de wp-content/
 * del repo publicado, montado como mu-plugin solo en docker-compose.yml.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'phpmailer_init', function ( $phpmailer ) {
	$phpmailer->isSMTP();
	$phpmailer->Host       = 'mailpit';
	$phpmailer->Port       = 1025;
	$phpmailer->SMTPAuth   = false;
	$phpmailer->SMTPSecure = false;
} );

/**
 * El From por default de wp_mail() es "wordpress@localhost" (derivado del
 * host del sitio) — PHPMailer lo rechaza por "localhost" no ser un dominio
 * válido, y wp_mail() falla ANTES de llegar a SMTP. En un hosting real con
 * dominio propio esto no pasa; acá hace falta un From válido para poder
 * probar el flujo completo en local.
 */
add_filter( 'wp_mail_from', fn() => 'dev@flowdesk.local' );
add_filter( 'wp_mail_from_name', fn() => 'FlowDesk (dev)' );
