<?php
/**
 * Widget de testimonios: query dinámica al CPT "testimonial", renderiza un
 * carrusel CSS scroll-snap (los botones prev/next los mueve main.js del tema,
 * ver [data-fd-carousel] — sin librería de slider).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Flowdesk_Testimonials_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'flowdesk_testimonials_widget',
			__( 'FlowDesk — Testimonios', 'flowdesk' ),
			array( 'description' => __( 'Carrusel dinámico de testimonios (CPT testimonial).', 'flowdesk' ) )
		);
	}

	public function widget( $args, $instance ) {
		$count = ! empty( $instance['count'] ) ? (int) $instance['count'] : 5;

		$query = new WP_Query( array(
			'post_type'      => 'testimonial',
			'posts_per_page' => $count,
			'orderby'        => 'date',
			'order'          => 'DESC',
		) );

		if ( ! $query->have_posts() ) {
			return;
		}

		echo $args['before_widget'] ?? '';
		?>
		<div class="relative" data-fd-carousel>
			<div
				class="flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-4 -mx-4 px-4 [scrollbar-width:none]"
				data-fd-carousel-track
				tabindex="0"
				role="region"
				aria-label="<?php esc_attr_e( 'Testimonios de clientes, desplazable', 'flowdesk' ); ?>"
			>
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					$role    = get_post_meta( get_the_ID(), Flowdesk_CPT_Testimonials::META_ROLE, true );
					$company = get_post_meta( get_the_ID(), Flowdesk_CPT_Testimonials::META_COMPANY, true );
					?>
					<figure
						class="snap-start shrink-0 w-[85%] sm:w-[45%] lg:w-[31%] rounded-xl border border-slate-100 bg-white p-6"
						data-fd-carousel-item
					>
						<blockquote class="text-slate-700">
							<p>&ldquo;<?php echo esc_html( wp_strip_all_tags( get_the_content() ) ); ?>&rdquo;</p>
						</blockquote>
						<figcaption class="mt-4 flex items-center gap-3">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'w-10 h-10 rounded-full object-cover' ) ); ?>
							<?php else : ?>
								<span class="w-10 h-10 rounded-full flowdesk-gradient"></span>
							<?php endif; ?>
							<span class="text-sm">
								<span class="block font-heading font-semibold text-slate-900"><?php the_title(); ?></span>
								<span class="block text-slate-500">
									<?php echo esc_html( trim( implode( ' · ', array_filter( array( $role, $company ) ) ) ) ); ?>
								</span>
							</span>
						</figcaption>
					</figure>
				<?php endwhile; ?>
			</div>

			<div class="flex justify-center gap-3 mt-2">
				<button type="button" data-fd-carousel-prev class="w-9 h-9 rounded-full border border-slate-300 hover:border-blue-900" aria-label="<?php esc_attr_e( 'Testimonio anterior', 'flowdesk' ); ?>">‹</button>
				<button type="button" data-fd-carousel-next class="w-9 h-9 rounded-full border border-slate-300 hover:border-blue-900" aria-label="<?php esc_attr_e( 'Siguiente testimonio', 'flowdesk' ); ?>">›</button>
			</div>
		</div>
		<?php
		wp_reset_postdata();
		echo $args['after_widget'] ?? '';
	}

	public function form( $instance ) {
		$count = ! empty( $instance['count'] ) ? (int) $instance['count'] : 5;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Cantidad a mostrar', 'flowdesk' ); ?></label>
			<input class="widefat" type="number" min="1" max="12"
				id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>"
				value="<?php echo esc_attr( $count ); ?>" />
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		return array( 'count' => (int) $new_instance['count'] );
	}
}

add_action( 'widgets_init', function () {
	register_widget( 'Flowdesk_Testimonials_Widget' );
} );
