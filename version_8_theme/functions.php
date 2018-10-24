<?php
/**
 * version_8 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package version_8
 */

if ( ! function_exists( 'version_8_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function version_8_setup() {
		/**
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on version_8, use a find and replace
		 * to change 'version_8' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'version_8', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'version_8' ),
			'menu-2' => esc_html__( 'Mobile', 'version_8' ),
		) );

		/**
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'version_8_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 140,
			'width'       => 380,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'version_8_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function version_8_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'version_8_content_width', 800 );
}
add_action( 'after_setup_theme', 'version_8_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function version_8_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Home Top', 'version_8' ),
		'id'            => 'home-1',
		'description'   => esc_html__( 'Add widgets here.', 'version_8' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Home Bottom', 'version_8' ),
		'id'            => 'home-2',
		'description'   => esc_html__( 'Add widgets here.', 'version_8' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Default 1', 'version_8' ),
		'id'            => 'sidebar-default-1',
		'description'   => esc_html__( 'Add widgets here.', 'version_8' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Default 2', 'version_8' ),
		'id'            => 'sidebar-default-2',
		'description'   => esc_html__( 'Add widgets here.', 'version_8' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Default 3', 'version_8' ),
		'id'            => 'sidebar-default-3',
		'description'   => esc_html__( 'Add widgets here.', 'version_8' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Footer Left', 'version_8' ),
		'id'            => 'sidebar-footer-1',
		'description'   => esc_html__( 'Add widgets here.', 'version_8' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Footer Center', 'version_8' ),
		'id'            => 'sidebar-footer-2',
		'description'   => esc_html__( 'Add widgets here.', 'version_8' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Footer Right', 'version_8' ),
		'id'            => 'sidebar-footer-3',
		'description'   => esc_html__( 'Add widgets here.', 'version_8' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Load After Content', 'version_8' ),
		'id'            => 'sidebar-active-1',
		'description'   => esc_html__( 'Add here.', 'version_8' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
add_action( 'widgets_init', 'version_8_widgets_init' );


/**
 * ENQUEUE SCRIPTS AND STYLES
 * 1)put this into the functions.php file and replace the enqueue script function
 * 2)create a new style-v7.css file with the true theme style
 * 3)uncomment the add_action line
 *
 * @link https://developer.wordpress.org/themes/basics/including-css-javascript/#stylesheets
 */
if ( ! function_exists( 'version_8_scripts' ) ) :
function version_8_scripts() {
	//first style sheet is the foundation from _s
	wp_enqueue_style( 'foundation-style', get_stylesheet_uri() );

	//last style sheet is the actual style for the site
	wp_register_style( 'version_8-style', get_stylesheet_directory_uri() . '/style-version_8.css', NULL , NULL , 'all' );
	wp_enqueue_style( 'version_8-style', get_stylesheet_directory_uri() . '/style-version_8.css' );

	wp_enqueue_script( 'version_8-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '201802', true );

	wp_enqueue_script( 'version_8-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '201802', true );

	//AJAX
	// register your script location, dependencies and version
	//wp_register_script( 'version_8-AJAX', get_template_directory_uri() . '/js/version_8_ajax.js', array('jquery'), false, true );
	// enqueue the script
	//wp_enqueue_script('version_8-AJAX');
	// localize the script for proper AJAX functioning
	//wp_localize_script( 'version_8-AJAX', 'theurl', array('ajaxurl' => admin_url( 'admin-ajax.php' )));

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'version_8_scripts' );
endif;


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}



/**
 * LOAD CUSTOM INCLUDED FILE
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */
require get_template_directory() . '/inc/version_8_function.php';
