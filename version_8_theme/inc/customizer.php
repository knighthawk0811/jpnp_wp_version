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

	//custom section
	$wp_customize->add_section( 'local_custom_section', array(
		'title' => __( get_bloginfo( 'name' ) . ' Settings' ),
		'description' => __( 'Change custom settings here.' ),
		'priority' => 160,
		'capability' => 'edit_theme_options',
	) );
	//modal background color
	$wp_customize->add_setting('modal_background', array(
		'capability' => 'edit_theme_options',
		'default' => '#dddddd',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'modal_background_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Modal Background Color' ),
			'description' => __( 'The color of the modal area.' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'modal_background'
		)
	) );
	//modal button background color
	$wp_customize->add_setting('modal_button_background', array(
		'capability' => 'edit_theme_options',
		'default' => '#dddddd',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'modal_button_background_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Modal Button Background Color' ),
			'description' => __( 'The color of the modal button.' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'modal_button_background'
		)
	) );
	//header image
	$wp_customize->add_setting( 'header_image', array(
	      //default
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_image_control',
	   array(
	      'label' => __( 'Default Header Image' ),
	      'description' => esc_html__( 'Select a default image to use in the header' ),
		  'section' => 'local_custom_section', // Required, core or custom.
		  'settings' => 'header_image'
	   )
	) );
	//header background color
	$wp_customize->add_setting('header_background', array(
		'capability' => 'edit_theme_options',
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'header_background_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Header Background Color' ),
			'description' => __( 'The color of the header, in front of the image' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'header_background'
		)
	) );
	//header background toggle on/off
	$wp_customize->add_setting('header_background_toggle', array(
		'capability' => 'edit_theme_options',
	) );
	$wp_customize->add_control( 'header_background_toggle_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Header Background Toggle' ),
			'type' => 'checkbox',
			'description' => __( 'Make the header clear?' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'header_background_toggle'
		)
	);
	//footer background color
	$wp_customize->add_setting('footer_background', array(
		'capability' => 'edit_theme_options',
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'footer_background_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Footer Background Color' ),
			'description' => __( 'The color of the footer area.' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'footer_background'
		)
	) );
	//footer background toggle on/off
	$wp_customize->add_setting('footer_background_toggle', array(
		'capability' => 'edit_theme_options',
	) );
	$wp_customize->add_control( 'footer_background_toggle_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Footer Background Toggle' ),
			'type' => 'checkbox',
			'description' => __( 'Make the footer clear?' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'footer_background_toggle'
		)
	);

	//custom css area
	$wp_customize->add_section( 'custom_css', array(
		'title' => __( 'Custom CSS' ),
		'description' => __( 'Add custom CSS here.' ),
		'panel' => '', // Not typically needed.
		'priority' => 160,
		'capability' => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	) );

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
	$masthead_bg = 'background-color:' . get_theme_mod('header_background');
	if(	get_theme_mod('header_background_toggle') )
	{
		$masthead_bg = 'background:none';
	}

	$colophon_bg = 'background-color:' . get_theme_mod('footer_background');
	if(	get_theme_mod('footer_background_toggle') )
	{
		$colophon_bg = 'background:none';
	}

	?>
		<style type="text/css">
			#modal-main-container #modal-bg{
				background-color: <?php echo get_theme_mod('modal_background'); ?>;
			}
			#modal-main-container #modal-button,
			#modal-main-container #modal-button .toggle-closed,
			#modal-main-container #modal-button .toggle-open {
				background-color: <?php echo get_theme_mod('modal_button_background'); ?>;
			}
			#masthead{
				<?php echo( $masthead_bg ); ?>;
			}
			#colophon{
				<?php echo( $colophon_bg ); ?>;
			}
		</style>
	<?php
}
add_action( 'wp_head', 'version_8_customize_css');
endif;