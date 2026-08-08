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

	public function render() {
		ob_start();
		?>
		<div class="grid gap-8 md:grid-cols-3 items-start">
			<?php foreach ( $this->plans() as $plan ) : ?>
				<div class="rounded-2xl p-8 <?php echo $plan['highlight'] ? 'bg-blue-900 text-white shadow-xl md:-translate-y-2' : 'border border-slate-100'; ?>">
					<p class="font-heading font-semibold text-lg"><?php echo esc_html( $plan['name'] ); ?></p>
					<p class="mt-4">
						<span class="text-4xl font-heading font-bold">$<?php echo esc_html( $plan['price'] ); ?></span>
						<span class="text-sm <?php echo $plan['highlight'] ? 'text-blue-200' : 'text-slate-500'; ?>"><?php echo esc_html( $plan['period'] ); ?></span>
					</p>
					<ul class="mt-6 space-y-3 text-sm">
						<?php foreach ( $plan['features'] as $feature ) : ?>
							<li class="flex items-center gap-2">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="shrink-0" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
								<?php echo esc_html( $feature ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
					<a
						href="#contacto"
						class="btn mt-8 w-full <?php echo $plan['highlight'] ? 'bg-white text-blue-900 hover:bg-blue-50' : 'bg-blue-900 text-white hover:bg-blue-800'; ?>"
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
