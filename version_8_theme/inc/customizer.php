<?php
/**
 * version_8 Theme Customizer
 *
 * @package version_8
 */

$version_8_theme_default_value = array(
    'modal_background_trans' => '75',
    'header_image' => '0',
    'version_8_custom_style_duration' => '48',
    'color_bg_1' => '#eeeeee',
    'color_bg_2' => '#dddddd',
    'color_bg_3' => '#cccccc',
    'color_bg_4' => '#bbbbbb',
    'color_bg_b' => '#000000',
    'color_bg_w' => '#ffffff',
    'color_bg_c' => 'rgba(0,0,0,0)',
    'color_text_1' => '#111111',
    'color_text_2' => '#222222',
    'color_text_3' => '#333333',
    'color_text_4' => '#444444',
    'color_text_b' => '#000000',
    'color_text_w' => '#ffffff',
    'color_text_c' => 'rgba(0,0,0,0)',
    'version_8_test_value' => 'color_bg_1',
);


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

/*--------------------------------------------------------------
# custom panel & sections
--------------------------------------------------------------*/
	$wp_customize->add_panel( 'version_8_custom_panel', array(
		'title' => __( get_bloginfo( 'name' ) . ' Settings' ),
		'description' => __( 'Change custom Theme settings here.' ),
		'priority' => 160,
		'capability' => 'edit_theme_options',
	) );

	$wp_customize->add_section( 'version_8_custom_section_general', array(
		'title' => __('General Settings' ),
		'description' => __( 'Change custom Theme settings here.' ),
		'priority' => 160,
		'capability' => 'edit_theme_options',
		'panel' => 'version_8_custom_panel',
	) );

	$wp_customize->add_section( 'version_8_custom_section_color_chooser', array(
		'title' => __('Color Chooser' ),
		'description' => __( 'Select your custom colors here.' ),
		'priority' => 160,
		'capability' => 'edit_theme_options',
		'panel' => 'version_8_custom_panel',
	) );

	$wp_customize->add_section( 'version_8_custom_section_modal', array(
		'title' => __('Modal Settings' ),
		'description' => __( 'Settings for the Modal here.' ),
		'priority' => 160,
		'capability' => 'edit_theme_options',
		'panel' => 'version_8_custom_panel',
	) );

	$wp_customize->add_section( 'version_8_custom_section_header', array(
		'title' => __('Header Settings' ),
		'description' => __( 'Settings for the Modal here.' ),
		'priority' => 160,
		'capability' => 'edit_theme_options',
		'panel' => 'version_8_custom_panel',
	) );

	$wp_customize->add_section( 'version_8_custom_section_content', array(
		'title' => __('Content Area Settings' ),
		'description' => __( 'Settings for the Modal here.' ),
		'priority' => 160,
		'capability' => 'edit_theme_options',
		'panel' => 'version_8_custom_panel',
	) );

	$wp_customize->add_section( 'version_8_custom_section_footer', array(
		'title' => __('Footer Settings' ),
		'description' => __( 'Settings for the Modal here.' ),
		'priority' => 160,
		'capability' => 'edit_theme_options',
		'panel' => 'version_8_custom_panel',
	) );



/*--------------------------------------------------------------
# style_custom.css cache duration in hours
--------------------------------------------------------------*/
	$wp_customize->add_setting('version_8_custom_style_duration', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['version_8_custom_style_duration'],
      	'sanitize_callback' => 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'version_8_custom_style_duration_control',
		array(
      		'type' => 'text', // Can be either text, email, url, number, hidden, or date
			'priority' => 10, // Within the section.
			'label' => __( 'custom style - cache duration' ),
			'description' => __( 'cache duration in hours [default 48]' ),
			'section' => 'version_8_custom_section_general', // Required, core or custom.
			'settings' => 'version_8_custom_style_duration',
			'input_attrs' => array(
		         'placeholder' => __( 'Hours to hold cache' ),
      		),
		)
	);


/*--------------------------------------------------------------
# Colors
--------------------------------------------------------------*/

/* background */
	$wp_customize->add_setting('color_bg_1', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['color_bg_1'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'color_bg_1_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Background Color 1' ),
			'description' => __( 'One of four background color choices' ),
			'section' => 'version_8_custom_section_color_chooser', // Required, core or custom.
			'settings' => 'color_bg_1'
		)
	) );

	$wp_customize->add_setting('color_bg_2', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['color_bg_2'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'color_bg_2_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Background Color 2' ),
			'description' => __( 'One of four background color choices' ),
			'section' => 'version_8_custom_section_color_chooser', // Required, core or custom.
			'settings' => 'color_bg_2'
		)
	) );

	$wp_customize->add_setting('color_bg_3', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['color_bg_3'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'color_bg_3_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Background Color 3' ),
			'description' => __( 'One of four background color choices' ),
			'section' => 'version_8_custom_section_color_chooser', // Required, core or custom.
			'settings' => 'color_bg_3'
		)
	) );

	$wp_customize->add_setting('color_bg_4', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['color_bg_4'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'color_bg_4_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Background Color 4' ),
			'description' => __( 'One of four background color choices' ),
			'section' => 'version_8_custom_section_color_chooser', // Required, core or custom.
			'settings' => 'color_bg_4'
		)
	) );


/* text */
	$wp_customize->add_setting('color_text_1', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['color_text_1'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'color_text_1_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Text Color 1' ),
			'description' => __( 'One of four text color choices' ),
			'section' => 'version_8_custom_section_color_chooser', // Required, core or custom.
			'settings' => 'color_text_1'
		)
	) );

	$wp_customize->add_setting('color_text_2', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['color_text_2'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'color_text_2_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Text Color 2' ),
			'description' => __( 'One of four text color choices' ),
			'section' => 'version_8_custom_section_color_chooser', // Required, core or custom.
			'settings' => 'color_text_2'
		)
	) );

	$wp_customize->add_setting('color_text_3', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['color_text_3'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'color_text_3_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Text Color 3' ),
			'description' => __( 'One of four text color choices' ),
			'section' => 'version_8_custom_section_color_chooser', // Required, core or custom.
			'settings' => 'color_text_3'
		)
	) );

	$wp_customize->add_setting('color_text_4', array(
		'capability' => 'edit_theme_options',
		'default' => $version_8_theme_default_value['color_text_4'],
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,  'color_text_4_control',
		array(
			'priority' => 10, // Within the section.
			'label' => __( 'Text Color 4' ),
			'description' => __( 'One of four text color choices' ),
			'section' => 'version_8_custom_section_color_chooser', // Required, core or custom.
			'settings' => 'color_text_4'
		)
	) );


/*--------------------------------------------------------------
# Modal
--------------------------------------------------------------*/
$wp_customize->add_setting( 'modal_bg_color',
   array(
      'default' => 'color_bg_1',
      'transport' => 'refresh',
      'sanitize_callback' => 'version_8_sanitize_radio'
   )
);
$wp_customize->add_control( 'modal_bg_color',
   array(
      'label' => __( 'Modal Background Color' ),
      'description' => esc_html__( 'Choose from your 4 pre-selected background colors' ),
      'section' => 'version_8_custom_section_modal',
      'priority' => 10, // Optional. Order priority to load the control. Default: 10
      'type' => 'radio',
      'capability' => 'edit_theme_options', // Optional. Default: 'edit_theme_options'
      'choices' => array( // Optional.
         'color_bg_1' => __( 'Color 1' ),
         'color_bg_2' => __( 'Color 2' ),
         'color_bg_3' => __( 'Color 3' ),
         'color_bg_4' => __( 'Color 4' ),
         'color_bg_b' => __( 'Color Black' ),
         'color_bg_w' => __( 'Color White' ),
         'color_bg_c' => __( 'Color Clear' )
      )
   )
);

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
		'section' => 'version_8_custom_section_modal', // Required, core or custom.
		'settings' => 'modal_background_trans',
		'input_attrs' => array(
		    'min' => 0,
		    'max' => 100,
		    'step' => 1,)
	)
);

$wp_customize->add_setting( 'modal_text_color',
   array(
      'default' => 'color_text_1',
      'transport' => 'refresh',
      'sanitize_callback' => 'version_8_sanitize_radio'
   )
);
$wp_customize->add_control( 'modal_text_color',
   array(
      'label' => __( 'Modal Text Color' ),
      'description' => esc_html__( 'Choose from your 4 pre-selected text colors' ),
      'section' => 'version_8_custom_section_modal',
      'priority' => 10, // Optional. Order priority to load the control. Default: 10
      'type' => 'radio',
      'capability' => 'edit_theme_options', // Optional. Default: 'edit_theme_options'
      'choices' => array( // Optional.
         'color_text_1' => __( 'Color 1' ),
         'color_text_2' => __( 'Color 2' ),
         'color_text_3' => __( 'Color 3' ),
         'color_text_4' => __( 'Color 4' ),
         'color_text_b' => __( 'Color Black' ),
         'color_text_w' => __( 'Color White' ),
         'color_text_c' => __( 'Color Clear' )
      )
   )
);

/*--------------------------------------------------------------
# Header
--------------------------------------------------------------*/
$wp_customize->add_setting( 'header_bg_color',
   array(
      'default' => 'color_bg_1',
      'transport' => 'refresh',
      'sanitize_callback' => 'version_8_sanitize_radio'
   )
);
$wp_customize->add_control( 'header_bg_color',
   array(
      'label' => __( 'Header Background Color' ),
      'description' => esc_html__( 'Choose from your 4 pre-selected background colors' ),
      'section' => 'version_8_custom_section_header',
      'priority' => 10, // Optional. Order priority to load the control. Default: 10
      'type' => 'radio',
      'capability' => 'edit_theme_options', // Optional. Default: 'edit_theme_options'
      'choices' => array( // Optional.
         'color_bg_1' => __( 'Color 1' ),
         'color_bg_2' => __( 'Color 2' ),
         'color_bg_3' => __( 'Color 3' ),
         'color_bg_4' => __( 'Color 4' ),
         'color_bg_b' => __( 'Color Black' ),
         'color_bg_w' => __( 'Color White' ),
         'color_bg_c' => __( 'Color Clear' )
      )
   )
);

//header image
$wp_customize->add_setting( 'header_bg_image', array(
      //default
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_bg_image_control',
   array(
      'label' => __( 'Header Background Image' ),
      'description' => esc_html__( 'Select an image to use as the header background.' ),
	  'section' => 'version_8_custom_section_header', // Required, core or custom.
	  'settings' => 'header_bg_image'
   )
) );

$wp_customize->add_setting( 'header_text_color',
   array(
      'default' => 'color_text_1',
      'transport' => 'refresh',
      'sanitize_callback' => 'version_8_sanitize_radio'
   )
);
$wp_customize->add_control( 'header_text_color',
   array(
      'label' => __( 'Header Text Color' ),
      'description' => esc_html__( 'Choose from your 4 pre-selected text colors' ),
      'section' => 'version_8_custom_section_header',
      'priority' => 10, // Optional. Order priority to load the control. Default: 10
      'type' => 'radio',
      'capability' => 'edit_theme_options', // Optional. Default: 'edit_theme_options'
      'choices' => array( // Optional.
         'color_text_1' => __( 'Color 1' ),
         'color_text_2' => __( 'Color 2' ),
         'color_text_3' => __( 'Color 3' ),
         'color_text_4' => __( 'Color 4' ),
         'color_text_b' => __( 'Color Black' ),
         'color_text_w' => __( 'Color White' ),
         'color_text_c' => __( 'Color Clear' )
      )
   )
);


/*--------------------------------------------------------------
# Content
--------------------------------------------------------------*/
$wp_customize->add_setting( 'content_bg_color',
   array(
      'default' => 'color_bg_1',
      'transport' => 'refresh',
      'sanitize_callback' => 'version_8_sanitize_radio'
   )
);
$wp_customize->add_control( 'content_bg_color',
   array(
      'label' => __( 'Content Background Color' ),
      'description' => esc_html__( 'Choose from your 4 pre-selected background colors' ),
      'section' => 'version_8_custom_section_content',
      'priority' => 10, // Optional. Order priority to load the control. Default: 10
      'type' => 'radio',
      'capability' => 'edit_theme_options', // Optional. Default: 'edit_theme_options'
      'choices' => array( // Optional.
         'color_bg_1' => __( 'Color 1' ),
         'color_bg_2' => __( 'Color 2' ),
         'color_bg_3' => __( 'Color 3' ),
         'color_bg_4' => __( 'Color 4' ),
         'color_bg_b' => __( 'Color Black' ),
         'color_bg_w' => __( 'Color White' ),
         'color_bg_c' => __( 'Color Clear' )
      )
   )
);

//content image
$wp_customize->add_setting( 'content_bg_image', array(
      //default
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'content_bg_image_control',
   array(
      'label' => __( 'Content Background Image' ),
      'description' => esc_html__( 'Select an image to use as the content background.' ),
	  'section' => 'version_8_custom_section_content', // Required, core or custom.
	  'settings' => 'header_bg_image'
   )
) );

$wp_customize->add_setting( 'content_text_color',
   array(
      'default' => 'color_text_1',
      'transport' => 'refresh',
      'sanitize_callback' => 'version_8_sanitize_radio'
   )
);
$wp_customize->add_control( 'content_text_color',
   array(
      'label' => __( 'Content Text Color' ),
      'description' => esc_html__( 'Choose from your 4 pre-selected text colors' ),
      'section' => 'version_8_custom_section_content',
      'priority' => 10, // Optional. Order priority to load the control. Default: 10
      'type' => 'radio',
      'capability' => 'edit_theme_options', // Optional. Default: 'edit_theme_options'
      'choices' => array( // Optional.
         'color_text_1' => __( 'Color 1' ),
         'color_text_2' => __( 'Color 2' ),
         'color_text_3' => __( 'Color 3' ),
         'color_text_4' => __( 'Color 4' ),
         'color_text_b' => __( 'Color Black' ),
         'color_text_w' => __( 'Color White' ),
         'color_text_c' => __( 'Color Clear' )
      )
   )
);


/*--------------------------------------------------------------
# Footer
--------------------------------------------------------------*/
$wp_customize->add_setting( 'footer_bg_color',
   array(
      'default' => 'color_bg_1',
      'transport' => 'refresh',
      'sanitize_callback' => 'version_8_sanitize_radio'
   )
);
$wp_customize->add_control( 'footer_bg_color',
   array(
      'label' => __( 'Footer Background Color' ),
      'description' => esc_html__( 'Choose from your 4 pre-selected background colors' ),
      'section' => 'version_8_custom_section_footer',
      'priority' => 10, // Optional. Order priority to load the control. Default: 10
      'type' => 'radio',
      'capability' => 'edit_theme_options', // Optional. Default: 'edit_theme_options'
      'choices' => array( // Optional.
         'color_bg_1' => __( 'Color 1' ),
         'color_bg_2' => __( 'Color 2' ),
         'color_bg_3' => __( 'Color 3' ),
         'color_bg_4' => __( 'Color 4' ),
         'color_bg_b' => __( 'Color Black' ),
         'color_bg_w' => __( 'Color White' ),
         'color_bg_c' => __( 'Color Clear' )
      )
   )
);

//footer image
$wp_customize->add_setting( 'footer_bg_image', array(
      //default
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_bg_image_control',
   array(
      'label' => __( 'Footer Background Image' ),
      'description' => esc_html__( 'Select an image to use as the footer background.' ),
	  'section' => 'version_8_custom_section_footer', // Required, core or custom.
	  'settings' => 'header_bg_image'
   )
) );

$wp_customize->add_setting( 'footer_text_color',
   array(
      'default' => 'color_text_1',
      'transport' => 'refresh',
      'sanitize_callback' => 'version_8_sanitize_radio'
   )
);
$wp_customize->add_control( 'footer_text_color',
   array(
      'label' => __( 'Footer Text Color' ),
      'description' => esc_html__( 'Choose from your 4 pre-selected text colors' ),
      'section' => 'version_8_custom_section_footer',
      'priority' => 10, // Optional. Order priority to load the control. Default: 10
      'type' => 'radio',
      'capability' => 'edit_theme_options', // Optional. Default: 'edit_theme_options'
      'choices' => array( // Optional.
         'color_text_1' => __( 'Color 1' ),
         'color_text_2' => __( 'Color 2' ),
         'color_text_3' => __( 'Color 3' ),
         'color_text_4' => __( 'Color 4' ),
         'color_text_b' => __( 'Color Black' ),
         'color_text_w' => __( 'Color White' ),
         'color_text_c' => __( 'Color Clear' )
      )
   )
);

/*--------------------------------------------------------------
# test
--------------------------------------------------------------*/

	$wp_customize->add_setting('version_8_test_value', array(
		'capability' => 'edit_theme_options',
		'default' => version_8_get_customizer_value('header_bg_color'),
      	'sanitize_callback' => 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'version_8_test_value_control',
		array(
      		'type' => 'text', // Can be either text, email, url, number, hidden, or date
			'priority' => 10, // Within the section.
			'label' => __( 'test value' ),
			'description' => __( 'test value' ),
			'section' => 'version_8_custom_section_general', // Required, core or custom.
			'settings' => 'version_8_test_value',
			'input_attrs' => array(
		         'placeholder' => __( 'test value' ),
      		),
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
 * Sanitixe radio buttons
 * set the defualt if failed
 *
 * @link https://cachingandburning.com/wordpress-theme-customizer-sanitizing-radio-buttons-and-select-lists/
 * @version 8.3.2003
 * @since 8.3.2003
 */
if ( ! function_exists( 'version_8_sanitize_radio' ) ) :
function version_8_sanitize_radio( $input, $setting ) {
    global $wp_customize;

    $control = $wp_customize->get_control( $setting->id );

    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}
endif;

/**
 * get the value stored previously
 *
 * @link
 * @version 8.3.2003
 * @since 8.3.1909
 */
if ( ! function_exists( 'version_8_get_customizer_value' ) ) :
function version_8_get_customizer_value( $input = '' )
{
	global $version_8_theme_default_value;

	$input = sanitize_title($input);
	$output = get_theme_mod($input, $version_8_theme_default_value[$input]);
	//force set to default value?
	set_theme_mod($input, $output);


	switch($output)
	{
		case 'color_bg_1':
		case 'color_bg_2':
		case 'color_bg_3':
		case 'color_bg_4':
		case 'color_bg_b':
		case 'color_bg_w':
		case 'color_bg_c':
		case 'color_text_1':
		case 'color_text_2':
		case 'color_text_3':
		case 'color_text_4':
		case 'color_text_b':
		case 'color_text_w':
		case 'color_text_c':
			$output = version_8_get_customizer_value($output);
			break;
		default :
			//do nothing
	}
	return $output;
}
endif;



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
	//if the file doesn't exist, then force the math to reset
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
		$masthead_bg_img = 'background-image:none';
		if( get_theme_mod( 'header_image', '0' ) != '0' ) :
				$masthead_bg_img =  'background-image:url("' . get_theme_mod( 'header_image', '0' ) . '")';
			else :
				//do nothing
			endif;


		?>
			<style type="text/css">
				#modal-main-container #modal-bg{
					opacity:<?php echo( intval(version_8_get_customizer_value('modal_background_trans')) / 100); ?>;
				}

				#masthead{
					<?php echo( $masthead_bg ); ?>;
					<?php echo( $masthead_bg_img . ';' ); ?>
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
				.color-bg-b {
					background-color: <?php echo version_8_get_customizer_value('color_bg_b'); ?>;
				}
				.color-bg-w {
					background-color: <?php echo version_8_get_customizer_value('color_bg_w'); ?>;
				}
				.color-bg-c {
					background-color: <?php echo version_8_get_customizer_value('color_bg_c'); ?>;
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
				.color-text-b {
					color: <?php echo version_8_get_customizer_value('color_text_b'); ?>;
				}
				.color-text-w {
					color: <?php echo version_8_get_customizer_value('color_text_w'); ?>;
				}
				.color-text-c {
					color: <?php echo version_8_get_customizer_value('color_text_c'); ?>;
				}
			</style>
		<?php
	    $content = ob_get_contents();
	    ob_end_clean();
	    file_put_contents ( get_stylesheet_directory() . '/style_custom.css' , $content);
	    set_theme_mod('version_8_custom_style_time', $today);

	}
}
add_action( 'wp_head', 'version_8_customize_css');
endif;