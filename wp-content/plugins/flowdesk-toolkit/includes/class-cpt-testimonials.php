<?php
/**
 * CPT "testimonial" — no público (no tiene página propia), lo consume el
 * widget Flowdesk_Testimonials_Widget. Título = nombre del cliente,
 * contenido = la cita, meta = rol/empresa.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Flowdesk_CPT_Testimonials {

	const META_ROLE    = '_flowdesk_client_role';
	const META_COMPANY = '_flowdesk_client_company';

	public function __construct() {
		add_action( 'init', array( $this, 'register_cpt' ) );
		add_action( 'init', array( $this, 'register_meta' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post_testimonial', array( $this, 'save_meta' ) );
	}

	public function register_cpt() {
		register_post_type( 'testimonial', array(
			'label'        => __( 'Testimonios', 'flowdesk' ),
			'labels'       => array(
				'name'          => __( 'Testimonios', 'flowdesk' ),
				'singular_name' => __( 'Testimonio', 'flowdesk' ),
				'add_new_item'  => __( 'Agregar testimonio', 'flowdesk' ),
			),
			'public'             => false,
			'show_ui'            => true,
			'publicly_queryable' => false,
			'has_archive'        => false,
			'menu_icon'          => 'dashicons-format-quote',
			'supports'           => array( 'title', 'editor', 'thumbnail' ),
			'show_in_rest'       => true,
		) );
	}

	public function register_meta() {
		$args = array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'auth_callback' => fn() => current_user_can( 'edit_posts' ),
		);
		register_post_meta( 'testimonial', self::META_ROLE, $args );
		register_post_meta( 'testimonial', self::META_COMPANY, $args );
	}

	public function add_meta_box() {
		add_meta_box(
			'flowdesk_testimonial_details',
			__( 'Rol y empresa', 'flowdesk' ),
			array( $this, 'render_meta_box' ),
			'testimonial',
			'side'
		);
	}

	public function render_meta_box( $post ) {
		wp_nonce_field( 'flowdesk_testimonial_meta', 'flowdesk_testimonial_meta_nonce' );
		$role    = get_post_meta( $post->ID, self::META_ROLE, true );
		$company = get_post_meta( $post->ID, self::META_COMPANY, true );
		?>
		<p>
			<label for="flowdesk_client_role"><?php esc_html_e( 'Rol', 'flowdesk' ); ?></label>
			<input type="text" id="flowdesk_client_role" name="flowdesk_client_role" class="widefat" placeholder="ej: Product Manager" value="<?php echo esc_attr( $role ); ?>" />
		</p>
		<p>
			<label for="flowdesk_client_company"><?php esc_html_e( 'Empresa', 'flowdesk' ); ?></label>
			<input type="text" id="flowdesk_client_company" name="flowdesk_client_company" class="widefat" value="<?php echo esc_attr( $company ); ?>" />
		</p>
		<p class="description"><?php esc_html_e( 'El título del post es el nombre del cliente. El contenido es la cita.', 'flowdesk' ); ?></p>
		<?php
	}

	public function save_meta( $post_id ) {
		if ( ! isset( $_POST['flowdesk_testimonial_meta_nonce'] ) ||
			! wp_verify_nonce( $_POST['flowdesk_testimonial_meta_nonce'], 'flowdesk_testimonial_meta' ) ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		foreach ( array(
			'flowdesk_client_role'    => self::META_ROLE,
			'flowdesk_client_company' => self::META_COMPANY,
		) as $field => $meta_key ) {
			if ( isset( $_POST[ $field ] ) ) {
				update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
			}
		}
	}
}
