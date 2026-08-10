<?php
/**
 * Grid de posts reusado por home.php (índice del blog), archive.php
 * (categorías) y search.php. Usa el loop principal (have_posts/the_post).
 */
?>
<?php if ( have_posts() ) : ?>
	<div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/blog-card' ); ?>
		<?php endwhile; ?>
	</div>
	<div class="mt-12">
		<?php
		the_posts_pagination( array(
			'mid_size'  => 1,
			'prev_text' => __( 'Anterior', 'flowdesk' ),
			'next_text' => __( 'Siguiente', 'flowdesk' ),
		) );
		?>
	</div>
<?php else : ?>
	<div class="fd-panel text-center py-16 px-6">
		<p class="font-sans text-sm text-amber">&gt; <?php esc_html_e( 'query returned 0 results', 'flowdesk' ); ?></p>
		<p class="mt-2 text-base text-slate-600 font-sans">
			<?php esc_html_e( 'No encontramos posts para esta búsqueda.', 'flowdesk' ); ?>
		</p>
		<a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="btn-primary mt-6">
			<?php esc_html_e( 'Ver todo el blog', 'flowdesk' ); ?>
		</a>
	</div>
<?php endif; ?>
