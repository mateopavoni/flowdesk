<?php
/**
 * Video demo — facade lazy: no carga el iframe de YouTube hasta el click
 * (evita el peso de youtube-nocookie en cada visita al home).
 */
$youtube_id = apply_filters( 'flowdesk_demo_video_id', 'dQw4w9WgXcQ' );
?>
<section id="video" class="container-fd py-20">
	<div class="text-center max-w-2xl mx-auto mb-10">
		<h2 class="text-3xl"><?php esc_html_e( 'Dos minutos y ya sabés si es para vos', 'flowdesk' ); ?></h2>
	</div>
	<div
		class="relative max-w-3xl mx-auto aspect-video rounded-xl overflow-hidden bg-slate-900 cursor-pointer group"
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
			class="w-full h-full object-cover opacity-80 group-hover:opacity-60 transition-opacity"
		/>
		<span class="absolute inset-0 flex items-center justify-center">
			<span class="w-16 h-16 rounded-full bg-white/90 flex items-center justify-center">
				<svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor" class="text-blue-900 ml-1" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
			</span>
		</span>
	</div>
</section>
