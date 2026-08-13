<?php
/**
 * Comentarios nativos de WordPress — sin plugin de terceros (Disqus, etc.).
 */
if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<p class="fd-eyebrow mb-4">
			<?php
			printf(
				/* translators: %d: cantidad de comentarios */
				esc_html( _n( '%d comentario', '%d comentarios', get_comments_number(), 'flowdesk' ) ),
				(int) get_comments_number()
			);
			?>
		</p>
		<ol class="space-y-6 text-sm">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
			) );
			?>
		</ol>
		<?php the_comments_pagination(); ?>
	<?php endif; ?>

	<?php if ( comments_open() ) : ?>
		<?php
		comment_form( array(
			'class_submit'      => 'btn-primary',
			'title_reply'       => __( 'Dejá tu comentario', 'flowdesk' ),
			// Default de WP es <h3>. Forzado a <h2> porque, sin comentarios
			// todavía, este es el próximo heading después del <h1> del post
			// — un <h3> ahí salta un nivel (violación real de heading-order
			// detectada con axe-core).
			'title_reply_before' => '<h2 id="reply-title" class="text-lg mb-6">',
			'title_reply_after'  => '</h2>',
			'comment_field'      => '<p class="comment-form-comment"><label for="comment" class="sr-only">' . __( 'Comentario', 'flowdesk' ) . '</label><textarea id="comment" name="comment" rows="6" required class="w-full bg-panel/40 border border-panel/60 rounded-lg px-3 py-2 text-sm text-bone"></textarea></p>',
		) );
		?>
	<?php else : ?>
		<p class="font-sans text-sm text-slate-500"><?php esc_html_e( 'Los comentarios están cerrados para este post.', 'flowdesk' ); ?></p>
	<?php endif; ?>
</div>
