<?php
/**
 * 404 — mensaje claro + búsqueda + vuelta al home.
 */
get_header();
?>
<div class="container-fd py-24 max-w-xl mx-auto">
	<div class="fd-card text-center p-10">
		<p class="fd-eyebrow"><?php esc_html_e( 'Error 404', 'flowdesk' ); ?></p>
		<h1 class="mt-4 text-2xl sm:text-3xl"><?php esc_html_e( 'Esta página no existe', 'flowdesk' ); ?></h1>
		<p class="mt-3 text-sm text-ink-400">
			<?php esc_html_e( 'Puede que el link esté roto o la página se haya movido.', 'flowdesk' ); ?>
		</p>
		<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="mt-8 flex gap-2 justify-center">
			<label for="fd-404-search" class="sr-only"><?php esc_html_e( 'Buscar', 'flowdesk' ); ?></label>
			<input type="search" id="fd-404-search" name="s" placeholder="<?php esc_attr_e( 'Buscar…', 'flowdesk' ); ?>" class="bg-white border border-line rounded-lg px-3 py-2 text-sm text-ink-900 placeholder:text-ink-400" />
			<button type="submit" class="btn-primary text-sm !px-4 !py-2"><?php esc_html_e( 'Buscar', 'flowdesk' ); ?></button>
		</form>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-block mt-6 text-sm text-brand-700 hover:text-brand-900">
			<?php esc_html_e( '← Volver al inicio', 'flowdesk' ); ?>
		</a>
	</div>
</div>
<?php get_footer(); ?>
