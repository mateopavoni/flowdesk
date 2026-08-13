<?php
/**
 * Case study individual (CPT `case_study`): hero + snapshot (cliente/
 * industria/resultado) + cuerpo + CTA + más casos. Mismo patrón que
 * single.php (fd-card, sidebar), sin plugin de typography instalado
 * — el cuerpo usa .fd-prose (ver input.css) en vez de .prose.
 */
get_header();
?>
<div class="fd-progress" aria-hidden="true"><div class="fd-progress-bar" data-fd-progress-bar></div></div>
<?php
while ( have_posts() ) :
	the_post();
	$client   = get_post_meta( get_the_ID(), '_flowdesk_client_name', true );
	$industry = get_post_meta( get_the_ID(), '_flowdesk_industry', true );
	$result   = get_post_meta( get_the_ID(), '_flowdesk_result_metric', true );
	?>
	<section class="relative container-fd pt-16 pb-10 text-center overflow-hidden">
		<div class="pointer-events-none absolute inset-0 -z-10 flex justify-center" aria-hidden="true">
			<div class="w-[36rem] h-[36rem] rounded-full bg-gradient-to-br from-violet/30 via-amber/10 to-transparent blur-3xl opacity-70 -translate-y-24"></div>
		</div>
		<p class="fd-eyebrow mx-auto"><?php esc_html_e( 'Caso de éxito', 'flowdesk' ); ?></p>
		<h1 class="mt-4 text-3xl sm:text-5xl max-w-3xl mx-auto"><?php the_title(); ?></h1>
		<?php if ( has_excerpt() ) : ?>
			<p class="mt-4 text-base text-haze max-w-2xl mx-auto"><?php echo esc_html( get_the_excerpt() ); ?></p>
		<?php endif; ?>
	</section>

	<?php if ( $client || $industry || $result ) : ?>
		<div class="container-fd">
			<dl class="fd-card grid gap-6 sm:grid-cols-3 p-6 sm:p-8 max-w-3xl mx-auto text-center">
				<?php if ( $client ) : ?>
					<div>
						<dt class="fd-eyebrow justify-center"><?php esc_html_e( 'Cliente', 'flowdesk' ); ?></dt>
						<dd class="mt-2 text-bone font-heading"><?php echo esc_html( $client ); ?></dd>
					</div>
				<?php endif; ?>
				<?php if ( $industry ) : ?>
					<div>
						<dt class="fd-eyebrow justify-center"><?php esc_html_e( 'Industria', 'flowdesk' ); ?></dt>
						<dd class="mt-2 text-bone font-heading"><?php echo esc_html( $industry ); ?></dd>
					</div>
				<?php endif; ?>
				<?php if ( $result ) : ?>
					<div>
						<dt class="fd-eyebrow justify-center"><?php esc_html_e( 'Resultado', 'flowdesk' ); ?></dt>
						<dd class="mt-2 text-amber font-heading text-lg"><?php echo esc_html( $result ); ?></dd>
					</div>
				<?php endif; ?>
			</dl>
		</div>
	<?php endif; ?>

	<div class="container-fd py-16 grid gap-12 lg:grid-cols-[1fr_320px]">
		<article <?php post_class( 'min-w-0' ); ?>>
			<div class="aspect-[16/9] overflow-hidden bg-panel/40 border border-panel/60 rounded-lg">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
				<?php else : ?>
					<div class="relative w-full h-full">
						<img src="<?php echo esc_url( flowdesk_placeholder_image( get_the_ID() ) ); ?>" alt="" loading="lazy" class="w-full h-full object-cover" />
						<div class="absolute inset-0 bg-gradient-to-br from-void/70 via-violet/40 to-amber/10 mix-blend-multiply"></div>
					</div>
				<?php endif; ?>
			</div>

			<div class="fd-prose mt-8">
				<?php the_content(); ?>
			</div>
		</article>

		<aside class="lg:pt-1 space-y-6">
			<div class="fd-card p-6">
				<p class="font-heading text-bone"><?php esc_html_e( '¿Esto se parece a tu equipo?', 'flowdesk' ); ?></p>
				<p class="mt-2 text-sm text-haze"><?php esc_html_e( 'Hablemos de cómo FlowDesk encaja en tu operación.', 'flowdesk' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>" class="btn-primary mt-4 w-full !text-sm">
					<?php esc_html_e( 'Contactar', 'flowdesk' ); ?>
				</a>
			</div>

			<?php
			$more = new WP_Query( array(
				'post_type'      => 'case_study',
				'posts_per_page' => 3,
				'post__not_in'   => array( get_the_ID() ),
				'orderby'        => 'date',
				'no_found_rows'  => true,
			) );
			if ( $more->have_posts() ) :
				?>
				<div>
					<p class="fd-eyebrow mb-4"><?php esc_html_e( 'Más casos de éxito', 'flowdesk' ); ?></p>
					<div class="space-y-4">
						<?php while ( $more->have_posts() ) : $more->the_post(); ?>
							<a href="<?php the_permalink(); ?>" class="block no-underline group">
								<div class="fd-card flex gap-3 p-2 group-hover:border-violet/60 transition-colors">
									<div class="w-20 h-16 shrink-0 overflow-hidden bg-panel/40 border border-panel/60 rounded-md">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'w-full h-full object-cover' ) ); ?>
										<?php else : ?>
											<img src="<?php echo esc_url( flowdesk_placeholder_image( get_the_ID() ) ); ?>" alt="" loading="lazy" class="w-full h-full object-cover" />
										<?php endif; ?>
									</div>
									<span class="flex items-center">
										<span class="text-sm text-bone group-hover:text-violet leading-snug font-heading"><?php the_title(); ?></span>
									</span>
								</div>
							</a>
						<?php endwhile; ?>
					</div>
				</div>
				<?php
				wp_reset_postdata();
			endif;
			?>
		</aside>
	</div>
	<?php
endwhile;
get_footer();
