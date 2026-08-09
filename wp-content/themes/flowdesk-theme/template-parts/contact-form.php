<?php
/**
 * Formulario de contacto. Envía a admin-post.php (action=flowdesk_contact),
 * manejado por el plugin (nonce + honeypot + sanitización).
 */
?>
<div class="mt-12 rounded-xl border border-slate-100 p-6 sm:p-8">
	<h2 class="text-2xl mb-6"><?php esc_html_e( 'Escribinos', 'flowdesk' ); ?></h2>
	<form id="fd-contact-form" novalidate>
		<input type="hidden" name="action" value="flowdesk_contact" />
		<?php wp_nonce_field( 'flowdesk_contact', 'fd_contact_nonce' ); ?>
		<input type="text" name="company_website" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true" />

		<div class="grid gap-4 sm:grid-cols-2">
			<div>
				<label for="fd-contact-name" class="block text-sm font-medium mb-1"><?php esc_html_e( 'Nombre', 'flowdesk' ); ?></label>
				<input type="text" id="fd-contact-name" name="name" required class="w-full rounded-lg border border-slate-300 px-3 py-2" />
			</div>
			<div>
				<label for="fd-contact-email" class="block text-sm font-medium mb-1"><?php esc_html_e( 'Email', 'flowdesk' ); ?></label>
				<input type="email" id="fd-contact-email" name="email" required class="w-full rounded-lg border border-slate-300 px-3 py-2" />
			</div>
		</div>

		<div class="mt-4">
			<label for="fd-contact-message" class="block text-sm font-medium mb-1"><?php esc_html_e( 'Mensaje', 'flowdesk' ); ?></label>
			<textarea id="fd-contact-message" name="message" rows="5" required class="w-full rounded-lg border border-slate-300 px-3 py-2"></textarea>
		</div>

		<button type="submit" class="btn bg-blue-900 text-white hover:bg-blue-800 mt-6">
			<?php esc_html_e( 'Enviar mensaje', 'flowdesk' ); ?>
		</button>
		<p id="fd-contact-status" class="text-sm mt-3" role="status" aria-live="polite"></p>
	</form>
</div>
