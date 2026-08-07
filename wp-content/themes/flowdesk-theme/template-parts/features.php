<?php
/**
 * 4 features con icono (Lucide inline SVG — sin librería de iconos, sin dependencia extra).
 */
$features = array(
	array(
		'title' => __( 'Tableros por proyecto', 'flowdesk' ),
		'desc'  => __( 'Vista kanban o lista, cambiás sobre la marcha sin perder el estado de cada tarea.', 'flowdesk' ),
		'icon'  => '<path d="M3 3h7v18H3zM14 3h7v10h-7z"/>',
	),
	array(
		'title' => __( 'Seguimiento de tiempo', 'flowdesk' ),
		'desc'  => __( 'Cada miembro registra horas por tarea, y vos ves dónde se va el tiempo del equipo.', 'flowdesk' ),
		'icon'  => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/>',
	),
	array(
		'title' => __( 'Automatizaciones', 'flowdesk' ),
		'desc'  => __( 'Reglas simples ("si se completa X, avisá a Y") que sacan trabajo repetitivo de encima.', 'flowdesk' ),
		'icon'  => '<path d="M13 2 3 14h7l-1 8 10-12h-7z"/>',
	),
	array(
		'title' => __( 'Reportes en vivo', 'flowdesk' ),
		'desc'  => __( 'Progreso del sprint y carga por persona, sin armar una planilla a mano cada semana.', 'flowdesk' ),
		'icon'  => '<path d="M3 3v18h18"/><path d="M7 15l4-6 3 4 5-8"/>',
	),
);
?>
<section id="features" class="container-fd py-20">
	<div class="text-center max-w-2xl mx-auto">
		<h2 class="text-3xl"><?php esc_html_e( 'Todo lo que un equipo chico necesita, nada de lo que no', 'flowdesk' ); ?></h2>
	</div>
	<div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
		<?php foreach ( $features as $feature ) : ?>
			<div class="text-center sm:text-left">
				<span class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-blue-50 text-blue-800">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><?php echo $feature['icon']; // phpcs:ignore -- markup fijo definido arriba, no viene de input de usuario ?></svg>
				</span>
				<h3 class="mt-4 text-lg"><?php echo esc_html( $feature['title'] ); ?></h3>
				<p class="mt-2 text-sm text-slate-600"><?php echo esc_html( $feature['desc'] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</section>
