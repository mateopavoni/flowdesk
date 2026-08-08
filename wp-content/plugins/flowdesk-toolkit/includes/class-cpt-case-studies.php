<?php
/**
 * CPT "case_study" con campos nativos (register_post_meta + meta box),
 * sin depender de Advanced Custom Fields.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Flowdesk_CPT_Case_Studies {

	const META_CLIENT  = '_flowdesk_client_name';
	const META_INDUSTRY = '_flowdesk_industry';
	const META_RESULT   = '_flowdesk_result_metric';

	public function __construct() {
		add_action( 'init', array( $this, 'register_cpt' ) );
		add_action( 'init', array( $this, 'register_meta' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post_case_study', array( $this, 'save_meta' ) );
	}

	public function register_cpt() {
		register_post_type( 'case_study', array(
			'label'        => __( 'Casos de éxito', 'flowdesk' ),
			'labels'       => array(
				'name'          => __( 'Casos de éxito', 'flowdesk' ),
				'singular_name' => __( 'Caso de éxito', 'flowdesk' ),
				'add_new_item'  => __( 'Agregar caso de éxito', 'flowdesk' ),
			),
			'public'       => true,
			'has_archive'  => false,
			'rewrite'      => array( 'slug' => 'casos-de-exito' ),
			'menu_icon'    => 'dashicons-chart-line',
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'show_in_rest' => true,
		) );
	}

	public function register_meta() {
		$args = array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
			'auth_callback' => fn() => current_user_can( 'edit_posts' ),
		);
		register_post_meta( 'case_study', self::META_CLIENT, $args );
		register_post_meta( 'case_study', self::META_INDUSTRY, $args );
		register_post_meta( 'case_study', self::META_RESULT, $args );
	}

	public function add_meta_box() {
		add_meta_box(
			'flowdesk_case_study_details',
			__( 'Detalles del caso de éxito', 'flowdesk' ),
			array( $this, 'render_meta_box' ),
			'case_study',
			'side'
		);
	}

	public function render_meta_box( $post ) {
		wp_nonce_field( 'flowdesk_case_study_meta', 'flowdesk_case_study_meta_nonce' );
		$client   = get_post_meta( $post->ID, self::META_CLIENT, true );
		$industry = get_post_meta( $post->ID, self::META_INDUSTRY, true );
		$result   = get_post_meta( $post->ID, self::META_RESULT, true );
		?>
		<p>
			<label for="flowdesk_client_name"><?php esc_html_e( 'Cliente', 'flowdesk' ); ?></label>
			<input type="text" id="flowdesk_client_name" name="flowdesk_client_name" class="widefat" value="<?php echo esc_attr( $client ); ?>" />
		</p>
		<p>
			<label for="flowdesk_industry"><?php esc_html_e( 'Rubro', 'flowdesk' ); ?></label>
			<input type="text" id="flowdesk_industry" name="flowdesk_industry" class="widefat" value="<?php echo esc_attr( $industry ); ?>" />
		</p>
		<p>
			<label for="flowdesk_result_metric"><?php esc_html_e( 'Resultado destacado', 'flowdesk' ); ?></label>
			<input type="text" id="flowdesk_result_metric" name="flowdesk_result_metric" class="widefat" placeholder="ej: +35% entregas a tiempo" value="<?php echo esc_attr( $result ); ?>" />
		</p>
		<?php
	}

	public function save_meta( $post_id ) {
		if ( ! isset( $_POST['flowdesk_case_study_meta_nonce'] ) ||
			! wp_verify_nonce( $_POST['flowdesk_case_study_meta_nonce'], 'flowdesk_case_study_meta' ) ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		foreach ( array(
			'flowdesk_client_name'   => self::META_CLIENT,
			'flowdesk_industry'      => self::META_INDUSTRY,
			'flowdesk_result_metric' => self::META_RESULT,
		) as $field => $meta_key ) {
			if ( isset( $_POST[ $field ] ) ) {
				update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
			}
		}
	}
}
