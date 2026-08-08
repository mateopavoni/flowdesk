<?php
/**
 * Hardening básico: ocultar versión de WP, desactivar XML-RPC, rate-limit
 * de intentos de login. Wordfence/etc. quedan como recomendación opcional
 * en setup-instructions.md — esto cubre lo esencial sin esa dependencia.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Flowdesk_Security_Hardening {

	const LOGIN_MAX_ATTEMPTS = 5;
	const LOGIN_WINDOW       = 900; // 15 min

	public function __construct() {
		// Ocultar versión de WP.
		add_filter( 'the_generator', '__return_empty_string' );
		remove_action( 'wp_head', 'wp_generator' );

		// Menos metadata de "esto es WordPress" en <head>.
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );

		// XML-RPC off de verdad: el filtro 'xmlrpc_enabled' solo bloquea el
		// login vía XML-RPC, no system.listMethods/pingback.* (verificado a
		// mano: con solo ese filtro, system.listMethods seguía respondiendo
		// la lista completa de métodos sin autenticar). Cortamos el endpoint
		// entero antes de que WP llegue a instanciar el server. Usa exit
		// directo, no wp_die(): en contexto XML-RPC, wp_die() delega a un
		// handler que espera al server de IXR ya instanciado (más adelante
		// en xmlrpc.php) — llamado desde 'init' produce una respuesta 200
		// vacía en vez del 403 (verificado a mano).
		add_action( 'init', array( $this, 'block_xmlrpc' ) );

		// Editor de archivos desde wp-admin off, por si wp-config no lo definió.
		if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
			define( 'DISALLOW_FILE_EDIT', true );
		}

		// Rate-limit de login.
		add_filter( 'authenticate', array( $this, 'block_if_locked_out' ), 30, 1 );
		add_action( 'wp_login_failed', array( $this, 'register_failed_attempt' ) );
		add_action( 'wp_login', array( $this, 'clear_attempts' ) );
	}

	public function block_xmlrpc() {
		if ( false !== strpos( $_SERVER['SCRIPT_NAME'] ?? '', 'xmlrpc.php' ) ) {
			status_header( 403 );
			header( 'Content-Type: text/plain; charset=utf-8' );
			exit( 'XML-RPC está deshabilitado en este sitio.' );
		}
	}

	private function key(): string {
		return 'flowdesk_login_attempts_' . md5( flowdesk_client_ip() );
	}

	public function block_if_locked_out( $user ) {
		$attempts = (int) get_transient( $this->key() );
		if ( $attempts >= self::LOGIN_MAX_ATTEMPTS ) {
			return new WP_Error(
				'flowdesk_locked_out',
				__( '<strong>Error:</strong> demasiados intentos fallidos. Probá de nuevo en 15 minutos.', 'flowdesk' )
			);
		}
		return $user;
	}

	public function register_failed_attempt() {
		$key = $this->key();
		$attempts = (int) get_transient( $key );
		set_transient( $key, $attempts + 1, self::LOGIN_WINDOW );
	}

	public function clear_attempts() {
		delete_transient( $this->key() );
	}
}
