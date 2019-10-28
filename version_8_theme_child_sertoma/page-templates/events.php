<?php
/**
 * Template Name: Event-List
 * The template for displaying events pages *
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package version_8
 */

//add class to body
version_8_body_add_class( 'events sertoma-main' );

get_header();
?>
	<div id="primary" class="content-area">
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
	</div><!-- #primary -->

<?php
get_footer();
