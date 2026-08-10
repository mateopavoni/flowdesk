<?php
/**
 * Índice del blog (la "Posts page" configurada en Ajustes > Lectura).
 * Grid 3 columnas desktop / 1 mobile, búsqueda + filtro por categoría.
 */
get_header();
?>
<div class="container-fd py-16">
	<div class="text-center max-w-2xl mx-auto mb-10">
		<p class="fd-nameplate mx-auto"><?php esc_html_e( 'Sys log tape', 'flowdesk' ); ?></p>
		<h1 class="mt-4 text-3xl sm:text-4xl"><?php esc_html_e( 'Blog', 'flowdesk' ); ?></h1>
		<p class="mt-3 font-sans text-sm text-slate-600">
			<?php esc_html_e( 'Productividad, gestión de equipos y notas sobre cómo construimos FlowDesk.', 'flowdesk' ); ?>
		</p>
	</div>

	<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-10">
		<?php get_template_part( 'template-parts/category-filter' ); ?>
		<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex gap-2">
			<label for="fd-blog-search" class="sr-only"><?php esc_html_e( 'Buscar en el blog', 'flowdesk' ); ?></label>
			<input
				type="search"
				id="fd-blog-search"
				name="s"
				placeholder="<?php esc_attr_e( 'Query…', 'flowdesk' ); ?>"
				class="bg-panel border border-metal px-3 py-2 text-sm font-sans text-slate-800 placeholder:text-slate-500"
			/>
		</form>
	</div>

	<?php get_template_part( 'template-parts/blog-grid' ); ?>
</div>
<?php get_footer(); ?>
