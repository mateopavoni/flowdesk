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
	<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:bg-violet focus:text-white focus:px-4 focus:py-2" href="#contenido">
	<?php esc_html_e( 'Saltar al contenido', 'flowdesk' ); ?>
</a>

<header class="sticky top-0 z-40 bg-void/95 backdrop-blur border-b border-panel/60">
	<nav class="container-fd flex items-center justify-between py-3" aria-label="<?php esc_attr_e( 'Navegación principal', 'flowdesk' ); ?>">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2 font-heading font-semibold text-lg text-bone no-underline">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<?php bloginfo( 'name' ); ?>
			<?php endif; ?>
		</a>

		<button type="button" id="fd-nav-toggle" class="md:hidden p-2 border border-panel/60 text-bone" aria-expanded="false" aria-controls="fd-nav-menu">
			<span class="sr-only"><?php esc_html_e( 'Abrir menú', 'flowdesk' ); ?></span>
			<span data-fd-icon-open><?php echo flowdesk_icon( 'menu' ); ?></span>
			<span data-fd-icon-close class="hidden"><?php echo flowdesk_icon( 'x' ); ?></span>
		</button>

		<div id="fd-nav-menu" class="hidden md:flex items-center gap-1">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'fd-navtabs flex flex-col md:flex-row items-center gap-1 text-sm font-medium',
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
