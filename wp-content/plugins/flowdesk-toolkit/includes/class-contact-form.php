<?php
/**
 * Formulario de contacto vía admin-post.php (action=flowdesk_contact).
 * Nonce + honeypot + rate-limit + sanitización, responde JSON (lo consume
 * el fetch() de main.js, no hay redirect de página).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Flowdesk_Contact_Form {

	public function __construct() {
		add_action( 'admin_post_flowdesk_contact', array( $this, 'handle' ) );
		add_action( 'admin_post_nopriv_flowdesk_contact', array( $this, 'handle' ) );
	}

	public function handle() {
		if ( ! isset( $_POST['fd_contact_nonce'] ) ||
			! wp_verify_nonce( $_POST['fd_contact_nonce'], 'flowdesk_contact' ) ) {
			wp_send_json_error( array( 'message' => __( 'Sesión inválida, recargá la página.', 'flowdesk' ) ), 400 );
		}

		// Honeypot: respuesta de éxito falsa, no se envía nada.
		if ( ! empty( $_POST['company_website'] ) ) {
			wp_send_json_success( array( 'message' => __( 'Gracias, te vamos a responder pronto.', 'flowdesk' ) ) );
		}

		if ( ! flowdesk_rate_limit_check( 'contact', 5, 600 ) ) {
			wp_send_json_error( array( 'message' => __( 'Demasiados intentos, probá en unos minutos.', 'flowdesk' ) ), 429 );
		}

		$name    = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
		$email   = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
		$message = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );

		if ( '' === $name || ! is_email( $email ) || '' === $message ) {
			wp_send_json_error( array( 'message' => __( 'Completá nombre, email y mensaje.', 'flowdesk' ) ), 400 );
		}

		$sent = wp_mail(
			get_option( 'admin_email' ),
			sprintf( '[%s] Nuevo mensaje de contacto de %s', get_bloginfo( 'name' ), $name ),
			sprintf( "Nombre: %s\nEmail: %s\n\nMensaje:\n%s", $name, $email, $message ),
			array( 'Reply-To: ' . $email )
		);

		if ( ! $sent ) {
			wp_send_json_error( array( 'message' => __( 'No se pudo enviar el mensaje, probá de nuevo.', 'flowdesk' ) ), 500 );
		}

		wp_send_json_success( array( 'message' => __( 'Gracias, te vamos a responder pronto.', 'flowdesk' ) ) );
	}
}
