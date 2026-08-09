<?php
/**
 * Hero del home: título + subtítulo + 2 CTAs. Concepto "torre de control
 * analógica": la landing se presenta como el panel maestro de FlowDesk.
 */
?>
<section class="flowdesk-gradient text-slate-800 border-b border-metal">
	<div class="container-fd py-20 sm:py-28">
		<div class="fd-panel px-6 py-12 sm:px-12 sm:py-16 text-center max-w-4xl mx-auto">
			<p class="fd-nameplate mx-auto"><?php bloginfo( 'name' ); ?>: OPERATOR CONSOLE</p>

			<h1 class="mt-6 text-3xl sm:text-5xl lg:text-6xl leading-tight max-w-3xl mx-auto text-slate-900">
				<?php esc_html_e( 'El trabajo de tu equipo, organizado sin fricción', 'flowdesk' ); ?>
			</h1>
			<p class="mt-6 font-sans text-base text-slate-600 max-w-2xl mx-auto">
				<?php esc_html_e( 'FlowDesk junta tareas, tiempos y comunicación en un solo lugar para que dejes de perseguir actualizaciones por cinco herramientas distintas.', 'flowdesk' ); ?>
			</p>

			<div class="mt-10 flex items-center justify-center gap-8">
				<?php echo flowdesk_gauge( 72, __( 'CARGA', 'flowdesk' ) ); ?>
				<?php echo flowdesk_gauge( 40, __( 'DEMORA', 'flowdesk' ) ); ?>
			</div>

			<div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
				<a href="#pricing" class="btn-primary"><?php esc_html_e( 'Prueba gratis', 'flowdesk' ); ?></a>
				<a href="#video" class="btn-outline"><?php esc_html_e( 'Ver demo', 'flowdesk' ); ?></a>
			</div>
			<p class="mt-6 font-sans text-xs text-slate-500 uppercase tracking-widest">
				&gt; <?php esc_html_e( 'boot sequence ready — sin tarjeta, cancelás cuando quieras', 'flowdesk' ); ?>
			</p>
		</div>
	</div>
</section>
