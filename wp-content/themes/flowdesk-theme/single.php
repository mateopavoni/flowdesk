<?php
/**
 * Post individual: contenido + sidebar de relacionados + comentarios nativos de WP.
 */
get_header();
while ( have_posts() ) :
	the_post();
	$category = get_the_category();
	?>
	<div class="container-fd py-16 grid gap-12 lg:grid-cols-[1fr_320px]">
		<article <?php post_class( 'min-w-0 fd-card p-6 sm:p-10' ); ?>>
			<?php if ( ! empty( $category ) ) : ?>
				<a href="<?php echo esc_url( get_category_link( $category[0] ) ); ?>" class="text-xs font-heading text-brand-700 uppercase tracking-wide no-underline">
					<?php echo esc_html( $category[0]->name ); ?>
				</a>
			<?php endif; ?>

			<h1 class="mt-2 text-2xl sm:text-4xl"><?php the_title(); ?></h1>

			<div class="mt-3 flex items-center gap-3 text-xs text-ink-400">
				<span><?php the_author(); ?></span>
				<span aria-hidden="true">&middot;</span>
				<span><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
				<span aria-hidden="true">&middot;</span>
				<span><?php echo esc_html( sprintf( _n( '%d min de lectura', '%d min de lectura', flowdesk_reading_time(), 'flowdesk' ), flowdesk_reading_time() ) ); ?></span>
			</div>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="mt-8 aspect-[16/9] overflow-hidden bg-paper-100 border border-line rounded-lg">
					<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
				</div>
			<?php endif; ?>

			<div class="prose max-w-none mt-8">
				<?php the_content(); ?>
			</div>

			<?php
			wp_link_pages( array(
				'before' => '<nav class="mt-8 flex gap-2 text-sm">',
				'after'  => '</nav>',
			) );
			?>

			<div class="mt-16 pt-8 border-t border-line">
				<?php comments_template(); ?>
			</div>
		</article>

		<aside class="lg:pt-1">
			<p class="fd-eyebrow mb-4"><?php esc_html_e( 'Relacionados', 'flowdesk' ); ?></p>
			<?php
			$related = flowdesk_related_posts();
			if ( $related->have_posts() ) :
				?>
				<div class="space-y-4">
					<?php while ( $related->have_posts() ) : $related->the_post(); ?>
						<a href="<?php the_permalink(); ?>" class="block no-underline group">
							<div class="fd-card flex gap-3 p-2 group-hover:border-brand-500 transition-colors">
								<div class="w-20 h-16 shrink-0 overflow-hidden bg-paper-100 border border-line rounded-md">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'w-full h-full object-cover' ) ); ?>
									<?php endif; ?>
								</div>
								<span class="flex items-center">
									<span class="text-sm text-ink-900 group-hover:text-brand-700 leading-snug font-heading"><?php the_title(); ?></span>
								</span>
							</div>
						</a>
					<?php endwhile; ?>
				</div>
				<?php
				wp_reset_postdata();
			else :
				?>
				<p class="text-sm text-ink-400"><?php esc_html_e( 'Todavía no hay más posts en esta categoría.', 'flowdesk' ); ?></p>
			<?php endif; ?>
		</aside>
	</div>
	<?php
endwhile;
get_footer();
