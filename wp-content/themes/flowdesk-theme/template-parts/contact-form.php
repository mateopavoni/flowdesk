<?php
/**
 * Formulario de contacto. Envía a admin-post.php (action=flowdesk_contact),
 * manejado por el plugin (nonce + honeypot + sanitización). Presentado como
 * panel "TRANSMIT MESSAGE".
 */
?>
<div class="mt-12 fd-panel p-6 sm:p-8">
	<p class="fd-nameplate mb-4"><?php esc_html_e( 'Uplink // Transmit message', 'flowdesk' ); ?></p>
	<h2 class="text-xl sm:text-2xl mb-6"><?php esc_html_e( 'Escribinos', 'flowdesk' ); ?></h2>
	<form id="fd-contact-form" class="font-sans" novalidate>
		<input type="hidden" name="action" value="flowdesk_contact" />
		<?php wp_nonce_field( 'flowdesk_contact', 'fd_contact_nonce' ); ?>
		<input type="text" name="company_website" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true" />

		<div class="grid gap-4 sm:grid-cols-2">
			<div>
				<label for="fd-contact-name" class="block text-xs uppercase tracking-wide text-slate-500 mb-1"><?php esc_html_e( 'Nombre', 'flowdesk' ); ?></label>
				<input type="text" id="fd-contact-name" name="name" required class="w-full bg-anthracite border border-metal px-3 py-2 text-sm text-slate-800" />
			</div>
			<div>
				<label for="fd-contact-email" class="block text-xs uppercase tracking-wide text-slate-500 mb-1"><?php esc_html_e( 'Email', 'flowdesk' ); ?></label>
				<input type="email" id="fd-contact-email" name="email" required class="w-full bg-anthracite border border-metal px-3 py-2 text-sm text-slate-800" />
			</div>
		</div>

		<div class="mt-4">
			<label for="fd-contact-message" class="block text-xs uppercase tracking-wide text-slate-500 mb-1"><?php esc_html_e( 'Mensaje', 'flowdesk' ); ?></label>
			<textarea id="fd-contact-message" name="message" rows="5" required class="w-full bg-anthracite border border-metal px-3 py-2 text-sm text-slate-800"></textarea>
		</div>

		<button type="submit" class="btn-primary mt-6">
			<?php esc_html_e( 'Enviar mensaje', 'flowdesk' ); ?>
		</button>
		<p id="fd-contact-status" class="text-sm mt-3" role="status" aria-live="polite"></p>
	</form>
</div>
