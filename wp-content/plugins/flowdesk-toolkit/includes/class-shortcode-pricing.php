<?php
/**
 * Shortcode [flowdesk_pricing]: 3 planes. Array en código, no una pantalla
 * de opciones en admin — 3 planes que casi no cambian no justifican esa UI.
 * Si hiciera falta editarlos sin tocar código, el filtro 'flowdesk_pricing_plans'
 * ya permite sobreescribirlos desde functions.php o un mu-plugin.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Flowdesk_Shortcode_Pricing {

	public function __construct() {
		add_shortcode( 'flowdesk_pricing', array( $this, 'render' ) );
	}

	private function plans() {
		$plans = array(
			array(
				'name'      => __( 'Starter', 'flowdesk' ),
				'price'     => '0',
				'period'    => __( '/ para siempre', 'flowdesk' ),
				'features'  => array(
					__( 'Hasta 3 proyectos', 'flowdesk' ),
					__( 'Hasta 3 miembros', 'flowdesk' ),
					__( 'Tableros kanban', 'flowdesk' ),
				),
				'cta'       => __( 'Empezar gratis', 'flowdesk' ),
				'highlight' => false,
			),
			array(
				'name'      => __( 'Team', 'flowdesk' ),
				'price'     => '19',
				'period'    => __( '/ usuario / mes', 'flowdesk' ),
				'features'  => array(
					__( 'Proyectos ilimitados', 'flowdesk' ),
					__( 'Seguimiento de tiempo', 'flowdesk' ),
					__( 'Automatizaciones', 'flowdesk' ),
					__( 'Reportes en vivo', 'flowdesk' ),
				),
				'cta'       => __( 'Prueba gratis 14 días', 'flowdesk' ),
				'highlight' => true,
			),
			array(
				'name'      => __( 'Business', 'flowdesk' ),
				'price'     => '39',
				'period'    => __( '/ usuario / mes', 'flowdesk' ),
				'features'  => array(
					__( 'Todo lo de Team', 'flowdesk' ),
					__( 'SSO', 'flowdesk' ),
					__( 'Permisos avanzados', 'flowdesk' ),
					__( 'Soporte prioritario', 'flowdesk' ),
				),
				'cta'       => __( 'Hablar con ventas', 'flowdesk' ),
				'highlight' => false,
			),
		);

		return apply_filters( 'flowdesk_pricing_plans', $plans );
	}

	/**
	 * El plan recomendado se marca con un borde de color y una etiqueta,
	 * no recoloreando toda la card.
	 */
	public function render() {
		ob_start();
		?>
		<div class="grid gap-6 md:grid-cols-3 items-start">
			<?php foreach ( $this->plans() as $plan ) : ?>
				<div class="fd-card p-6 sm:p-8 fd-reveal <?php echo $plan['highlight'] ? 'border-2 border-violet' : ''; ?>">
					<div class="flex items-center justify-between">
						<p class="fd-eyebrow"><?php echo esc_html( $plan['name'] ); ?></p>
						<?php if ( $plan['highlight'] ) : ?>
							<span class="text-xs font-heading font-semibold text-violet"><?php esc_html_e( 'Recomendado', 'flowdesk' ); ?></span>
						<?php endif; ?>
					</div>
					<p class="mt-5">
						<span class="text-3xl sm:text-4xl font-heading font-semibold text-bone">$<?php echo esc_html( $plan['price'] ); ?></span>
						<span class="text-xs text-haze"><?php echo esc_html( $plan['period'] ); ?></span>
					</p>
					<ul class="mt-6 space-y-3 text-sm border-t border-panel/60 pt-6">
						<?php foreach ( $plan['features'] as $feature ) : ?>
							<li class="flex items-center gap-2.5">
								<span class="w-1.5 h-1.5 rounded-full shrink-0 bg-violet" aria-hidden="true"></span>
								<?php echo esc_html( $feature ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
					<a
						href="#contacto"
						class="<?php echo $plan['highlight'] ? 'btn-primary' : 'btn-outline'; ?> mt-8 w-full"
					>
						<?php echo esc_html( $plan['cta'] ); ?>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
		return ob_get_clean();
	}
}
