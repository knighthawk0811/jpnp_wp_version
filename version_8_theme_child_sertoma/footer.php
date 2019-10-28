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

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
        <div class="background-special"></div>
		<?php get_template_part( 'sidebar-templates/sidebar', 'footer' ); ?>
        <?php
            if ( has_nav_menu( 'footer-1' ) ) {
                echo('<div id="nav-footer-1">');
                wp_nav_menu( array(
                    'theme_location' => 'footer-1',
                ) );
                echo('</div>');
            }
            if ( has_nav_menu( 'footer-2' ) ) {
                echo('<div id="nav-footer-2">');
                wp_nav_menu( array(
                    'theme_location' => 'footer-2',
                ) );
                echo('</div>');
            }
        ?>
        <?php get_template_part( 'sidebar-templates/sidebar', 'footer-2' ); ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>