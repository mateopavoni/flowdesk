<?php
/**
 * Filtro de categorías (link directo a /category/slug/ — el filtro es
 * navegación nativa, no hace falta AJAX/JS para esto). Estilo: selector de
 * canal/módulo, no "pills" redondeadas genéricas.
 */
$categories = get_categories( array( 'hide_empty' => true ) );
if ( empty( $categories ) ) {
	return;
}
?>
<nav class="flex flex-wrap gap-1.5 font-sans text-xs" aria-label="<?php esc_attr_e( 'Filtrar por categoría', 'flowdesk' ); ?>">
	<a
		href="<?php echo esc_url( home_url( '/blog' ) ); ?>"
		class="px-3 py-1.5 border uppercase tracking-wide <?php echo ! is_category() ? 'bg-amber text-anthracite border-amber' : 'border-metal text-slate-600 hover:border-amber hover:text-amber'; ?>"
	>
		<?php esc_html_e( 'Todas', 'flowdesk' ); ?>
	</a>
	<?php foreach ( $categories as $cat ) : ?>
		<a
			href="<?php echo esc_url( get_category_link( $cat ) ); ?>"
			class="px-3 py-1.5 border uppercase tracking-wide <?php echo is_category( $cat->term_id ) ? 'bg-amber text-anthracite border-amber' : 'border-metal text-slate-600 hover:border-amber hover:text-amber'; ?>"
		>
			<?php echo esc_html( $cat->name ); ?>
		</a>
	<?php endforeach; ?>
</nav>
