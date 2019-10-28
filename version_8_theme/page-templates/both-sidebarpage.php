<?php
/**
 * Template Name: Both Sidebars
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package version_8_child
 */

//add class to body
version_8_body_classes( 'sidebar-1 sidebar-2' );
get_header();
?>
	<div id="primary" class="content-area">
		<?php get_template_part( 'sidebar-templates/sidebar', 'left' ); ?>
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
		<?php get_template_part( 'sidebar-templates/sidebar', 'right' ); ?>
	</div><!-- #primary -->

<?php
get_footer();
