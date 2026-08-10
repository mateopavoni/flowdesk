<?php
/**
 * Hero del home: título + subtítulo + 2 CTAs.
 */
?>
<section class="container-fd py-20 sm:py-28 text-center">
	<p class="fd-eyebrow mx-auto"><?php bloginfo( 'name' ); ?></p>

	<h1 class="mt-6 text-3xl sm:text-5xl lg:text-6xl leading-tight max-w-3xl mx-auto">
		<?php esc_html_e( 'El trabajo de tu equipo, organizado sin fricción', 'flowdesk' ); ?>
	</h1>
	<p class="mt-6 text-base text-ink-400 max-w-2xl mx-auto">
		<?php esc_html_e( 'FlowDesk junta tareas, tiempos y comunicación en un solo lugar para que dejes de perseguir actualizaciones por cinco herramientas distintas.', 'flowdesk' ); ?>
	</p>

	<div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
		<a href="#pricing" class="btn-primary"><?php esc_html_e( 'Prueba gratis', 'flowdesk' ); ?></a>
		<a href="#video" class="btn-outline"><?php esc_html_e( 'Ver demo', 'flowdesk' ); ?></a>
	</div>
	<p class="mt-6 text-xs text-ink-400">
		<?php esc_html_e( 'Sin tarjeta, cancelás cuando quieras', 'flowdesk' ); ?>
	</p>
</section>
