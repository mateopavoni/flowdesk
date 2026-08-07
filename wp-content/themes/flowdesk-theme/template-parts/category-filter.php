<?php
/**
 * Pills de categorías (link directo a /category/slug/ — el filtro es
 * navegación nativa, no hace falta AJAX/JS para esto).
 */
$categories = get_categories( array( 'hide_empty' => true ) );
if ( empty( $categories ) ) {
	return;
}
?>
<nav class="flex flex-wrap gap-2" aria-label="<?php esc_attr_e( 'Filtrar por categoría', 'flowdesk' ); ?>">
	<a
		href="<?php echo esc_url( home_url( '/blog' ) ); ?>"
		class="px-3 py-1.5 rounded-full text-sm border <?php echo ! is_category() ? 'bg-blue-900 text-white border-blue-900' : 'border-slate-300 text-slate-700 hover:border-blue-900'; ?>"
	>
		<?php esc_html_e( 'Todas', 'flowdesk' ); ?>
	</a>
	<?php foreach ( $categories as $cat ) : ?>
		<a
			href="<?php echo esc_url( get_category_link( $cat ) ); ?>"
			class="px-3 py-1.5 rounded-full text-sm border <?php echo is_category( $cat->term_id ) ? 'bg-blue-900 text-white border-blue-900' : 'border-slate-300 text-slate-700 hover:border-blue-900'; ?>"
		>
			<?php echo esc_html( $cat->name ); ?>
		</a>
	<?php endforeach; ?>
</nav>
