<?php
/**
 * version_8 Theme Customizer
 *
 * @package version_8
 */

$version_8_theme_default_value = array(
    'modal_background' => '#dddddd',
    'modal_background_trans' => '75',
    'modal_button_background' => '#999999',
    'modal_font_color' => '#000000',
    'modal_font_color_highlight' => '#666666',
    'header_background' => '#cccccc',
    'header_background_toggle' => 'true',
    'header_font_color' => '#000000',
    'footer_background' => '#cccccc',
    'footer_background_toggle' => 'false',
    'footer_font_color' => '#000000',
    'color_bg_1' => '#cccccc',
    'color_bg_2' => '#cccccc',
    'color_bg_3' => '#cccccc',
    'color_bg_4' => '#cccccc',
    'color_text_1' => '#666666',
    'color_text_2' => '#666666',
    'color_text_3' => '#666666',
    'color_text_4' => '#666666',
    'version_8_custom_style_duration' => '48',
);

/**
 * get the color value stored previously
 *
 * @link
 * @version 8.3.1909
 * @since 8.3.1909
 */
if ( ! function_exists( 'version_8_get_customizer_value' ) ) :
function version_8_get_customizer_value( $input = '' )
{
	$input = sanitize_title($input);
	$output = get_theme_mod($input, $version_8_theme_default_value[$input]);
	set_theme_mod($input, $output);
	return $output;
}
endif;

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function version_8_customize_register( $wp_customize )
{
	global $version_8_theme_default_value;


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
		'description' => __( 'Change custom Theme settings here.' ),
		'priority' => 160,
		'capability' => 'edit_theme_options',
	) );




/*--------------------------------------------------------------
# Modal
--------------------------------------------------------------*/
	//modal background color
	$wp_customize->add_setting('modal_background', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['modal_background'],
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
	//modal background transparency
	$wp_customize->add_setting('modal_background_trans', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['modal_background_trans'],
	) );
	$wp_customize->add_control( 'modal_background_trans_control',
		array(
			'type' => 'range',
			'priority' => 10, // Within the section.
			'label' => __( 'Modal Background Transparency' ),
			'description' => __( 'The Transparency of the modal area.' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'modal_background_trans',
			'input_attrs' => array(
			    'min' => 0,
			    'max' => 100,
			    'step' => 1,)
		)
	);
	//modal button background color
	$wp_customize->add_setting('modal_button_background', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['modal_button_background'],
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
	//modal link color
	$wp_customize->add_setting('modal_font_color', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['modal_font_color'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'modal_font_color_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Modal Font Color' ),
			'description' => __( 'The color of the text in the modal area.' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'modal_font_color'
		)
	) );
	//modal link highlight color
	$wp_customize->add_setting('modal_font_color_highlight', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['modal_font_color_highlight'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'modal_font_color_highlight_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Modal Link (Highlight) Color' ),
			'description' => __( 'The color of the link text whien highlighted.' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'modal_font_color_highlight'
		)
	) );



/*--------------------------------------------------------------
# Header
--------------------------------------------------------------*/
	//header background color
	$wp_customize->add_setting('header_background', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['header_background'],
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
		'default' => $version_8_theme_default_value['header_background_toggle'],
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
	//header image
	$wp_customize->add_setting( 'header_image', array(
	      //default
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_image_control',
	   array(
	      'label' => __( 'Header Image (Default)' ),
	      'description' => esc_html__( 'Select a default image to use in the header. A unique image can be set as the featured image for individual pages and posts.' ),
		  'section' => 'local_custom_section', // Required, core or custom.
		  'settings' => 'header_image'
	   )
	) );
	//header font color
	$wp_customize->add_setting('header_font_color', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['header_font_color'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'header_font_color_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Header Font Color' ),
			'description' => __( 'The color of the text in the Header.' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'header_font_color'
		)
	) );


/*--------------------------------------------------------------
# Footer
--------------------------------------------------------------*/
	//footer background color
	$wp_customize->add_setting('footer_background', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['footer_background'],
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
		'default' => $version_8_theme_default_value['footer_background_toggle'],
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
	//footer image
	$wp_customize->add_setting( 'footer_image', array(
	      //default
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_image_control',
	   array(
	      'label' => __( 'Footer Image' ),
	      'description' => esc_html__( 'Select an image to be used as the Footer background' ),
		  'section' => 'local_custom_section', // Required, core or custom.
		  'settings' => 'footer_image'
	   )
	) );
	//footer font color
	$wp_customize->add_setting('footer_font_color', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['footer_font_color'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'footer_font_color_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Footer Font Color' ),
			'description' => __( 'The color of the text in the Footer.' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'footer_font_color'
		)
	) );


/*--------------------------------------------------------------
# Colors
--------------------------------------------------------------*/
	//background color
	$wp_customize->add_setting('color_bg_1', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['color_bg_1'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'color_bg_1_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Background Color #1' ),
			'description' => __( 'Background Color option 1' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'color_bg_1'
		)
	) );
	//
	$wp_customize->add_setting('color_bg_2', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['color_bg_2'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'color_bg_2_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Background Color #2' ),
			'description' => __( 'Background Color option 2' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'color_bg_2'
		)
	) );
	//
	$wp_customize->add_setting('color_bg_3', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['color_bg_3'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'color_bg_3_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Background Color #3' ),
			'description' => __( 'Background Color option 3' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'color_bg_3'
		)
	) );
	//
	$wp_customize->add_setting('color_bg_4', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['color_bg_4'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'color_bg_4_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Background Color #4' ),
			'description' => __( 'Background Color option 4' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'color_bg_4'
		)
	) );
	// text color
	$wp_customize->add_setting('color_text_1', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['color_text_1'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'color_text_1_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Text Color #1' ),
			'description' => __( 'Text Color option 1' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'color_text_1'
		)
	) );
	//
	$wp_customize->add_setting('color_text_2', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['color_text_2'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'color_text_2_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Text Color #2' ),
			'description' => __( 'Text Color option 2' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'color_text_2'
		)
	) );
	//
	$wp_customize->add_setting('color_text_3', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['color_text_3'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'color_text_3_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Text Color #3' ),
			'description' => __( 'Text Color option 3' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'color_text_3'
		)
	) );
	//
	$wp_customize->add_setting('color_text_4', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['color_text_4'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'color_text_4_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Text Color #4' ),
			'description' => __( 'Text Color option 4' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'color_text_4'
		)
	) );


	//style_custom.css cache duration in hours
	$wp_customize->add_setting('version_8_custom_style_duration', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['version_8_custom_style_duration'],
	) );
	$wp_customize->add_control( 'version_8_custom_style_duration_control',
		array(
			'type' => 'range',
			'priority' => 10, // Within the section.
			'label' => __( 'custom style cache duration' ),
			'description' => __( 'style_custom.css cache duration in hours' ),
			'section' => 'local_custom_section', // Required, core or custom.
			'settings' => 'version_8_custom_style_duration',
			'input_attrs' => array(
			    'min' => 0,
			    'max' => 96,
			    'step' => 1,)
		)
	);


/*--------------------------------------------------------------
# Custom CSS
--------------------------------------------------------------*/
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
 * this function should be overridden by the child theme
 *
 * @link
 * @version 8.3.1910
 * @since 8.3.1906
 */
if ( ! function_exists( 'version_8_customize_css' ) ) :
function version_8_customize_css()
{
	$today = intval(date('YmdH'));
	$reset_time = intval(get_theme_mod('version_8_custom_style_time'),$today);
	$reset_duration = intval(get_theme_mod('version_8_custom_style_duration','01'));
	//if the file doesn't exist, then force a recreate
	if( !file_exists( dirname( __FILE__ ) . '/style_custom.css' ) )
	{
	    set_theme_mod('version_8_custom_style_time', $today);
		$reset_duration = -999;
	}

	//echo($today . '-' . $reset_time . '-' . ($today - $reset_time) . '-' . $reset_duration);
	if(( $today - $reset_time ) > $reset_duration)
	{


		$masthead_bg = 'background-color:' . version_8_get_customizer_value('header_background');
		if(	'false' == version_8_get_customizer_value('header_background_toggle') )
		{
			$masthead_bg = 'background:none';
		}

		$colophon_bg = 'background-color:' . version_8_get_customizer_value('footer_background');
		if(	'false' == version_8_get_customizer_value('footer_background_toggle') )
		{
			$colophon_bg = 'background:none no-repeat';
		}
		$colophon_bg_img = 'background-image:none';
		if( get_theme_mod( 'footer_image', '0' ) != '0' ) :
				$colophon_bg_img =  'background-image:url("' . get_theme_mod( 'footer_image', '0' ) . '")';
			else :
				//do nothing
			endif;

		?>
			<style type="text/css">
				#modal-main-container #modal-bg{
					background-color: <?php echo version_8_get_customizer_value('modal_background'); ?>;
					opacity:<?php echo( intval(version_8_get_customizer_value('modal_background_trans')) / 100); ?>;
				}
				#modal-main-container #modal-button,
				#modal-main-container #modal-button .toggle-closed,
				#modal-main-container #modal-button .toggle-open {
					background-color: <?php echo version_8_get_customizer_value('modal_button_background'); ?>;
				}
				#modal-main-container #modal-area {
					color: <?php echo version_8_get_customizer_value('modal_font_color'); ?>;
				}
				#modal-main-container #modal-area a:hover{
					color: <?php echo version_8_get_customizer_value('modal_font_color_highlight'); ?>;
				}

				#masthead{
					color: <?php echo version_8_get_customizer_value('header_font_color'); ?>;

					<?php echo( $masthead_bg ); ?>;

				}
				#colophon{
					color: <?php echo version_8_get_customizer_value('footer_font_color'); ?>;

					<?php echo( $colophon_bg . ';' ); ?>
					<?php echo( $colophon_bg_img . ';' ); ?>
					background-size: 100% auto;
				}

				.color-bg-1 {
					background-color: <?php echo version_8_get_customizer_value('color_bg_1'); ?>;
				}
				.color-bg-2 {
					background-color: <?php echo version_8_get_customizer_value('color_bg_2'); ?>;
				}
				.color-bg-3 {
					background-color: <?php echo version_8_get_customizer_value('color_bg_3'); ?>;
				}
				.color-bg-4 {
					background-color: <?php echo version_8_get_customizer_value('color_bg_4'); ?>;
				}
				.color-text-1 {
					color: <?php echo version_8_get_customizer_value('color_text_1'); ?>;
				}
				.color-text-2 {
					color: <?php echo version_8_get_customizer_value('color_text_2'); ?>;
				}
				.color-text-3 {
					color: <?php echo version_8_get_customizer_value('color_text_3'); ?>;
				}
				.color-text-4 {
					color: <?php echo version_8_get_customizer_value('color_text_4'); ?>;
				}
			</style>
		<?php
	    $content = ob_get_contents();
	    ob_end_clean();
	    file_put_contents ( dirname( __FILE__ ) . '/style_custom.css' , $content);
	    set_theme_mod('version_8_custom_style_time', $today);

	}
}
add_action( 'wp_head', 'version_8_customize_css');
endif;