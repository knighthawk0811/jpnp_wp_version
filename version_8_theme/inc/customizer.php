<?php
/**
 * version_8 Theme Customizer
 *
 * @package version_8
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function version_8_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'version_8_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'version_8_customize_partial_blogdescription',
		) );
	}

	
	/*
	//header color
	$wp_customize->add_setting('header_background', array(
		'type' => 'theme_mod', // or 'option'
		'capability' => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
		'default' => '#000000',
		'transport' => 'refresh', // or postMessage
		'sanitize_callback' => 'sanitize_hex_color',
		'sanitize_js_callback' => '', // Basically to_json.
	) );
	$wp_customize->add_control( 'header_background', array(
		'type' => 'textbox',
		'priority' => 10, // Within the section.
		'section' => 'colors', // Required, core or custom.
		'label' => __( 'Header Background Color' ),
		'description' => __( 'The color behind the main slider should match the sliders color to prevent visible overlap.' ),
	) );
	$wp_customize->add_section( 'custom_css', array(
		'title' => __( 'INMA Custom Options' ),
		'description' => __( 'Change Theme specific Options here.' ),
		'panel' => '', // Not typically needed.
		'priority' => 160,
		'capability' => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	) );
	//*/
}
add_action( 'customize_register', 'version_8_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function version_8_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function version_8_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function version_8_customize_preview_js() {
	wp_enqueue_script( 'version_8-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'version_8_customize_preview_js' );




/**
 * Load customizer CSS in the wp_head
 *
 * @link 
 * @version 8.3.1906
 * @since 8.3.1906
 */
if ( ! function_exists( 'version_8_customize_css' ) ) :
function version_8_customize_css()
{
	?>
		<style type="text/css">
			#masthead,
			#colophon {
				background:<?php echo get_theme_mod('header_background', '#000000'); ?>;
			}
		</style>
	<?php
}
//add_action( 'wp_head', 'version_8_customize_css');
endif;