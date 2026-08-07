<?php
/**
 * Fallback obligatorio de WordPress. En la práctica casi no se usa: el home
 * lo sirve front-page.php, el blog archive.php, los posts single.php.
 */
get_header();
?>
<div class="container-fd py-16">
	<?php if ( have_posts() ) : ?>
		<div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/blog-card' ); ?>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No se encontró contenido.', 'flowdesk' ); ?></p>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
