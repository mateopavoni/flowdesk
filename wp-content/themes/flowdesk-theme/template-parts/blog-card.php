<?php
/**
 * Card de post para el grid del blog: se presenta como una entrada de cola
 * (LOG-0042, LED de estado) en vez de una card de blog genérica. Imagen
 * destacada, excerpt, fecha, autor, categoría y tiempo de lectura.
 */
$category = get_the_category();
$log_id   = 'LOG-' . str_pad( get_the_ID(), 4, '0', STR_PAD_LEFT );
?>
<article class="fd-panel group overflow-hidden hover:border-amber/60 transition-colors">
	<a href="<?php the_permalink(); ?>" class="block no-underline">
		<div class="aspect-[16/9] bg-anthracite overflow-hidden border-b border-metal">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition-all', 'loading' => 'lazy', 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
			<?php else : ?>
				<div class="w-full h-full flowdesk-gradient"></div>
			<?php endif; ?>
		</div>
		<div class="p-5">
			<div class="flex items-center justify-between">
				<span class="font-sans text-[10px] text-slate-500 tracking-widest"><?php echo esc_html( $log_id ); ?></span>
				<span class="fd-led is-on" aria-hidden="true"></span>
			</div>
			<?php if ( ! empty( $category ) ) : ?>
				<span class="mt-2 inline-block text-xs font-heading text-amber uppercase tracking-wide">
					<?php echo esc_html( $category[0]->name ); ?>
				</span>
			<?php endif; ?>
			<h2 class="mt-2 text-lg leading-snug text-slate-900"><?php the_title(); ?></h2>
			<p class="mt-2 font-sans text-sm text-slate-600"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
			<div class="mt-4 flex items-center gap-3 font-sans text-xs text-slate-500">
				<span><?php echo esc_html( get_the_date() ); ?></span>
				<span aria-hidden="true">&middot;</span>
				<span><?php echo esc_html( get_the_author() ); ?></span>
				<span aria-hidden="true">&middot;</span>
				<span><?php echo esc_html( sprintf( _n( '%d min de lectura', '%d min de lectura', flowdesk_reading_time(), 'flowdesk' ), flowdesk_reading_time() ) ); ?></span>
			</div>
		</div>
	</a>
</article>
