<?php
	/**
	 * @package WordPress
	 * @subpackage Gurustu
	 * @since Gurustu
	 */
	/*
	 *
	 * OK, remove theme parents scripts and add ours
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
    		wp_enqueue_script('plugins', get_template_directory_uri() . '/js/plugins.js' );
    		wp_enqueue_script('common-js', get_template_directory_uri() . '/js/common.js' );
    		wp_enqueue_script('jquery-masonry-1', get_template_directory_uri() . '/js/jquery.masonry.js' );

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
	add_action( 'wp_enqueue_scripts', 'gurustu_add_ajax_url_to_frontend' );
	/*
	 *
	 * Options Framework (https://github.com/devinsays/options-framework-plugin)
	 *
	*/
	if ( !function_exists( 'optionsframework_init' ) ) {
		define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/options/' );
		require_once dirname( __FILE__ ) . '/options/options-framework.php';
	}
	/*
	 *
	 * Theme Setup (based on twentythirteen: http://make.wordpress.org/core/tag/twentythirteen/)
	 *
	*/
	function gurustu_setup() {
		load_theme_textdomain( 'gurustu', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );	
		// add_theme_support( 'structured-post-formats', array( 'link', 'video' ) );
		// add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'quote', 'status' ) );
		register_nav_menu( 'primary', __( 'Navigation Menu', 'gurustu' ) );
		add_theme_support( 'post-thumbnails' );
	}
	add_action( 'after_setup_theme', 'gurustu_setup' );
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
	 * Register Nav Menu
	 *
	*/
	register_nav_menu( 'primary', __( 'Navigation Menu', 'gurustu' ) );

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
	 * Custom Image Sizes
	 *
	*/
	if ( function_exists( 'add_image_size' ) ) { 
		// add_image_size( 'category-thumb', 300, 9999 ); //300 pixels wide (and unlimited height)
		add_image_size( 'sub-slide-thumb', 265, 162, true ); //(cropped)
		add_image_size( 'sub-slide-main', 450, 300, true ); //(cropped)
	}
	/*
	 *
	 * Custom Password Form for protected pages
	 *
	*/
	add_filter( 'the_password_form', 'custom_password_form' );  
	function custom_password_form() {  
		global $post;  
		$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID ); 
		$o = '<form class="protected-post-form" action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post"> 
		' . __( "" ) . ' 
		
		<label class="pass-label" for="' . $label . '">' . __( "PASSWORD:" ) . ' </label>
		
		<input name="post_password" id="' . $label . '" type="password" style="background: #ffffff; border:1px solid #999; color:#333333; padding:10px;" size="20" />

		<input type="submit" name="Submit" class="button" value="' . esc_attr__( "Submit" ) . '" />  
		
		</form>
		<p style="font-size:14px;margin:0px;"></p>  
		';

		return $o;  
	}
	/*
	 *
	 * Add editor style
	 *
	*/
	function guru_editor_style() {
		add_editor_style( 'editor-style.css' );
	}
	add_action('pre_get_posts', 'guru_editor_style');
	
	/*
	 *
	 * Custom formating in the wordpress editor
	 *
	*/
	// Register our callback to the appropriate filter
	add_filter('mce_buttons_2', 'my_mce_buttons_2');

	function my_mce_buttons_2( $buttons ) {
		array_unshift( $buttons, 'styleselect' );
		return $buttons;
	}

	// Callback function to filter the MCE settings
	function my_mce_before_init_insert_formats( $init_array ) {  
		// Define the style_formats array
		$style_formats = array(  
			// Each array child is a format with it's own settings
			array(  
				'title' => 'Column',  
				'block' => 'div',  
				'classes' => 'content-column',
				'wrapper' => true,
			)
		);  
		// Insert the array, JSON ENCODED, into 'style_formats'
		$init_array['style_formats'] = json_encode( $style_formats );  
		
		return $init_array;  
	  
	} 
	// Attach callback to 'tiny_mce_before_init' 
	add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );

	/**
	 *
	 * Second editor to pages. This can be used as a second column or side bar.
	 *
	*/
	// add_action( 'edit_page_form', 'side_column_editor' );
	// add_action( 'save_post', 'save_right_column' );

	function side_column_editor() {
		$content = get_post_meta(get_the_ID(),'_right_column',true);
		echo "<h2>Sidebar Column:</h2> ";
		echo "<p>(This will appear in the sidebar.)</p> ";
		wp_editor( $content, 'rightcolumn' );
	}
	
	function save_right_column( $post_id ) {
		if (!wp_is_post_revision($post_id))
		add_post_meta($post_id, '_right_column', $_POST['rightcolumn'], true) or update_post_meta($post_id, '_right_column', $_POST['rightcolumn']);
	}

	/*
	 *
	 Function to make sure we are on the set blog/news page, this is better than just is_home, because it test for more than just one page
	 *
	*/
	function is_blog() {
		global  $post;
		$posttype = get_post_type($post );
		return ( ((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ( $posttype == 'post')  ) ? true : false ;
	}
	/*
	 *
	 * Custom function to replace youtube link with the embed code
	 *
	*/

	function filter_sidebar_content_to_show_youtube( $content ){
		// You tube regex
		$yt_link = '@^\s*https?://(?:www\.)?(?:youtube.com/watch\?|youtu.be/)([^\s"]+)\s*$@im';

		// Check to see if we have any youtube links
		if( preg_match_all( $yt_link, $content ) ) {

			preg_match_all( $yt_link, $content, $matches );

			foreach( $matches[0] as $match ){
				$code = str_replace( 'http://www.youtube.com/watch?v=', '', $match );
				$embed_code = '<p style=""><iframe src="http://www.youtube.com/embed/' . trim($code) . '" frameborder="0" allowfullscreen></iframe></p>';
				$content = str_replace( $match, $embed_code, $content );
			}
		}
		return $content;
	}
	/*
	 *
	 * Function to retrieve content from our second editor
	 *
	*/
	function custom_sidebar_content(){

	    $sidecontent = get_post_custom( $post->ID );

		if( ! empty( $sidecontent['_right_column'][0] ) ){
			$content = $sidecontent['_right_column'][0];

			/* Lets filter this content to support easy embedding of youtube videos */
	    	$content = filter_sidebar_content_to_show_youtube( $sidecontent['_right_column'][0] );

			
			$content = wpautop( $content );
       
        	echo $content;
		}
	}
	/*
	 *
	 * More functions, trying to figure out the best to organize these
	 *
	*/

add_theme_support( 'menus' );
register_nav_menus( array('primary' => 'primary', 'secondary' => 'secondary', 'footer' => 'footer') );

add_theme_support( 'post-thumbnails' );
add_post_type_support( 'page', 'excerpt' );

function theme_excerpt_length( $length ) {
    return 80; // 80 words long
}
add_filter('excerpt_length', 'theme_excerpt_length');

function theme_excerpt_more( $more ) {
    global $post;
    return '&hellip; <p><a class="read-more" href="'. get_permalink($post->ID) . '">' . __('READ MORE') . '</a><p>';
}
add_filter('excerpt_more', 'theme_excerpt_more');


// remove gallery shortcode styling
add_filter('gallery_style',
    create_function(
        '$css',
        'return preg_replace("#<style type=\'text/css\'>(.*?)</style>#s", "", $css);'
    )
);
// replace gallery shortcode
remove_shortcode('gallery');
add_shortcode('gallery', 'theme_gallery_shortcode');

function theme_gallery_shortcode( $attr ) {
    global $post, $wp_locale;
    // create your own gallery output...
}

// remove version info from head and feeds
function complete_version_removal() {
	return '';
}
add_filter('the_generator', 'complete_version_removal');



  //WP Pages
  function guru_pagination($pages = '', $range = 3){ 
    $showitems = ($range * 2)+1;
    global $paged;
    echo '<h1 style="font-size:65px;">' . $numpages . 'test</h1>'; 
    
    if(empty($paged)) 
      $paged = 1;
    
    if($pages == '') {
      global $wp_query;
      $pages = $wp_query->max_num_pages; 
      if(!$pages){ 
        $pages = 1; 
      } 
    }
    if(1 != $pages){ 
      echo "<div class=\"pagination\"><span class=\"text\">Page ".$paged." of ".$pages."</span>";
      
      if($paged > 2 && $paged > $range+1 && $showitems < $pages) 
        echo "<a href='".get_pagenum_link(1)."' class=\"first\">&laquo; First</a>";
   
      if($paged > 1 && $showitems < $pages) 
        echo "<a href='".get_pagenum_link($paged - 1)."' class=\"prev\">&lsaquo; Previous</a>";
   
      for ($i=1; $i <= $pages; $i++){ 
        if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){ 
          echo ($paged == $i) ? 
            "<span class=\"current\">".$i."</span>":
            "<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
        } 
      } 
      if ($paged < $pages && $showitems < $pages) 
        echo "<a href=\"".get_pagenum_link($paged + 1)."\" class=\"next\">Next &rsaquo;</a>";
   
      if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) 
        echo "<a href='".get_pagenum_link($pages)."' class=\"last\">Last &raquo;</a>";
      
      echo "</div>"; 
    }
    //always clearfix
    echo '<div class="clearfix"></div>';
  }


  function pagination($pages = '', $range = 4)
{  
     $showitems = ($range * 2)+1;  
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   
 
     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
         echo "</div>\n";
     }
}

// Register slides post type
if( class_exists( 'NewPostType' )){

  $prefix = 'guru_';

  NewPostType::instance()->add(array(
    'post_type' => $prefix.'slides',
    'post_type_name' => 'Slide',
    'args' => array(
		'rewrite' => array( 'slug' => 'slides' ),
		'public' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' )
    	)
    ));

  // NewPostType::instance()->add(array(
  //   'post_type' => $prefix.'sub-slides',
  //   'post_type_name' => 'Sub-slide',
  //   'args' => array(
  //         'rewrite' => array( 'slug' => 'sub-slides' ),
  //         'public' => true,
  //     'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' )
  //   )
  //   ))->add_meta_box(array(
  //    'id' => $prefix.'get_page_link',
  //    'title' => 'SLIDE LINKS TO:',
  //    'context' => 'normal',
  //    'priority' => 'default',
  //    'fields' => array(
  //        array(
  //            'name' => 'Link: ',
  //            'id' => $prefix . 'page',
  //            'type' => 'select',
  //            'options' => get_page_and_post_list()
  //        )
  //    ) 
  // ));

  

  if (class_exists('MultiPostThumbnails')) {
        new MultiPostThumbnails(
            array(
                'label' => 'Thumbnail 265 X 158 (optional)',
                'id' => 'slide-image-small',
                'post_type' => 'guru_sub-slides'
            )
        );
  }


} // end if new post type exists


//
//  Meta Box (Class included in new post type plugin)
//
if( class_exists( 'MetaBoxTemplate' )){
  $pageMeta = new MetaBoxTemplate(array(
          'page' => 'page',
          'id' => 'read-more-link',
          'title' => 'Custom Read More Link',
          'context' => 'normal',
          'priority' => 'core',
          'fields' => array(
            array(
              'name' => 'Read more text: ',
              'id' => 'read',
              'type' => 'text',
              'std' => 'Read More'
            )
          )
        ));
        
}


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