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
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet" />
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-white' ); ?>>
<?php wp_body_open(); ?>

<a class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:bg-white focus:text-blue-900 focus:px-4 focus:py-2" href="#contenido">
	<?php esc_html_e( 'Saltar al contenido', 'flowdesk' ); ?>
</a>

<header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-slate-100">
	<nav class="container-fd flex items-center justify-between py-4" aria-label="<?php esc_attr_e( 'Navegación principal', 'flowdesk' ); ?>">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2 font-heading text-xl font-bold text-blue-900 no-underline">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<?php bloginfo( 'name' ); ?>
			<?php endif; ?>
		</a>

		<button type="button" id="fd-nav-toggle" class="md:hidden p-2" aria-expanded="false" aria-controls="fd-nav-menu">
			<span class="sr-only"><?php esc_html_e( 'Abrir menú', 'flowdesk' ); ?></span>
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round"/></svg>
		</button>

		<div id="fd-nav-menu" class="hidden md:flex items-center gap-8">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'flex flex-col md:flex-row items-center gap-6 text-sm font-medium',
				'fallback_cb'    => 'flowdesk_default_menu',
			) );
			?>
			<a href="#pricing" class="btn bg-blue-900 text-white hover:bg-blue-800 px-5 py-2 text-sm">
				<?php esc_html_e( 'Prueba gratis', 'flowdesk' ); ?>
			</a>
		</div>
	</nav>
</header>

<main id="contenido">
