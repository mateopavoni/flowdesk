<?php
/**
 * Hero del home: título + subtítulo + 2 CTAs.
 */
?>
<section class="relative container-fd py-20 sm:py-28 text-center overflow-hidden">
	<div class="pointer-events-none absolute inset-0 -z-10 flex justify-center" aria-hidden="true">
		<div class="w-[36rem] h-[36rem] rounded-full bg-gradient-to-br from-violet/30 via-amber/10 to-transparent blur-3xl opacity-70 -translate-y-24 animate-pulse [animation-duration:8s]"></div>
	</div>

	<p class="fd-eyebrow mx-auto fd-reveal"><?php bloginfo( 'name' ); ?></p>

	<h1 class="mt-6 text-4xl sm:text-6xl lg:text-7xl font-bold tracking-tight leading-tight max-w-3xl mx-auto fd-reveal">
		<?php esc_html_e( 'El trabajo de tu equipo, organizado sin fricción', 'flowdesk' ); ?>
	</h1>
	<p class="mt-6 text-base text-haze max-w-2xl mx-auto fd-reveal">
		<?php esc_html_e( 'FlowDesk junta tareas, tiempos y comunicación en un solo lugar para que dejes de perseguir actualizaciones por cinco herramientas distintas.', 'flowdesk' ); ?>
	</p>

	<div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4 fd-reveal">
		<a href="#pricing" class="btn-primary"><?php esc_html_e( 'Prueba gratis', 'flowdesk' ); ?></a>
		<a href="#video" class="btn-outline"><?php esc_html_e( 'Ver demo', 'flowdesk' ); ?></a>
	</div>
	<p class="mt-6 text-xs text-haze">
		<?php esc_html_e( 'Sin tarjeta, cancelás cuando quieras', 'flowdesk' ); ?>
	</p>
</section>
