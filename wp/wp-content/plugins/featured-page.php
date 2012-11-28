<?php

/*
Plugin Name: GuRuStu Featured Page Widget
Description: Provides a widget to show featured pages.
Version: 1
Author: The GuRuStu Group
Author URI: http://gurustugroup.com
*/


/**
 * Adds Featured_Pages_Widget widget.
 */
class Featured_Pages_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'grs_featured_pages_widget', // Base ID
			'Featured Page', // Name
			array( 'description' => __( 'A Featured Page Widget', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;

		?>
		<?php $page = get_post($instance['page']); ?>
		<?php		
		if ($instance['title'])
			$title = $instance['title'];
		else
			$title = $page->post_title;

		?>
		<a href="<?php echo get_permalink($instance['page']); ?>"><div><h2><?php echo $title; ?></h2></a>
		<?php MultiPostThumbnails::the_post_thumbnail('page', 'featured-page-widget', $page->ID); ?>
		<div class="excerpt"><p class="excerpt"><?php echo $page->post_excerpt; ?></p></div>
		<span class="read_more"><a id="button" href="<?php echo get_permalink($instance['page']); ?>">Learn More</a></span>		
		

		<?php

		
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['page'] = strip_tags( $new_instance['page'] );
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		query_posts(array('showposts' => -1, 'post_type' => 'page')); ?>
		<p>
		<label for="<?php echo $this->get_field_id( 'page' ); ?>"><?php _e( 'Featured Page:' ); ?></label> 
		<select class="widefat" id="<?php echo $this->get_field_id( 'page' ); ?>" name="<?php echo $this->get_field_name( 'page' ); ?>">	
			<?php while (have_posts()) : the_post(); ?>
				<option <?php if ($instance['page'] == get_the_ID()) echo "selected"; ?> value="<?php the_ID(); ?>"><?php the_title(); ?></option>
			<?php endwhile; 
			wp_reset_query();  // Restore global post data		?>
		</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Custom title (optional):' ); ?></label> 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>">	
		</p>
		<?php 
	}

} // class 


add_action( 'widgets_init', create_function( '', 'register_widget( "featured_pages_widget" );' ) );

?>