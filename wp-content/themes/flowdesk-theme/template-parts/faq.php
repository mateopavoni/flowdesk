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
	<h2 class="text-3xl text-center"><?php esc_html_e( 'Preguntas frecuentes', 'flowdesk' ); ?></h2>
	<div class="mt-10 divide-y divide-slate-200">
		<?php foreach ( $faqs as $faq ) : ?>
			<details class="group py-4">
				<summary class="flex items-center justify-between cursor-pointer list-none font-heading font-medium text-slate-900">
					<?php echo esc_html( $faq['q'] ); ?>
					<span class="ml-4 shrink-0 transition-transform group-open:rotate-45" aria-hidden="true">+</span>
				</summary>
				<p class="mt-3 text-sm text-slate-600"><?php echo esc_html( $faq['a'] ); ?></p>
			</details>
		<?php endforeach; ?>
	</div>
</section>
