<?php
/**
 * 4 features. Iconos propios (no Material/Lucide genérico): trazo grueso,
 * bisel achaflanado detrás, sin relleno ni gradiente.
 */
$features = array(
	array(
		'title' => __( 'Tableros por proyecto', 'flowdesk' ),
		'desc'  => __( 'Vista kanban o lista, cambiás sobre la marcha sin perder el estado de cada tarea.', 'flowdesk' ),
		'icon'  => '<rect x="4" y="4" width="7" height="16"/><rect x="13" y="4" width="7" height="9"/>',
		'id'    => 'MOD-01',
	),
	array(
		'title' => __( 'Seguimiento de tiempo', 'flowdesk' ),
		'desc'  => __( 'Cada miembro registra horas por tarea, y vos ves dónde se va el tiempo del equipo.', 'flowdesk' ),
		'icon'  => '<circle cx="12" cy="13" r="8"/><path d="M12 9v4l3 2"/><path d="M9 2h6"/>',
		'id'    => 'MOD-02',
	),
	array(
		'title' => __( 'Automatizaciones', 'flowdesk' ),
		'desc'  => __( 'Reglas simples ("si se completa X, avisá a Y") que sacan trabajo repetitivo de encima.', 'flowdesk' ),
		'icon'  => '<path d="M4 12h6l-2 8 12-12h-6l2-8z"/>',
		'id'    => 'MOD-03',
	),
	array(
		'title' => __( 'Reportes en vivo', 'flowdesk' ),
		'desc'  => __( 'Progreso del sprint y carga por persona, sin armar una planilla a mano cada semana.', 'flowdesk' ),
		'icon'  => '<path d="M4 20V10M11 20V4M18 20v-7"/>',
		'id'    => 'MOD-04',
	),
);
?>
<section id="features" class="container-fd py-20">
	<div class="text-center max-w-2xl mx-auto">
		<p class="fd-nameplate mx-auto"><?php esc_html_e( 'Module status', 'flowdesk' ); ?></p>
		<h2 class="mt-4 text-2xl sm:text-3xl">
			<?php esc_html_e( 'Todo lo que un equipo chico necesita, nada de lo que no', 'flowdesk' ); ?>
		</h2>
	</div>
	<div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
		<?php foreach ( $features as $feature ) : ?>
			<div class="fd-panel p-6">
				<div class="flex items-center justify-between">
					<span
						class="inline-flex items-center justify-center w-12 h-12 bg-anthracite border border-metal text-amber"
						style="clip-path: polygon(6px 0, 100% 0, 100% calc(100% - 6px), calc(100% - 6px) 100%, 0 100%, 0 6px);"
					>
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><?php echo $feature['icon']; // phpcs:ignore -- markup fijo definido arriba, no viene de input de usuario ?></svg>
					</span>
					<span class="fd-led is-on"></span>
				</div>
				<p class="mt-3 font-sans text-[10px] text-slate-500 tracking-widest"><?php echo esc_html( $feature['id'] ); ?></p>
				<h3 class="mt-1 text-base"><?php echo esc_html( $feature['title'] ); ?></h3>
				<p class="mt-2 font-sans text-sm text-slate-600"><?php echo esc_html( $feature['desc'] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</section>
