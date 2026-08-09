<?php
/**
 * Footer: newsletter signup + navegación + copyright.
 */
?>
</main>

<footer class="flowdesk-gradient text-slate-800 mt-24 border-t border-metal">
	<div class="container-fd py-16 grid gap-12 md:grid-cols-3">
		<div>
			<p class="fd-nameplate">SYS.STATUS <span class="fd-led is-on ml-1"></span> <?php esc_html_e( 'NOMINAL', 'flowdesk' ); ?></p>
			<p class="mt-4 font-heading text-lg tracking-wide"><?php bloginfo( 'name' ); ?></p>
			<p class="mt-3 text-slate-600 text-sm max-w-xs">
				<?php esc_html_e( 'Organizá el trabajo de tu equipo sin fricción. Menos reuniones, más entregas.', 'flowdesk' ); ?>
			</p>
		</div>

		<nav aria-label="<?php esc_attr_e( 'Navegación de footer', 'flowdesk' ); ?>">
			<p class="fd-nameplate mb-3"><?php esc_html_e( 'Módulo // Producto', 'flowdesk' ); ?></p>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'footer',
				'container'      => false,
				'menu_class'     => 'space-y-2 text-sm text-slate-600',
				'fallback_cb'    => false,
			) );
			?>
		</nav>

		<div>
			<p class="fd-nameplate mb-3"><?php esc_html_e( 'Uplink // Newsletter', 'flowdesk' ); ?></p>
			<p class="text-sm text-slate-600 mb-3">
				<?php esc_html_e( 'Un tip de productividad por mes. Sin spam.', 'flowdesk' ); ?>
			</p>
			<form class="fd-newsletter-form flex gap-2" novalidate>
				<label for="fd-newsletter-email-footer" class="sr-only"><?php esc_html_e( 'Tu email', 'flowdesk' ); ?></label>
				<input
					type="email"
					id="fd-newsletter-email-footer"
					name="email"
					required
					placeholder="<?php esc_attr_e( 'tu@email.com', 'flowdesk' ); ?>"
					class="min-w-0 flex-1 bg-anthracite border border-metal px-3 py-2 text-slate-800 text-sm placeholder:text-slate-500"
				/>
				<input type="text" name="company_website" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true" />
				<?php wp_nonce_field( 'flowdesk_newsletter', 'fd_newsletter_nonce' ); ?>
				<button type="submit" class="btn-primary text-sm !px-4 !py-2 whitespace-nowrap">
					<?php esc_html_e( 'Suscribirme', 'flowdesk' ); ?>
				</button>
			</form>
			<p class="fd-newsletter-status text-sm mt-2" role="status" aria-live="polite"></p>
		</div>
	</div>

	<div class="border-t border-metal">
		<div class="container-fd py-6 text-xs text-slate-600 flex flex-col sm:flex-row justify-between gap-2 font-sans">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'Todos los derechos reservados.', 'flowdesk' ); ?></p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
