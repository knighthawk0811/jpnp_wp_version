<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package version_8
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
						
	<script>		
		jQuery(document).ready(function(){
			//side-nav and modal slide
			//ON and OFF
			jQuery("#modal-main-container #modal-button").click(function(event){
				jQuery("body").toggleClass( "modal-main-toggle-on" );
			});
			//secondary OFF
			jQuery("#modal-main-shade").click(function(event) {
				jQuery("body").removeClass( "modal-main-toggle-on" );
			});
		});
	</script>
</head>

<body <?php body_class(); ?>>
<div id="modal-main-shade"></div>
<div id="modal-main-container">
	<div id="modal-bg"></div>
	<div id="modal-area">
	<?php
		get_template_part( 'sidebar-templates/sidebar', 'modal' );
		if ( has_nav_menu( 'modal' ) ) {
			echo('<div id="nav-modal">');
			wp_nav_menu( array(
				'theme_location' => 'modal',
			) );
			echo('</div>');
		}
		get_template_part( 'sidebar-templates/sidebar', 'modal-2' );
	?>
	</div>
	<div id="modal-button">&#9776;</div>
</div>

<div id="page" class="site">
	<div class="single-featured-image-header">
	<?php
		if( has_post_thumbnail() ) :
			echo get_the_post_thumbnail();
		elseif( get_theme_mod( 'header_image', '0' ) != '0' ) :
			echo('<img src="' . get_theme_mod( 'header_image' ) . '" alt="" />');
		else :
			//do nothing
		endif;
	?>
	</div><!-- .single-featured-image-header -->

	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'version_8' ); ?></a>

	<header id="masthead" class="site-header">
		<?php get_template_part( 'sidebar-templates/sidebar', 'header' ); ?>

		<nav id="site-navigation" class="main-navigation">
			<?php
				if ( has_nav_menu( 'header-1' ) ) {
					echo('<div id="nav-header-1>');
					wp_nav_menu( array(
						'theme_location' => 'header-1',
					) );
					echo('</div>');
				}
				if ( has_nav_menu( 'header-2' ) ) {
					echo('<div id="nav-header-2>');
					wp_nav_menu( array(
						'theme_location' => 'header-2',
					) );
					echo('</div>');
				}
			?>
		</nav><!-- #site-navigation -->

		<?php get_template_part( 'sidebar-templates/sidebar', 'header-2' ); ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
