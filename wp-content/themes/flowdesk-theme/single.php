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
		<article <?php post_class( 'min-w-0' ); ?>>
			<?php if ( ! empty( $category ) ) : ?>
				<a href="<?php echo esc_url( get_category_link( $category[0] ) ); ?>" class="text-xs font-heading font-semibold text-blue-700 uppercase tracking-wide no-underline">
					<?php echo esc_html( $category[0]->name ); ?>
				</a>
			<?php endif; ?>

			<h1 class="mt-2 text-3xl sm:text-4xl"><?php the_title(); ?></h1>

			<div class="mt-3 flex items-center gap-3 text-sm text-slate-500">
				<span><?php the_author(); ?></span>
				<span aria-hidden="true">&middot;</span>
				<span><?php echo esc_html( get_the_date() ); ?></span>
				<span aria-hidden="true">&middot;</span>
				<span><?php echo esc_html( sprintf( _n( '%d min de lectura', '%d min de lectura', flowdesk_reading_time(), 'flowdesk' ), flowdesk_reading_time() ) ); ?></span>
			</div>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="mt-8 aspect-[16/9] rounded-xl overflow-hidden bg-slate-100">
					<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
				</div>
			<?php endif; ?>

			<div class="prose max-w-none mt-8">
				<?php the_content(); ?>
			</div>

			<?php
			wp_link_pages( array(
				'before' => '<nav class="mt-8 flex gap-2">',
				'after'  => '</nav>',
			) );
			?>

			<div class="mt-16">
				<?php comments_template(); ?>
			</div>
		</article>

		<aside class="lg:pt-1">
			<h2 class="text-lg font-heading font-semibold mb-4"><?php esc_html_e( 'Relacionados', 'flowdesk' ); ?></h2>
			<?php
			$related = flowdesk_related_posts();
			if ( $related->have_posts() ) :
				?>
				<div class="space-y-6">
					<?php while ( $related->have_posts() ) : $related->the_post(); ?>
						<a href="<?php the_permalink(); ?>" class="flex gap-3 no-underline group">
							<div class="w-20 h-16 shrink-0 rounded-lg overflow-hidden bg-slate-100">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'w-full h-full object-cover' ) ); ?>
								<?php endif; ?>
							</div>
							<span class="text-sm text-slate-800 group-hover:text-blue-800 leading-snug"><?php the_title(); ?></span>
						</a>
					<?php endwhile; ?>
				</div>
				<?php
				wp_reset_postdata();
			else :
				?>
				<p class="text-sm text-slate-500"><?php esc_html_e( 'Todavía no hay más posts en esta categoría.', 'flowdesk' ); ?></p>
			<?php endif; ?>
		</aside>
	</div>
	<?php
endwhile;
get_footer();
