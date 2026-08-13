<?php
/**
 * Filtro de categorías (link directo a /category/slug/ — el filtro es
 * navegación nativa, no hace falta AJAX/JS para esto).
 */
$categories = get_categories( array( 'hide_empty' => true ) );
if ( empty( $categories ) ) {
	return;
}
?>
<nav class="flex flex-wrap gap-1.5 text-xs fd-reveal" aria-label="<?php esc_attr_e( 'Filtrar por categoría', 'flowdesk' ); ?>">
	<a
		href="<?php echo esc_url( home_url( '/blog' ) ); ?>"
		class="px-3 py-1.5 rounded-full border uppercase tracking-wide <?php echo ! is_category() ? 'bg-violet text-white border-violet' : 'border-panel/60 text-haze hover:border-violet/60 hover:text-violet'; ?>"
	>
		<?php esc_html_e( 'Todas', 'flowdesk' ); ?>
	</a>
	<?php foreach ( $categories as $cat ) : ?>
		<a
			href="<?php echo esc_url( get_category_link( $cat ) ); ?>"
			class="px-3 py-1.5 rounded-full border uppercase tracking-wide <?php echo is_category( $cat->term_id ) ? 'bg-violet text-white border-violet' : 'border-panel/60 text-haze hover:border-violet/60 hover:text-violet'; ?>"
		>
			<?php echo esc_html( $cat->name ); ?>
		</a>
	<?php endforeach; ?>
</nav>
