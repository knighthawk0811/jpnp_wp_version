<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package version_8
 */

?>

            <?php if( is_front_page() ){ get_sidebar('home-2'); } ?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<?php get_sidebar('footer-1'); ?>
			<?php get_sidebar('footer-3'); ?>
            <?php get_sidebar('footer-2'); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->
<?php wp_footer(); ?>

<?php get_sidebar('after-1'); ?>

</body>
</html>
