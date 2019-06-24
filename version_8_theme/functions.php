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
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on version_8, use a find and replace
		 * to change 'version_8' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'version_8', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		// @link https://developer.wordpress.org/reference/functions/register_nav_menus/
		register_nav_menus( array(
			'modal' => __( 'Modal', 'version_8' ),
			'header-1' => __( 'Header-1', 'version_8' ),
			'header-2' => __( 'Header-2', 'version_8' ),
			'footer-1' => __( 'Footer-1', 'version_8' ),
			'footer-2' => __( 'Footer-2', 'version_8' ),
		) );

		/*
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

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
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
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'version_8_content_width', 640 );
}
add_action( 'after_setup_theme', 'version_8_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 * @version 8.3.1906
 * @since 8.3.1906
 */
if ( ! function_exists( 'version_8_widgets_init' ) ) :
function version_8_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Default', 'version_8_child' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'version_8_child' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Header', 'version_8_child' ),
		'id'            => 'sidebar-header',
		'description'   => esc_html__( 'Before the menu.', 'version_8_child' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Header - 2', 'version_8_child' ),
		'id'            => 'sidebar-header-2',
		'description'   => esc_html__( 'After the menu.', 'version_8_child' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Left', 'version_8_child' ),
		'id'            => 'sidebar-left',
		'description'   => esc_html__( 'Left side of page.', 'version_8_child' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Right', 'version_8_child' ),
		'id'            => 'sidebar-right',
		'description'   => esc_html__( 'Right side of page.', 'version_8_child' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'version_8_child' ),
		'id'            => 'sidebar-footer',
		'description'   => esc_html__( 'Before the menu.', 'version_8_child' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer - 2', 'version_8_child' ),
		'id'            => 'sidebar-footer-2',
		'description'   => esc_html__( 'After the menu.', 'version_8_child' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Modal', 'version_8_child' ),
		'id'            => 'sidebar-modal',
		'description'   => esc_html__( 'The modal area. Before the menu.', 'version_8_child' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Modal - 2', 'version_8_child' ),
		'id'            => 'sidebar-modal-2',
		'description'   => esc_html__( 'The modal area. After the menu.', 'version_8_child' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'version_8_widgets_init', 20 );
endif;


/**
 * REGISTER SCRIPTS AND STYLES
 *
 * done early, can be overwritten by child theme
 * wp_register_style( string $handle, string|bool $src, array $deps = array(), string|bool|null $ver = false, string $media = 'all' )
 * wp_register_script( string $handle, string|bool $src, array $deps = array(), string|bool|null $ver = false, bool $in_footer = false )
 *
 * @link https://developer.wordpress.org/themes/basics/including-css-javascript/#stylesheets
 * @version 8.3.1906
 * @since 8.3.1906
 */
if ( ! function_exists( 'version_8_register_scripts' ) ) :
function version_8_register_scripts() {
	//
	wp_register_script( 'version_8-style_foundation', get_template_directory_uri() . '/style.css' );
	wp_register_script( 'version_8-navigation', get_template_directory_uri() . '/js/navigation.js', array(), false, true );
	wp_register_script( 'version_8-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), false, true );
}
add_action( 'init', 'version_8_register_scripts' );
endif;
/**
 * ENQUEUE SCRIPTS AND STYLES
 *
 * can be overwritten by child theme
 * wp_enqueue_style( string $handle, string $src = '', array $deps = array(), string|bool|null $ver = false, string $media = 'all' )
 * wp_enqueue_script( string $handle, string $src = '', array $deps = array(), string|bool|null $ver = false, bool $in_footer = false )
 *
 * @link https://developer.wordpress.org/themes/basics/including-css-javascript/#stylesheets
 * @version 8.3.1906
 * @since 8.3.1906
 */
if ( ! function_exists( 'version_8_enqueue_scripts' ) ) :
function version_8_enqueue_scripts() {
	//
	wp_enqueue_style( 'version_8-style_foundation', get_stylesheet_uri() );
	wp_enqueue_script( 'version_8-navigation' );
	wp_enqueue_script( 'version_8-skip-link-focus-fix' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'version_8_enqueue_scripts' );
endif;

/**
 * URL query parameters/variables let WP know ahead of time to avoid errors
 *
 * @link
 * @version 8.3.1906
 * @since 8.3.1906
 */
if ( ! function_exists( 'version_8_add_query_param' ) ) :
function version_8_add_query_param($param) {
	$param[] = "surl"; // URl param
	return $param;
}
//add_filter('query_vars', 'version_8_add_query_param');
endif;


/**
 * run shortcode inside text widgets
 *
 * @link https://dannyvankooten.com/enabling-shortcodes-in-widgets-quick-wordpress-tip/
 * @version 8.3.1906
 * @since 8.3.1906
 */
add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode', 11);


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
 * Security related functions
 */
require get_template_directory() . '/inc/security.php';

/**
 * generic php functions
 */
require get_template_directory() . '/inc/generic.php';