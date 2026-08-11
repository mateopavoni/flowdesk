<?php
/**
 * Video demo — facade lazy: no carga el iframe de YouTube hasta el click
 * (evita el peso de youtube-nocookie en cada visita al home).
 */
$youtube_id = apply_filters( 'flowdesk_demo_video_id', 'dQw4w9WgXcQ' );
?>
<section id="video" class="container-fd py-20">
	<div class="text-center max-w-2xl mx-auto mb-10 fd-reveal">
		<p class="fd-eyebrow mx-auto"><?php esc_html_e( 'Demo', 'flowdesk' ); ?></p>
		<h2 class="mt-4 text-2xl sm:text-3xl"><?php esc_html_e( 'Dos minutos y ya sabés si es para vos', 'flowdesk' ); ?></h2>
	</div>
	<div class="fd-card p-3 max-w-3xl mx-auto fd-reveal">
		<div
			class="relative aspect-video overflow-hidden bg-paper-100 rounded-lg cursor-pointer group"
			data-fd-video-facade
			data-video-id="<?php echo esc_attr( $youtube_id ); ?>"
			role="button"
			tabindex="0"
			aria-label="<?php esc_attr_e( 'Reproducir video demo', 'flowdesk' ); ?>"
		>
			<img
				src="https://i.ytimg.com/vi/<?php echo esc_attr( $youtube_id ); ?>/hqdefault.jpg"
				alt="<?php esc_attr_e( 'Miniatura del video demo de FlowDesk', 'flowdesk' ); ?>"
				loading="lazy"
				class="w-full h-full object-cover group-hover:opacity-90 transition-opacity"
			/>
			<span class="absolute inset-0 flex items-center justify-center">
				<span class="w-16 h-16 rounded-full bg-brand-700 group-hover:bg-brand-900 flex items-center justify-center transition-colors">
					<?php echo flowdesk_icon( 'play', 'w-[26px] h-[26px] text-white ml-1' ); ?>
				</span>
			</span>
		</div>
	</div>
</section>
