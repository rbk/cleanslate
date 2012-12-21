<?php


function cleanslate_neue_setup() {
	wp_enqueue_script('jquery','https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');
	wp_enqueue_script('plugins-scripts',get_stylesheet_directory_uri() . '/js/plugins.js');
	wp_enqueue_script('common-scripts',get_stylesheet_directory_uri() . '/js/common.js');
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



// Completely disable comments. 

if ( ! function_exists( 'twentytwelve_comment' ) ) :

	function twentytwelve_comment( $comment, $args, $depth ) {

	}

endif;

function guru_comments_open( $open, $post_id ) {
	return false;
}
add_filter( 'comments_open', 'guru_comments_open', 10, 2 );
?>