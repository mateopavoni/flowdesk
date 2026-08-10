<?php
/**
 * Footer: newsletter signup + navegación + copyright.
 */
?>
</main>

<footer class="flowdesk-gradient text-white mt-24">
	<div class="container-fd py-16 grid gap-12 md:grid-cols-3">
		<div>
			<p class="font-heading text-lg font-semibold"><?php bloginfo( 'name' ); ?></p>
			<p class="mt-3 text-white/70 text-sm max-w-xs">
				<?php esc_html_e( 'Organizá el trabajo de tu equipo sin fricción. Menos reuniones, más entregas.', 'flowdesk' ); ?>
			</p>
		</div>

		<nav aria-label="<?php esc_attr_e( 'Navegación de footer', 'flowdesk' ); ?>">
			<p class="fd-eyebrow !text-white/60 mb-3"><?php esc_html_e( 'Producto', 'flowdesk' ); ?></p>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'footer',
				'container'      => false,
				'menu_class'     => 'space-y-2 text-sm text-white/80',
				'fallback_cb'    => false,
			) );
			?>
		</nav>

		<div>
			<p class="fd-eyebrow !text-white/60 mb-3"><?php esc_html_e( 'Newsletter', 'flowdesk' ); ?></p>
			<p class="text-sm text-white/70 mb-3">
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
					class="min-w-0 flex-1 bg-white/10 border border-white/30 rounded-lg px-3 py-2 text-white text-sm placeholder:text-white/50"
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

	<div class="border-t border-white/20">
		<div class="container-fd py-6 text-xs text-white/60 flex flex-col sm:flex-row justify-between gap-2">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'Todos los derechos reservados.', 'flowdesk' ); ?></p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
