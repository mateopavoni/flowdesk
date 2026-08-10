<?php
/**
 * Sección de newsletter en el home. Mismo endpoint REST, mismo JS
 * (.fd-newsletter-form) que la variante del footer.
 */
?>
<section class="container-fd py-20">
	<div class="fd-card p-8 sm:p-12 text-center max-w-2xl mx-auto">
		<p class="fd-eyebrow mx-auto"><?php esc_html_e( 'Newsletter', 'flowdesk' ); ?></p>
		<h2 class="mt-4 text-xl sm:text-2xl"><?php esc_html_e( 'Un tip de productividad por mes', 'flowdesk' ); ?></h2>
		<p class="mt-3 text-sm text-ink-400"><?php esc_html_e( 'Sin spam, sin vueltas. Cancelás cuando quieras.', 'flowdesk' ); ?></p>

		<form class="fd-newsletter-form mt-6 flex flex-col sm:flex-row gap-2 max-w-md mx-auto">
			<label for="fd-newsletter-email-home" class="sr-only"><?php esc_html_e( 'Tu email', 'flowdesk' ); ?></label>
			<input
				type="email"
				id="fd-newsletter-email-home"
				name="email"
				required
				placeholder="<?php esc_attr_e( 'tu@email.com', 'flowdesk' ); ?>"
				class="min-w-0 flex-1 border border-line rounded-lg px-4 py-3 text-sm text-ink-900 placeholder:text-ink-400"
			/>
			<input type="text" name="company_website" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true" />
			<?php wp_nonce_field( 'flowdesk_newsletter', 'fd_newsletter_nonce' ); ?>
			<button type="submit" class="btn-primary">
				<?php esc_html_e( 'Suscribirme', 'flowdesk' ); ?>
			</button>
		</form>
		<p class="fd-newsletter-status text-sm mt-3" role="status" aria-live="polite"></p>
	</div>
</section>
