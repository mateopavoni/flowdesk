<?php
/**
 * Card de post para el grid del blog: imagen destacada, excerpt, fecha,
 * autor, categoría y tiempo de lectura.
 */
$category = get_the_category();
?>
<article class="fd-card group overflow-hidden hover:border-brand-500 transition-colors fd-reveal">
	<a href="<?php the_permalink(); ?>" class="block no-underline">
		<div class="aspect-[16/9] bg-paper-100 overflow-hidden border-b border-line">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform', 'loading' => 'lazy', 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
			<?php else : ?>
				<div class="w-full h-full flowdesk-gradient"></div>
			<?php endif; ?>
		</div>
		<div class="p-5">
			<?php if ( ! empty( $category ) ) : ?>
				<span class="inline-block text-xs font-heading text-brand-700 uppercase tracking-wide">
					<?php echo esc_html( $category[0]->name ); ?>
				</span>
			<?php endif; ?>
			<h2 class="mt-2 text-lg leading-snug text-ink-900"><?php the_title(); ?></h2>
			<p class="mt-2 text-sm text-ink-600"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
			<div class="mt-4 flex items-center gap-3 text-xs text-ink-400">
				<span><?php echo esc_html( get_the_date() ); ?></span>
				<span aria-hidden="true">&middot;</span>
				<span><?php echo esc_html( get_the_author() ); ?></span>
				<span aria-hidden="true">&middot;</span>
				<span><?php echo esc_html( sprintf( _n( '%d min de lectura', '%d min de lectura', flowdesk_reading_time(), 'flowdesk' ), flowdesk_reading_time() ) ); ?></span>
			</div>
		</div>
	</a>
</article>
