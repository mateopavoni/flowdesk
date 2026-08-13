<?php
/**
 * Card de post para el grid del blog: imagen destacada, excerpt, fecha,
 * autor, categoría y tiempo de lectura.
 */
$category = get_the_category();
?>
<article class="fd-card group overflow-hidden hover:border-violet/60 transition-colors fd-reveal">
	<a href="<?php the_permalink(); ?>" class="block no-underline">
		<div class="aspect-[16/9] bg-panel/40 overflow-hidden border-b border-panel/60">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform', 'loading' => 'lazy', 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
			<?php else : ?>
				<div class="relative w-full h-full">
					<img src="<?php echo esc_url( flowdesk_placeholder_image( get_the_ID() ) ); ?>" alt="" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform" />
					<div class="absolute inset-0 bg-gradient-to-br from-void/70 via-violet/40 to-amber/10 mix-blend-multiply"></div>
				</div>
			<?php endif; ?>
		</div>
		<div class="p-5">
			<?php if ( ! empty( $category ) ) : ?>
				<span class="inline-block text-xs font-heading text-violet uppercase tracking-wide">
					<?php echo esc_html( $category[0]->name ); ?>
				</span>
			<?php endif; ?>
			<h2 class="mt-2 text-lg leading-snug text-bone"><?php the_title(); ?></h2>
			<p class="mt-2 text-sm text-haze"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
			<div class="mt-4 flex items-center gap-3 text-xs text-haze">
				<span><?php echo esc_html( get_the_date() ); ?></span>
				<span aria-hidden="true">&middot;</span>
				<span><?php echo esc_html( get_the_author() ); ?></span>
				<span aria-hidden="true">&middot;</span>
				<span><?php echo esc_html( sprintf( _n( '%d min de lectura', '%d min de lectura', flowdesk_reading_time(), 'flowdesk' ), flowdesk_reading_time() ) ); ?></span>
			</div>
		</div>
	</a>
</article>
