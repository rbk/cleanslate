<?php
/**
 * underscores functions and definitions
 *
 * @package underscores
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'underscores_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function underscores_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on underscores, use a find and replace
	 * to change 'underscores' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'underscores', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'underscores' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'underscores_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	add_editor_style( get_template_directory_uri() . '/css/app.css' );
}
endif; // underscores_setup
add_action( 'after_setup_theme', 'underscores_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function underscores_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'underscores' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'underscores_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function underscores_scripts() {
	if ( !is_admin() ) {
		// LETS LOAD JQUERY FROM GOOGLE IN THE HEADER
		wp_deregister_script('jquery');
		// wp_register_script('jquery', ("//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"), false);
		// wp_enqueue_script('jquery');
	}
	
	wp_enqueue_script('underscores-plugins', get_template_directory_uri() . '/js/plugins.js', array(), '20120206', true );
	wp_enqueue_script( 'underscores-common.js', get_template_directory_uri() . '/js/common.js', array(), '20120206', true );
	wp_enqueue_script( 'underscores-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'underscores-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	// Live Reload
	$host = $_SERVER['HTTP_HOST'];
	if( $host == 'gurustudev.com' ){
		wp_enqueue_script( 'livereload', 'http://gurustudev.com:35729/livereload.js', array(), '20130115', false );
	} else if( $host == 'localhost' ) {
		wp_enqueue_script( 'livereload', 'localhost:35729/livereload.js', array(), '20130115', false );
	}



	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		// uncomment if you need comments
		// wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'underscores_scripts' );

// Sample custom post type
// Source: https://github.com/mboynes/super-cpt
if( class_exists( 'Super_Custom_Post_Type' ) ){
	$movies = new Super_Custom_Post_Type( 'movie' );
	$movies->set_icon( 'film' );
}

// Show SEO box last
add_filter( 'wpseo_metabox_prio', function() { return 'low';});

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
