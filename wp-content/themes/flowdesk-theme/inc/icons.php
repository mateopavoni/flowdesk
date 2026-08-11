<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Centraliza los SVGs del theme (antes hand-rolled/inconsistentes en cada
 * template). Un solo stroke-width, un solo viewBox, un solo lugar para
 * agregar íconos nuevos.
 */
function flowdesk_icon( $name, $classes = '' ) {
	$icons = array(
		'menu'          => '<path d="M3 6h18M3 12h18M3 18h18"/>',
		'x'             => '<path d="M18 6 6 18M6 6l12 12"/>',
		'layout'        => '<rect x="4" y="4" width="7" height="16" rx="1"/><rect x="13" y="4" width="7" height="9" rx="1"/>',
		'clock'         => '<circle cx="12" cy="13" r="8"/><path d="M12 9v4l3 2"/><path d="M9 2h6"/>',
		'zap'           => '<path d="M4 12h6l-2 8 12-12h-6l2-8z"/>',
		'bar-chart'     => '<path d="M4 20V10M11 20V4M18 20v-7"/>',
		'check'         => '<path d="M20 6 9 17l-5-5"/>',
		'chevron-left'  => '<path d="M15 18l-6-6 6-6"/>',
		'chevron-right' => '<path d="M9 18l6-6-6-6"/>',
		'plus'          => '<path d="M12 5v14M5 12h14"/>',
		'play'          => '<path d="M8 5v14l11-7z"/>',
	);

	if ( ! isset( $icons[ $name ] ) ) {
		return '';
	}

	$is_fill = 'play' === $name;

	return sprintf(
		'<svg width="24" height="24" viewBox="0 0 24 24" fill="%1$s"%2$s class="%3$s" aria-hidden="true">%4$s</svg>',
		$is_fill ? 'currentColor' : 'none',
		$is_fill ? '' : ' stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"',
		esc_attr( $classes ),
		$icons[ $name ] // markup fijo definido arriba, no input de usuario
	);
}
