<?php
/**
 * 404 — mensaje claro + búsqueda + vuelta al home. Nada de "genérico WordPress".
 */
get_header();
?>
<div class="container-fd py-24 text-center max-w-xl mx-auto">
	<p class="text-sm font-heading font-semibold text-blue-700 uppercase tracking-wide">404</p>
	<h1 class="mt-3 text-3xl"><?php esc_html_e( 'Esta página no existe', 'flowdesk' ); ?></h1>
	<p class="mt-3 text-slate-600">
		<?php esc_html_e( 'Puede que el link esté roto o la página se haya movido.', 'flowdesk' ); ?>
	</p>
	<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="mt-8 flex gap-2 justify-center">
		<label for="fd-404-search" class="sr-only"><?php esc_html_e( 'Buscar', 'flowdesk' ); ?></label>
		<input type="search" id="fd-404-search" name="s" placeholder="<?php esc_attr_e( 'Buscar…', 'flowdesk' ); ?>" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" />
		<button type="submit" class="btn bg-blue-900 text-white hover:bg-blue-800 text-sm"><?php esc_html_e( 'Buscar', 'flowdesk' ); ?></button>
	</form>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-block mt-6 text-sm text-blue-700 hover:text-blue-900">
		<?php esc_html_e( '← Volver al inicio', 'flowdesk' ); ?>
	</a>
</div>
<?php get_footer(); ?>
