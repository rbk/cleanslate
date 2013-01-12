<?php


function cleanslate_neue_setup() {
	wp_enqueue_script('jquery','https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');
	wp_enqueue_script('plugins-scripts',get_stylesheet_directory_uri() . '/js/plugins.js');
	wp_enqueue_script('common-scripts',get_stylesheet_directory_uri() . '/js/common.js');

	// as long as this comment is here, the following probably hasn't been tested yet...
	// but it's based on this codex doc:
	// http://codex.wordpress.org/Plugin_API/Action_Reference/after_setup_theme

	// First we check to see if our default theme settings have been applied.
	$the_theme_status = get_option( 'theme_setup_status' );
	if ( $the_theme_status !== '1' ) {
		// delete first post, page, and comment
		wp_delete_post( 1, true );
		wp_delete_post( 2, true );
		wp_delete_comment( 1 );

		// Once done, we register our setting to make sure we don't duplicate everytime we activate.
		update_option( 'theme_setup_status', '1' );
	}
}

add_action( 'after_setup_theme', 'cleanslate_neue_setup' );

function setup_guru_js() {
	?>

	<script type="text/javascript">
		Guru = new Object();
		Guru.Url = '<?php bloginfo( 'url' ); ?>';
		Guru.TemplateUrl = '<?php get_stylesheet_directory_uri(); ?>';
		Guru.isFrontPage = <?php if(is_front_page()) { echo 'true'; }else{ echo 'false'; } ?>;
		Guru.wpVersion = '<?php echo trim(get_bloginfo("version")); ?>';
		Guru.postID = '<?php echo get_the_ID(); ?>';
	</script>

	<?php
}
add_action('wp_head', 'setup_guru_js',1);
add_action('admin_print_scripts', 'setup_guru_js',1);



// Completely disable comments. 

if ( ! function_exists( 'twentytwelve_comment' ) ) :

	function twentytwelve_comment( $comment, $args, $depth ) {

	}

endif;

function guru_comments_open( $open, $post_id ) {
	return false;
}
add_filter( 'comments_open', 'guru_comments_open', 10, 2 );


if( class_exists( 'NewPostType' )){

	$prefix = 'guru_';

	NewPostType::instance()->add(array(
		'post_type' => $prefix.'slides',
		'post_type_name' => 'Slides',
		'args' => array(
			'rewrite' => array( 'slug' => 'slides' ),
	        'public' => true,
			'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' )
		)	
	));
}



?>