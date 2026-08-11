<?php
/**
 * 4 features del producto.
 */
$features = array(
	array(
		'title' => __( 'Tableros por proyecto', 'flowdesk' ),
		'desc'  => __( 'Vista kanban o lista, cambiás sobre la marcha sin perder el estado de cada tarea.', 'flowdesk' ),
		'icon'  => 'layout',
	),
	array(
		'title' => __( 'Seguimiento de tiempo', 'flowdesk' ),
		'desc'  => __( 'Cada miembro registra horas por tarea, y vos ves dónde se va el tiempo del equipo.', 'flowdesk' ),
		'icon'  => 'clock',
	),
	array(
		'title' => __( 'Automatizaciones', 'flowdesk' ),
		'desc'  => __( 'Reglas simples ("si se completa X, avisá a Y") que sacan trabajo repetitivo de encima.', 'flowdesk' ),
		'icon'  => 'zap',
	),
	array(
		'title' => __( 'Reportes en vivo', 'flowdesk' ),
		'desc'  => __( 'Progreso del sprint y carga por persona, sin armar una planilla a mano cada semana.', 'flowdesk' ),
		'icon'  => 'bar-chart',
	),
);
?>
<section id="features" class="bg-paper-100 py-20 border-y border-line">
	<div class="container-fd">
		<div class="text-center max-w-2xl mx-auto">
			<p class="fd-eyebrow mx-auto"><?php esc_html_e( 'Producto', 'flowdesk' ); ?></p>
			<h2 class="mt-4 text-2xl sm:text-3xl fd-reveal">
				<?php esc_html_e( 'Todo lo que un equipo chico necesita, nada de lo que no', 'flowdesk' ); ?>
			</h2>
		</div>
		<div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
			<?php foreach ( $features as $feature ) : ?>
				<div class="fd-card-hover p-6 sm:p-8 fd-reveal">
					<span class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-brand-100 text-brand-700">
						<?php echo flowdesk_icon( $feature['icon'] ); ?>
					</span>
					<h3 class="mt-4 text-base"><?php echo esc_html( $feature['title'] ); ?></h3>
					<p class="mt-2 text-sm text-ink-600"><?php echo esc_html( $feature['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
