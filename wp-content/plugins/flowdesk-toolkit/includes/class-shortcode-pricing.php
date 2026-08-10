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
	 * Presentadas como placas de especificaciones de equipo (nameplate +
	 * filas de spec), no el típico "card destacada con checkmarks" de
	 * pricing table SaaS. El plan recomendado se marca con una etiqueta,
	 * no recoloreando toda la card.
	 */
	public function render() {
		ob_start();
		$mod_ids = array( 'MOD-ALFA', 'MOD-BRAVO', 'MOD-CHARLIE' );
		?>
		<div class="grid gap-6 md:grid-cols-3 items-start font-sans">
			<?php foreach ( $this->plans() as $i => $plan ) : ?>
				<div class="fd-panel <?php echo $plan['highlight'] ? 'border-amber' : ''; ?>">
					<?php if ( $plan['highlight'] ) : ?>
						<div class="fd-hazard-edge"></div>
					<?php endif; ?>
					<div class="p-6 sm:p-8">
						<div class="flex items-center justify-between">
							<p class="fd-nameplate"><?php echo esc_html( $mod_ids[ $i ] ?? 'MOD' ); ?> // <?php echo esc_html( strtoupper( $plan['name'] ) ); ?></p>
							<?php if ( $plan['highlight'] ) : ?>
								<span class="flex items-center gap-1 font-sans text-[10px] text-amber uppercase tracking-widest"><span class="fd-led is-on"></span>Active</span>
							<?php endif; ?>
						</div>
						<p class="mt-5">
							<span class="text-3xl sm:text-4xl font-heading text-slate-900">$<?php echo esc_html( $plan['price'] ); ?></span>
							<span class="text-xs text-slate-500"><?php echo esc_html( $plan['period'] ); ?></span>
						</p>
						<ul class="mt-6 space-y-3 text-sm border-t border-metal pt-6">
							<?php foreach ( $plan['features'] as $feature ) : ?>
								<li class="flex items-center gap-2.5">
									<span class="w-2 h-2 shrink-0 <?php echo $plan['highlight'] ? 'bg-amber' : 'bg-slate-500'; ?>" aria-hidden="true"></span>
									<?php echo esc_html( $feature ); ?>
								</li>
							<?php endforeach; ?>
						</ul>
						<a
							href="#contacto"
							class="btn mt-8 w-full <?php echo $plan['highlight'] ? 'bg-amber text-anthracite hover:bg-hazard' : 'bg-metal text-slate-800 hover:bg-slate-100/10 border border-slate-300'; ?>"
						>
							<?php echo esc_html( $plan['cta'] ); ?>
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
		return ob_get_clean();
	}
}
