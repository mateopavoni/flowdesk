<?php
/**
 * Página genérica (About, Contacto, etc.). La página "Contacto" (por slug)
 * suma el formulario; el resto solo muestra el contenido de wp-admin.
 */
get_header();
?>
<article class="container-fd py-16 max-w-3xl">
	<?php while ( have_posts() ) : the_post(); ?>
		<h1 class="text-3xl mb-6"><?php the_title(); ?></h1>
		<div class="prose max-w-none">
			<?php the_content(); ?>
		</div>

		<?php if ( is_page( 'contacto' ) ) : ?>
			<?php get_template_part( 'template-parts/contact-form' ); ?>
		<?php endif; ?>
	<?php endwhile; ?>
</article>
<?php get_footer(); ?>
