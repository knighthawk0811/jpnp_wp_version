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
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<link href="https://fonts.googleapis.com/css?family=Audiowide" rel="stylesheet"> 

	<?php wp_head(); ?>

	<script>
		jQuery( function( $ ){
			$( "#hamburger-menu" ).click( function(){
				$( "body" ).toggleClass( "hamburger-menu" );
			});
		});
	</script>

</head>

<body <?php body_class(); ?>>
<div id="nav-slide">
	<div id="hamburger-menu"><div>&#9776;</div></div>
	<?php
		wp_nav_menu( array(
			'theme_location' => 'mobile-1',
		) );
	?>
</div>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'version_8' ); ?></a>

	<header id="masthead" class="site-header">
		<nav id="site-navigation" class="main-navigation">
			<?php
				wp_nav_menu( array(
					'theme_location' => 'desktop-1',
				) );
			
				wp_nav_menu( array(
					'theme_location' => 'desktop-2',
				) );
			?>
		</nav><!-- #site-navigation -->
		<div class="site-branding">
			<img class="custom-header-image"src="<?php header_image(); ?>" alt="" />
			<?php the_custom_logo(); ?>
			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
			endif; ?>
		</div><!-- .site-branding -->
		<?php /*

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'version_8' ); ?></button>
			<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				) );
			?>
		</nav><!-- #site-navigation -->

		<div class="triangle-bottomright"></div>
		<div class="triangle-bottomleft"></div>
		*/ ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content">

			<?php if( is_front_page() ){ get_sidebar('home-1'); } ?>
