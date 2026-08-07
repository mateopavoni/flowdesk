<?php
/**
 * Archivo de categoría/tag/fecha. Mismo grid que el índice del blog.
 */
get_header();
?>
<div class="container-fd py-16">
	<div class="text-center max-w-2xl mx-auto mb-10">
		<h1 class="text-4xl"><?php the_archive_title(); ?></h1>
		<?php the_archive_description( '<p class="mt-3 text-slate-600">', '</p>' ); ?>
	</div>

	<div class="mb-10">
		<?php get_template_part( 'template-parts/category-filter' ); ?>
	</div>

	<?php get_template_part( 'template-parts/blog-grid' ); ?>
</div>
<?php get_footer(); ?>
