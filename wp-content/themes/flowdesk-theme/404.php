<?php
/**
 * 404 — mensaje claro + búsqueda + vuelta al home. Nada de "genérico WordPress".
 */
get_header();
?>
<div class="container-fd py-24 max-w-xl mx-auto">
	<div class="fd-panel text-center p-10">
		<div class="fd-hazard-edge -mx-10 -mt-10 mb-6"></div>
		<span class="fd-led is-alert mx-auto"></span>
		<p class="mt-4 fd-nameplate">ERR.404 — <?php esc_html_e( 'SIGNAL LOST', 'flowdesk' ); ?></p>
		<h1 class="mt-4 text-2xl sm:text-3xl"><?php esc_html_e( 'Esta página no existe', 'flowdesk' ); ?></h1>
		<p class="mt-3 font-sans text-sm text-slate-600">
			<?php esc_html_e( 'Puede que el link esté roto o la página se haya movido.', 'flowdesk' ); ?>
		</p>
		<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="mt-8 flex gap-2 justify-center">
			<label for="fd-404-search" class="sr-only"><?php esc_html_e( 'Buscar', 'flowdesk' ); ?></label>
			<input type="search" id="fd-404-search" name="s" placeholder="<?php esc_attr_e( 'Query…', 'flowdesk' ); ?>" class="bg-anthracite border border-metal px-3 py-2 text-sm font-sans text-slate-800 placeholder:text-slate-500" />
			<button type="submit" class="btn-primary text-sm !px-4 !py-2"><?php esc_html_e( 'Buscar', 'flowdesk' ); ?></button>
		</form>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-block mt-6 font-sans text-sm text-blue-700 hover:text-blue-900">
			<?php esc_html_e( '← Volver al inicio', 'flowdesk' ); ?>
		</a>
	</div>
</div>
<?php get_footer(); ?>
