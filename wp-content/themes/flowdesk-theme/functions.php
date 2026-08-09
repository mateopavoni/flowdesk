<?php
/**
 * FlowDesk theme setup.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FLOWDESK_THEME_VERSION', '1.0.0' );
define( 'FLOWDESK_THEME_DIR', get_template_directory() );
define( 'FLOWDESK_THEME_URI', get_template_directory_uri() );

/**
 * Theme setup: solo los supports que el tema realmente usa.
 */
function flowdesk_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 48,
		'width'       => 160,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'automatic-feed-links' );

	register_nav_menus( array(
		'primary' => __( 'Menú principal', 'flowdesk' ),
		'footer'  => __( 'Menú de footer', 'flowdesk' ),
	) );
}
add_action( 'after_setup_theme', 'flowdesk_setup' );

/**
 * Assets: Tailwind compilado + JS del tema.
 */
function flowdesk_enqueue_assets() {
	$css_path = FLOWDESK_THEME_DIR . '/assets/dist/main.css';
	wp_enqueue_style(
		'flowdesk-main',
		FLOWDESK_THEME_URI . '/assets/dist/main.css',
		array(),
		file_exists( $css_path ) ? filemtime( $css_path ) : FLOWDESK_THEME_VERSION
	);

	wp_enqueue_script(
		'flowdesk-main',
		FLOWDESK_THEME_URI . '/assets/js/main.js',
		array(),
		FLOWDESK_THEME_VERSION,
		true
	);
	wp_localize_script( 'flowdesk-main', 'flowdeskData', array(
		'restUrl' => esc_url_raw( rest_url() ),
		'ajaxUrl' => esc_url_raw( admin_url( 'admin-post.php' ) ),
	) );

	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'flowdesk_enqueue_assets' );

/**
 * Excerpt: largo y "más" custom.
 */
add_filter( 'excerpt_length', fn() => 30 );
add_filter( 'excerpt_more', fn() => '…' );

/**
 * Tiempo de lectura estimado (200 palabras/min) — usado en las cards del blog.
 */
function flowdesk_reading_time( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$words   = str_word_count( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ) );
	return max( 1, (int) ceil( $words / 200 ) );
}

/**
 * Posts relacionados: misma categoría principal, excluye el actual.
 */
function flowdesk_related_posts( $post_id = null, $count = 3 ) {
	$post_id = $post_id ?: get_the_ID();
	$cats    = wp_get_post_categories( $post_id );
	if ( empty( $cats ) ) {
		return new WP_Query( array( 'post__not_in' => array( $post_id ), 'posts_per_page' => $count ) );
	}
	return new WP_Query( array(
		'category__in'   => $cats,
		'post__not_in'   => array( $post_id ),
		'posts_per_page' => $count,
		'ignore_sticky_posts' => true,
	) );
}

/**
 * Dial analógico (SVG inline): semicírculo graduado + aguja. Decorativo,
 * motivo de firma del concepto "torre de control" — se usa en el hero.
 * $percent 0-100. Sin JS: la rotación de la aguja se calcula en PHP y se
 * escribe como transform inline, un solo render, nada que animar en cliente.
 */
function flowdesk_gauge( $percent, $label ) {
	$percent = max( 0, min( 100, (int) $percent ) );
	// Escala de -90deg (0%) a +90deg (100%) sobre un semicírculo.
	$angle = -90 + ( $percent / 100 ) * 180;
	ob_start();
	?>
	<div class="flex flex-col items-center gap-2">
		<svg width="88" height="56" viewBox="0 0 88 56" aria-hidden="true">
			<path d="M8 48 A36 36 0 0 1 80 48" fill="none" stroke="#3A3833" stroke-width="3" stroke-linecap="round" />
			<path d="M8 48 A36 36 0 0 1 80 48" fill="none" stroke="#FFB000" stroke-width="3" stroke-linecap="round"
				stroke-dasharray="113" stroke-dashoffset="<?php echo esc_attr( 113 - ( $percent / 100 ) * 113 ); ?>" opacity="0.55" />
			<g transform="rotate(<?php echo esc_attr( $angle ); ?> 44 48)">
				<line x1="44" y1="48" x2="44" y2="18" stroke="#FFB000" stroke-width="2" stroke-linecap="round" />
			</g>
			<circle cx="44" cy="48" r="3.5" fill="#D8CFC0" />
		</svg>
		<span class="fd-nameplate"><?php echo esc_html( $label ); ?></span>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Menú por default si todavía no se configuró uno en wp-admin (fallback de wp_nav_menu).
 */
function flowdesk_default_menu() {
	echo '<ul class="fd-navtabs flex flex-col md:flex-row items-center gap-1 text-xs font-heading uppercase tracking-wide">';
	echo '<li><a href="' . esc_url( home_url( '/#features' ) ) . '">' . esc_html__( 'Producto', 'flowdesk' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/#pricing' ) ) . '">' . esc_html__( 'Precios', 'flowdesk' ) . '</a></li>';
	echo '<li><a href="' . esc_url( get_post_type_archive_link( 'post' ) ?: home_url( '/blog' ) ) . '">' . esc_html__( 'Blog', 'flowdesk' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/#faq' ) ) . '">' . esc_html__( 'FAQ', 'flowdesk' ) . '</a></li>';
	echo '</ul>';
}

require FLOWDESK_THEME_DIR . '/inc/seo.php';
