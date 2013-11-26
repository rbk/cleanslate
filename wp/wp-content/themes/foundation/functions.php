<?php
	/**
	 * @package WordPress
	 * @subpackage Gurustu
	 * @since Gurustu
	 */
	/*
	 *
	 * OK, remove theme parents scripts and add ours
	 * Scripts should be minified and put into single file as long as the file in less than 40kb
	 *
	*/
	function gurustu_enqueue_scripts(){
		if ( !is_admin() ) {
			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', ( "//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ), false);
			wp_enqueue_script( 'jquery' );
			wp_enqueue_style( 'main-theme-style', get_stylesheet_directory_uri() . '/css/application.css' );
			
			// Use a lighter version of modernizr for production
    		wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/modernizr.custom.full.js' );
    		wp_enqueue_script('plugins', get_template_directory_uri() . '/js/plugins.js', '', array('jquery'), true );
    		wp_enqueue_script('common-js', get_template_directory_uri() . '/js/common.js', '', array('jquery'), true );
    		wp_enqueue_script('jquery-masonry-1', get_template_directory_uri() . '/js/jquery.masonry.js', '', array('jquery'), true );

		}
		// if you need fancy box...
		// wp_enqueue_script('fancybox', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.pack.js' );
    	// wp_enqueue_script('fancybox-media', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-media.js' );
    	// wp_enqueue_style('fancybox-css', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.css' );
	}
	add_action( 'wp_enqueue_scripts', 'gurustu_enqueue_scripts' );
	/*
	*
	*
	* Add ajax url to frontend, just in case we need it
	*
	*/ 
	function gurustu_add_ajax_url_to_frontend() {

		wp_enqueue_script( 'gurustu_frontend_ajax_scripts', get_template_directory_uri() . '/js/custom_ajax.js', array('jquery') );
		wp_localize_script( 'gurustu_frontend_ajax_scripts', 'guru_ajaxurl', array('ajaxurl' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'guru_nounce' ) ) );

	}
	// add_action( 'wp_enqueue_scripts', 'gurustu_add_ajax_url_to_frontend' );
	/*
	 *
	 * Theme Setup (based on twentythirteen: http://make.wordpress.org/core/tag/twentythirteen/)
	 *
	*/
	function gurustu_setup() {
		add_theme_support( 'menus' );
		add_theme_support( 'post-thumbnails' );
		load_theme_textdomain( 'gurustu', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );	
		register_nav_menu( 'primary', __( 'Navigation Menu', 'gurustu' ) );
		add_post_type_support( 'page', 'excerpt' );
	}
	add_action( 'after_setup_theme', 'gurustu_setup' );
		/*
	 *
	 * Custom Image Sizes
	 *
	*/
	if ( function_exists( 'add_image_size' ) ) { 
		// add_image_size( 'category-thumb', 300, 9999 ); //300 pixels wide (and unlimited height)
		// add_image_size( 'sub-slide-thumb', 265, 162, true ); //(cropped)
		// add_image_size( 'sub-slide-main', 450, 300, true ); //(cropped)
	}
	/*
	 *
	 * Not sure why we are removing these from the head.
	 *
	*/
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }
    add_action('init', 'removeHeadLinks');
	/*
	 *
	 * Widgets
	 *
	*/
	function gurustu_widgets_init() {
		register_sidebar( array(
			'name'          => __( 'Sidebar Widgets', 'gurustu' ),
			'id'            => 'sidebar-primary',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
		register_sidebar(array(
			'name'          => __( 'Footer', 'gurustu' ),
			'id'            => 'footer-widgets',
			'description'   => '',
			'class'         => '',
			'before_widget' => '<div class="fourth">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => '</h2>'
		));
	}
	add_action( 'widgets_init', 'gurustu_widgets_init' );

	/*
	 *
	 * Post Navigation function
	 *
	*/
	function post_navigation() {
		echo '<div class="navigation">';
		echo '	<div class="next-posts">'.next_posts_link('&laquo; Older Entries').'</div>';
		echo '	<div class="prev-posts">'.previous_posts_link('Newer Entries &raquo;').'</div>';
		echo '</div>';
	}
	/*
	 *
	 * Custom Posted on function
	 *
	*/
	function posted_on() {
		printf( __( '<span class="sep">Posted </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a> by <span class="byline author vcard">%5$s</span>', '' ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_author() )
		);
	}

	/*
	 *
	 * Add editor style
	 *
	*/
	function guru_editor_style() {
		add_editor_style( get_template_directory_uri() . '/css/application.css' );
	}
	add_action('pre_get_posts', 'guru_editor_style');
	/*
	 *
	 * More functions, trying to figure out the best to organize these
	 *
	*/
	function theme_excerpt_length( $length ) {
	    return 80; // 80 words long
	}
	add_filter('excerpt_length', 'theme_excerpt_length');

	function theme_excerpt_more( $more ) {
	    global $post;
	    return '&hellip; <p><a class="read-more" href="'. get_permalink($post->ID) . '">' . __('READ MORE') . '</a><p>';
	}
	add_filter('excerpt_more', 'theme_excerpt_more');


	/*
	 *
	 *
		Uncomment to remove gallery shortcode styling
	 *
	 *
	 */ 
	// add_filter('gallery_style',
	//     create_function(
	//         '$css',
	//         'return preg_replace("#<style type=\'text/css\'>(.*?)</style>#s", "", $css);'
	//     )
	// );
	// replace gallery shortcode
	// remove_shortcode('gallery');
	// add_shortcode('gallery', 'theme_gallery_shortcode');

	// function theme_gallery_shortcode( $attr ) {
	//     global $post, $wp_locale;
	//     // create your own gallery output...
	// }


	// remove version info from head and feeds
	function complete_version_removal() {
		return '';
	}
	add_filter('the_generator', 'complete_version_removal');



	function get_topmost_parent($post_id){
		$parent_id = get_post($post_id)->post_parent;
		if($parent_id == 0){
			return $post_id;
		} else {
			return get_topmost_parent($parent_id);
		}
	}

	// Show thumbnail backend post list
	add_filter('manage_posts_columns', 'posts_columns', 5);
	add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);

	function posts_columns($defaults){
	    $defaults['riv_post_thumbs'] = __('Thumbs');
	    return $defaults;
	}
	function posts_custom_columns($column_name, $id){
	        if($column_name === 'riv_post_thumbs'){
	        echo the_post_thumbnail( array(50,50) );

	    }
	}

	function guru_get_slides(){ 
	// this function is used with jQuery Cycle 2
	?>
	<?php $slides = new WP_Query(array('post_type'=>'guru_slides')); ?>
		<?php if( $slides->found_posts > 0 ) : ?>
			<div class="main-slider">
			    
				<div class="cycle-slideshow"
					data-cycle-fx="scrollHorz"
					data-cycle-pause-on-hover="false"
					data-cycle-speed="2000"
					data-cycle-swipe="true"
					<?php
						$slider_speed = get_option('guru_slide_speed');
					?>
					data-cycle-timeout="<?php echo ( $slider_speed ) ? $slider_speed : 3000; ?>"
					data-cycle-slides=".cycle-slide"
				>
				<?php while( $slides->have_posts() ) : $slides->the_post(); ?>
						<div class="cycle-slide">
							<?php the_post_thumbnail('full'); ?>
							<div class="slide-content">
								<h3><?php the_title();?></h3>
								<?php the_excerpt();?>
								<a href="<?php the_permalink();?>" class="read-more">Read More</a>
							</div>
						</div>
				<?php endwhile; wp_reset_postdata(); ?>

				<a href="#" class="cycle-prev">&lsaquo;</a>
				<a href="#" class="cycle-next">&rsaquo;</a>

				</div>
			</div>
		<?php endif; ?>
	<?php } // End guru_get_slides


/* Remember, no extra spaces at the end of functions.php! You will spend many hours wondering why something doesn't work... */
?>