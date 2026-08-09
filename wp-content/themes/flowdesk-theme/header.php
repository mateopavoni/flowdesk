<?php
/**
 * Header: <head>, navbar sticky con logo + menú.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Stencil:wght@600;700;800&family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet" />
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-anthracite' ); ?>>
<?php wp_body_open(); ?>

<a class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:bg-amber focus:text-anthracite focus:px-4 focus:py-2" href="#contenido">
	<?php esc_html_e( 'Saltar al contenido', 'flowdesk' ); ?>
</a>

<header class="sticky top-0 z-40 bg-anthracite/95 backdrop-blur border-b border-metal">
	<nav class="container-fd flex items-center justify-between py-3" aria-label="<?php esc_attr_e( 'Navegación principal', 'flowdesk' ); ?>">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2 fd-nameplate !text-base !py-2 !px-3 no-underline">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<span class="fd-led is-on" aria-hidden="true"></span>
				<?php bloginfo( 'name' ); ?><span class="text-slate-500">: OPERATOR CONSOLE</span>
			<?php endif; ?>
		</a>

		<button type="button" id="fd-nav-toggle" class="md:hidden p-2 border border-metal text-slate-800" aria-expanded="false" aria-controls="fd-nav-menu">
			<span class="sr-only"><?php esc_html_e( 'Abrir menú', 'flowdesk' ); ?></span>
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
		</button>

		<div id="fd-nav-menu" class="hidden md:flex items-center gap-1">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'fd-navtabs flex flex-col md:flex-row items-center gap-1 text-xs font-heading uppercase tracking-wide',
				'fallback_cb'    => 'flowdesk_default_menu',
			) );
			?>
			<a href="#pricing" class="btn-primary ml-2 !px-4 !py-2 !text-xs">
				<?php esc_html_e( 'Prueba gratis', 'flowdesk' ); ?>
			</a>
		</div>
	</nav>
</header>

<main id="contenido">
