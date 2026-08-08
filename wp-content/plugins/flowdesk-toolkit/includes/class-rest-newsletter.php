<?php
/**
 * REST endpoint custom: POST /wp-json/flowdesk/v1/newsletter
 * Nonce propio (no el de autenticación REST — este endpoint es público),
 * honeypot, rate-limit por IP, valida email, evita duplicados, guarda como
 * CPT "newsletter_subscriber" y notifica al admin por mail.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Flowdesk_REST_Newsletter {

	// Nombres de post type en WP tienen tope de 20 caracteres —
	// "newsletter_subscriber" (22) lo pasaba y disparaba un notice de PHP
	// que corrompía las respuestas REST/sitemap (headers already sent).
	const CPT = 'fd_subscriber';

	public function __construct() {
		add_action( 'init', array( $this, 'register_cpt' ) );
		add_action( 'rest_api_init', array( $this, 'register_route' ) );
	}

	/**
	 * CPT interno (no público) solo para persistir suscriptores sin una
	 * tabla SQL propia — reusa la infraestructura de WP en vez de reinventarla.
	 */
	public function register_cpt() {
		register_post_type( self::CPT, array(
			'label'              => __( 'Suscriptores newsletter', 'flowdesk' ),
			'public'             => false,
			'show_ui'            => true,
			'show_in_menu'       => 'edit.php?post_type=testimonial',
			'publicly_queryable' => false,
			'has_archive'        => false,
			'supports'           => array( 'title' ),
			'capabilities'       => array( 'create_posts' => 'do_not_allow' ), // solo se crea vía REST, no a mano
			'map_meta_cap'       => true,
		) );
	}

	public function register_route() {
		register_rest_route( 'flowdesk/v1', '/newsletter', array(
			'methods'             => 'POST',
			'callback'            => array( $this, 'handle' ),
			'permission_callback' => '__return_true',
			'args'                => array(
				'email' => array( 'required' => true ),
				'nonce' => array( 'required' => true ),
			),
		) );
	}

	public function handle( WP_REST_Request $request ) {
		$nonce    = (string) $request->get_param( 'nonce' );
		$email    = sanitize_email( (string) $request->get_param( 'email' ) );
		$honeypot = (string) $request->get_param( 'company_website' );

		if ( ! wp_verify_nonce( $nonce, 'flowdesk_newsletter' ) ) {
			return new WP_REST_Response( array( 'message' => __( 'Sesión inválida, recargá la página.', 'flowdesk' ) ), 400 );
		}

		// Honeypot: si el bot completó este campo oculto, respondemos éxito
		// falso (no delatamos que lo detectamos) sin guardar nada.
		if ( '' !== $honeypot ) {
			return new WP_REST_Response( array( 'message' => __( 'Listo, ya estás suscripto.', 'flowdesk' ) ), 201 );
		}

		if ( ! flowdesk_rate_limit_check( 'newsletter', 5, 600 ) ) {
			return new WP_REST_Response( array( 'message' => __( 'Demasiados intentos, probá en unos minutos.', 'flowdesk' ) ), 429 );
		}

		if ( ! is_email( $email ) ) {
			return new WP_REST_Response( array( 'message' => __( 'Ese email no parece válido.', 'flowdesk' ) ), 400 );
		}

		$existing = get_posts( array(
			'post_type'      => self::CPT,
			'title'          => $email,
			'post_status'    => 'private',
			'posts_per_page' => 1,
		) );
		if ( ! empty( $existing ) ) {
			return new WP_REST_Response( array( 'message' => __( 'Ya estabas suscripto con ese email.', 'flowdesk' ) ), 409 );
		}

		$post_id = wp_insert_post( array(
			'post_type'   => self::CPT,
			'post_title'  => $email,
			'post_status' => 'private',
		), true );

		if ( is_wp_error( $post_id ) ) {
			return new WP_REST_Response( array( 'message' => __( 'No se pudo guardar la suscripción.', 'flowdesk' ) ), 500 );
		}

		$notify = get_option( 'flowdesk_newsletter_notify_email' ) ?: get_option( 'admin_email' );
		wp_mail(
			$notify,
			sprintf( '[%s] Nuevo suscriptor de newsletter', get_bloginfo( 'name' ) ),
			sprintf( "Nuevo suscriptor: %s\n", $email )
		);

		return new WP_REST_Response( array( 'message' => __( 'Listo, ya estás suscripto.', 'flowdesk' ) ), 201 );
	}
}
