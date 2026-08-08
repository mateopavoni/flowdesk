<?php
/**
 * Plugin Name: FlowDesk Toolkit
 * Plugin URI: https://flowdesk.example.com
 * Description: Case studies, testimonios, pricing, newsletter, formulario de contacto y hardening de seguridad para el tema FlowDesk. Sin ACF, sin dependencias de terceros.
 * Version: 1.0.0
 * Author: Mateo Pavoni
 * Requires at least: 6.0
 * Requires PHP: 8.1
 * License: All Rights Reserved
 * Text Domain: flowdesk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FLOWDESK_PLUGIN_VERSION', '1.0.0' );
define( 'FLOWDESK_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'FLOWDESK_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require FLOWDESK_PLUGIN_DIR . 'includes/class-cpt-case-studies.php';
require FLOWDESK_PLUGIN_DIR . 'includes/class-cpt-testimonials.php';
require FLOWDESK_PLUGIN_DIR . 'includes/class-widget-testimonials.php';
require FLOWDESK_PLUGIN_DIR . 'includes/class-shortcode-pricing.php';
require FLOWDESK_PLUGIN_DIR . 'includes/class-rest-newsletter.php';
require FLOWDESK_PLUGIN_DIR . 'includes/class-contact-form.php';
require FLOWDESK_PLUGIN_DIR . 'includes/class-security-hardening.php';

/**
 * Rate limit genérico por IP, vía transient — lo usan el REST de newsletter
 * y el formulario de contacto. ponytail: bucket fijo por IP+acción, sin
 * limpieza proactiva (el transient expira solo); si el sitio recibe tráfico
 * serio, mover a algo respaldado por Redis/objeto cache.
 *
 * @return bool true si la request está permitida.
 */
function flowdesk_rate_limit_check( string $action, int $max_attempts = 5, int $window_seconds = 600 ): bool {
	$ip  = flowdesk_client_ip();
	$key = 'flowdesk_rl_' . $action . '_' . md5( $ip );
	$count = (int) get_transient( $key );
	if ( $count >= $max_attempts ) {
		return false;
	}
	set_transient( $key, $count + 1, $window_seconds );
	return true;
}

function flowdesk_client_ip(): string {
	$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
	return preg_replace( '/[^0-9a-fA-F:.]/', '', $ip );
}

/**
 * Bootstrap: cada clase se registra a sí misma via add_action/add_filter
 * en su propio constructor (patrón simple, sin contenedor de DI para 7 clases).
 */
function flowdesk_toolkit_init() {
	new Flowdesk_CPT_Case_Studies();
	new Flowdesk_CPT_Testimonials();
	new Flowdesk_Shortcode_Pricing();
	new Flowdesk_REST_Newsletter();
	new Flowdesk_Contact_Form();
	new Flowdesk_Security_Hardening();
	// Flowdesk_Testimonials_Widget se registra en widgets_init (ver su propio archivo).
}
add_action( 'plugins_loaded', 'flowdesk_toolkit_init' );

/**
 * Al activar: crea las páginas "Inicio", "Blog" y "Contacto" si no existen,
 * y configura Ajustes > Lectura para que "/" use front-page.php (landing)
 * y "/blog/" use home.php (índice de posts) — sin esto, page_for_posts no
 * tiene efecto (WP lo ignora salvo que show_on_front sea 'page', verificado
 * a mano: sin este flag /blog/ caía en page.php en vez del grid del blog).
 */
function flowdesk_toolkit_activate() {
	if ( ! get_page_by_path( 'contacto' ) ) {
		wp_insert_post( array(
			'post_title'   => 'Contacto',
			'post_name'    => 'contacto',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		) );
	}

	$home_page = get_page_by_path( 'inicio' );
	if ( ! $home_page ) {
		$home_id = wp_insert_post( array(
			'post_title'  => 'Inicio',
			'post_name'   => 'inicio',
			'post_status' => 'publish',
			'post_type'   => 'page',
		) );
	} else {
		$home_id = $home_page->ID;
	}

	$blog_page = get_page_by_path( 'blog' );
	if ( ! $blog_page ) {
		$blog_id = wp_insert_post( array(
			'post_title'  => 'Blog',
			'post_name'   => 'blog',
			'post_status' => 'publish',
			'post_type'   => 'page',
		) );
	} else {
		$blog_id = $blog_page->ID;
	}

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home_id );
	update_option( 'page_for_posts', $blog_id );

	// Fecha en español natural ("9 de agosto de 2026") en vez del "F j, Y"
	// default de WP — requiere que el sitio esté instalado con locale es_*
	// (ver RUN.md / setup-instructions.md: `wp core install --locale=es_AR`).
	update_option( 'date_format', 'j \d\e F \d\e Y' );

	// Limpieza del contenido de ejemplo que trae WP por default — si no se
	// borra, "Hello world!" queda publicado y cae en "Uncategorized"/"Sin
	// categoría", rompiendo el filtro de categorías del blog (verificado a
	// mano: aparecía como quinta categoría con 1 post fantasma).
	$hello_world = get_page_by_path( 'hello-world', OBJECT, 'post' );
	if ( $hello_world ) {
		wp_delete_post( $hello_world->ID, true );
	}
	$sample_page = get_page_by_path( 'sample-page' );
	if ( $sample_page ) {
		wp_delete_post( $sample_page->ID, true );
	}

	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'flowdesk_toolkit_activate' );

function flowdesk_toolkit_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'flowdesk_toolkit_deactivate' );
