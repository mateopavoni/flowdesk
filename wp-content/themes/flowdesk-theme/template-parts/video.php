<?php
/**
 * Video demo — facade lazy: no carga el iframe de YouTube hasta el click
 * (evita el peso de youtube-nocookie en cada visita al home).
 */
$youtube_id = apply_filters( 'flowdesk_demo_video_id', 'dQw4w9WgXcQ' );
?>
<section id="video" class="container-fd py-20">
	<div class="text-center max-w-2xl mx-auto mb-10">
		<p class="fd-nameplate mx-auto"><?php esc_html_e( 'Playback module', 'flowdesk' ); ?></p>
		<h2 class="mt-4 text-2xl sm:text-3xl"><?php esc_html_e( 'Dos minutos y ya sabés si es para vos', 'flowdesk' ); ?></h2>
	</div>
	<div class="fd-panel p-3 max-w-3xl mx-auto">
		<div
			class="relative aspect-video overflow-hidden bg-anthracite cursor-pointer group"
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
				class="w-full h-full object-cover opacity-70 group-hover:opacity-50 transition-opacity"
			/>
			<span class="absolute inset-0 flex items-center justify-center">
				<span class="w-16 h-16 border-2 border-amber bg-anthracite/90 flex items-center justify-center" style="clip-path: polygon(8px 0, 100% 0, 100% calc(100% - 8px), calc(100% - 8px) 100%, 0 100%, 0 8px);">
					<svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor" class="text-amber ml-1" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
				</span>
			</span>
		</div>
	</div>
</section>
