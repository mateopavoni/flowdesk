<?php
/**
 * 4 features del producto.
 */
$features = array(
	array(
		'title' => __( 'Tableros por proyecto', 'flowdesk' ),
		'desc'  => __( 'Vista kanban o lista, cambiás sobre la marcha sin perder el estado de cada tarea.', 'flowdesk' ),
		'icon'  => '<rect x="4" y="4" width="7" height="16"/><rect x="13" y="4" width="7" height="9"/>',
	),
	array(
		'title' => __( 'Seguimiento de tiempo', 'flowdesk' ),
		'desc'  => __( 'Cada miembro registra horas por tarea, y vos ves dónde se va el tiempo del equipo.', 'flowdesk' ),
		'icon'  => '<circle cx="12" cy="13" r="8"/><path d="M12 9v4l3 2"/><path d="M9 2h6"/>',
	),
	array(
		'title' => __( 'Automatizaciones', 'flowdesk' ),
		'desc'  => __( 'Reglas simples ("si se completa X, avisá a Y") que sacan trabajo repetitivo de encima.', 'flowdesk' ),
		'icon'  => '<path d="M4 12h6l-2 8 12-12h-6l2-8z"/>',
	),
	array(
		'title' => __( 'Reportes en vivo', 'flowdesk' ),
		'desc'  => __( 'Progreso del sprint y carga por persona, sin armar una planilla a mano cada semana.', 'flowdesk' ),
		'icon'  => '<path d="M4 20V10M11 20V4M18 20v-7"/>',
	),
);
?>
<section id="features" class="bg-paper-100 py-20 border-y border-line">
	<div class="container-fd">
		<div class="text-center max-w-2xl mx-auto">
			<p class="fd-eyebrow mx-auto"><?php esc_html_e( 'Producto', 'flowdesk' ); ?></p>
			<h2 class="mt-4 text-2xl sm:text-3xl">
				<?php esc_html_e( 'Todo lo que un equipo chico necesita, nada de lo que no', 'flowdesk' ); ?>
			</h2>
		</div>
		<div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
			<?php foreach ( $features as $feature ) : ?>
				<div class="fd-card p-6">
					<span class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-brand-100 text-brand-700">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><?php echo $feature['icon']; // phpcs:ignore -- markup fijo definido arriba, no viene de input de usuario ?></svg>
					</span>
					<h3 class="mt-4 text-base"><?php echo esc_html( $feature['title'] ); ?></h3>
					<p class="mt-2 text-sm text-ink-600"><?php echo esc_html( $feature['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
