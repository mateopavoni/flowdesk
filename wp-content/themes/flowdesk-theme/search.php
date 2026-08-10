<?php
/**
 * Resultados de búsqueda — mismo grid que el blog.
 */
get_header();
?>
<div class="container-fd py-16">
	<p class="fd-eyebrow"><?php esc_html_e( 'Búsqueda', 'flowdesk' ); ?></p>
	<h1 class="mt-4 text-2xl sm:text-3xl mb-10">
		<?php
		printf(
			/* translators: %s: término buscado */
			esc_html__( 'Resultados para "%s"', 'flowdesk' ),
			'<span class="text-brand-700">' . esc_html( get_search_query() ) . '</span>'
		);
		?>
	</h1>
	<?php get_template_part( 'template-parts/blog-grid' ); ?>
</div>
<?php get_footer(); ?>
