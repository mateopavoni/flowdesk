<?php
/**
 * FAQ con <details>/<summary> nativo — acordeón accesible sin una línea de JS.
 */
$faqs = array(
	array(
		'q' => __( '¿Necesito tarjeta para probar FlowDesk?', 'flowdesk' ),
		'a' => __( 'No. El plan gratuito no pide tarjeta y no se convierte en pago automáticamente.', 'flowdesk' ),
	),
	array(
		'q' => __( '¿Puedo cambiar de plan más adelante?', 'flowdesk' ),
		'a' => __( 'Sí, en cualquier momento desde la configuración de tu cuenta, sin perder datos.', 'flowdesk' ),
	),
	array(
		'q' => __( '¿FlowDesk sirve para equipos remotos?', 'flowdesk' ),
		'a' => __( 'Es uno de los casos de uso más comunes: seguimiento de tiempo y automatizaciones están pensados para eso.', 'flowdesk' ),
	),
	array(
		'q' => __( '¿Hay límite de proyectos en el plan pago?', 'flowdesk' ),
		'a' => __( 'No, los planes se diferencian por miembros del equipo y automatizaciones, no por cantidad de proyectos.', 'flowdesk' ),
	),
);
?>
<section id="faq" class="container-fd py-20 max-w-3xl">
	<div class="text-center">
		<p class="fd-nameplate mx-auto"><?php esc_html_e( 'Diagnostics log', 'flowdesk' ); ?></p>
		<h2 class="mt-4 text-2xl sm:text-3xl"><?php esc_html_e( 'Preguntas frecuentes', 'flowdesk' ); ?></h2>
	</div>
	<div class="mt-10 fd-panel divide-y divide-metal">
		<?php foreach ( $faqs as $i => $faq ) : ?>
			<details class="group py-4 px-6">
				<summary class="flex items-center gap-3 cursor-pointer list-none font-heading text-slate-900">
					<span class="font-sans text-xs text-amber shrink-0">Q<?php echo esc_html( str_pad( $i + 1, 2, '0', STR_PAD_LEFT ) ); ?></span>
					<span class="flex-1"><?php echo esc_html( $faq['q'] ); ?></span>
					<span class="ml-4 shrink-0 transition-transform group-open:rotate-45 text-amber font-sans" aria-hidden="true">+</span>
				</summary>
				<p class="mt-3 pl-8 font-sans text-sm text-slate-600"><?php echo esc_html( $faq['a'] ); ?></p>
			</details>
		<?php endforeach; ?>
	</div>
</section>
