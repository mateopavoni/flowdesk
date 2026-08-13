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
	<div class="text-center fd-reveal">
		<p class="fd-eyebrow mx-auto"><?php esc_html_e( 'Ayuda', 'flowdesk' ); ?></p>
		<h2 class="mt-4 text-2xl sm:text-3xl"><?php esc_html_e( 'Preguntas frecuentes', 'flowdesk' ); ?></h2>
	</div>
	<div class="mt-10 fd-card divide-y divide-panel/60 fd-reveal">
		<?php foreach ( $faqs as $faq ) : ?>
			<details class="group py-5 sm:py-6 px-6">
				<summary class="flex items-center justify-between gap-3 cursor-pointer list-none font-heading text-bone">
					<span class="flex-1"><?php echo esc_html( $faq['q'] ); ?></span>
					<span class="shrink-0 transition-transform group-open:rotate-45 text-violet" aria-hidden="true"><?php echo flowdesk_icon( 'plus', 'w-4 h-4' ); ?></span>
				</summary>
				<p class="mt-3 text-sm text-haze"><?php echo esc_html( $faq['a'] ); ?></p>
			</details>
		<?php endforeach; ?>
	</div>
</section>
