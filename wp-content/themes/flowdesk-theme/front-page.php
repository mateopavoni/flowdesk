<?php
/**
 * Home. Compone las secciones de landing en template-parts/.
 * Pricing y testimonios los resuelve el plugin flowdesk-toolkit
 * (shortcode y widget respectivamente) — el tema no duplica esos datos.
 */
get_header();
?>
<?php get_template_part( 'template-parts/hero' ); ?>
<?php get_template_part( 'template-parts/features' ); ?>
<?php get_template_part( 'template-parts/video' ); ?>

<section id="pricing" class="container-fd py-20">
	<div class="text-center max-w-2xl mx-auto mb-14">
		<h2 class="text-3xl"><?php esc_html_e( 'Precios simples, sin letra chica', 'flowdesk' ); ?></h2>
	</div>
	<?php echo do_shortcode( '[flowdesk_pricing]' ); ?>
</section>

<section id="testimonios" class="bg-slate-50 py-20">
	<div class="container-fd">
		<div class="text-center max-w-2xl mx-auto mb-14">
			<h2 class="text-3xl"><?php esc_html_e( 'Lo que dicen los equipos que ya lo usan', 'flowdesk' ); ?></h2>
		</div>
		<?php the_widget( 'Flowdesk_Testimonials_Widget', array( 'count' => 5 ) ); ?>
	</div>
</section>

<?php get_template_part( 'template-parts/faq' ); ?>
<?php get_template_part( 'template-parts/newsletter' ); ?>
<?php get_footer(); ?>
