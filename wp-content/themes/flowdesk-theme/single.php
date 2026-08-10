<?php
/**
 * Post individual: contenido + sidebar de relacionados + comentarios nativos de WP.
 * Se presenta como el panel de diagnóstico de un instrumento específico.
 */
get_header();
while ( have_posts() ) :
	the_post();
	$category = get_the_category();
	?>
	<div class="container-fd py-16 grid gap-12 lg:grid-cols-[1fr_320px]">
		<article <?php post_class( 'min-w-0 fd-panel p-6 sm:p-10' ); ?>>
			<div class="flex items-center justify-between font-sans text-[10px] text-slate-500 tracking-widest mb-4">
				<span>INSTRUMENT: DIAGNOSTIC</span>
				<span class="flex items-center gap-1.5"><span class="fd-led is-on"></span>STATUS</span>
			</div>

			<?php if ( ! empty( $category ) ) : ?>
				<a href="<?php echo esc_url( get_category_link( $category[0] ) ); ?>" class="text-xs font-heading text-amber uppercase tracking-wide no-underline">
					<?php echo esc_html( $category[0]->name ); ?>
				</a>
			<?php endif; ?>

			<h1 class="mt-2 text-2xl sm:text-4xl"><?php the_title(); ?></h1>

			<div class="mt-3 flex items-center gap-3 font-sans text-xs text-slate-500">
				<span><?php the_author(); ?></span>
				<span aria-hidden="true">&middot;</span>
				<span><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
				<span aria-hidden="true">&middot;</span>
				<span><?php echo esc_html( sprintf( _n( '%d min de lectura', '%d min de lectura', flowdesk_reading_time(), 'flowdesk' ), flowdesk_reading_time() ) ); ?></span>
			</div>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="mt-8 aspect-[16/9] overflow-hidden bg-anthracite border border-metal">
					<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
				</div>
			<?php endif; ?>

			<div class="prose max-w-none mt-8 font-sans">
				<?php the_content(); ?>
			</div>

			<?php
			wp_link_pages( array(
				'before' => '<nav class="mt-8 flex gap-2 font-sans text-sm">',
				'after'  => '</nav>',
			) );
			?>

			<div class="mt-16 pt-8 border-t border-metal">
				<?php comments_template(); ?>
			</div>
		</article>

		<aside class="lg:pt-1">
			<p class="fd-nameplate mb-4"><?php esc_html_e( 'Dependent units', 'flowdesk' ); ?></p>
			<?php
			$related = flowdesk_related_posts();
			if ( $related->have_posts() ) :
				?>
				<div class="space-y-5">
					<?php while ( $related->have_posts() ) : $related->the_post(); ?>
						<a href="<?php the_permalink(); ?>" class="fd-patchline block no-underline group">
							<div class="fd-panel flex gap-3 p-2 group-hover:border-amber/60 transition-colors">
								<div class="w-20 h-16 shrink-0 overflow-hidden bg-anthracite border border-metal">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'w-full h-full object-cover' ) ); ?>
									<?php endif; ?>
								</div>
								<span class="flex flex-col justify-center">
									<span class="font-sans text-[10px] text-slate-500 tracking-widest">LOG-<?php echo esc_html( str_pad( get_the_ID(), 4, '0', STR_PAD_LEFT ) ); ?></span>
									<span class="text-sm text-slate-800 group-hover:text-amber leading-snug normal-case font-heading"><?php the_title(); ?></span>
								</span>
							</div>
						</a>
					<?php endwhile; ?>
				</div>
				<?php
				wp_reset_postdata();
			else :
				?>
				<p class="font-sans text-sm text-slate-500"><?php esc_html_e( 'Todavía no hay más posts en esta categoría.', 'flowdesk' ); ?></p>
			<?php endif; ?>
		</aside>
	</div>
	<?php
endwhile;
get_footer();
