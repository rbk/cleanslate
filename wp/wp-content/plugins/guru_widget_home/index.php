<?php
/**
 * Plugin Name: Homepage Widget
 * Description: A widget that displays on the homepage
 * Version: 0.1
 * Author: Bilal Shaheen
 * Author URI: http://gearaffiti.com/about
 */


add_action( 'widgets_init', 'my_widget' );


function my_widget() {
	register_widget( 'MY_Widget' );
}

class MY_Widget extends WP_Widget {

	function MY_Widget() {
		$widget_ops = array( 'classname' => 'home-widget', 'description' => __('A widget that displays the newest article ', 'home-widget') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'home-widget' );
		
		$this->WP_Widget( 'home-widget', __('Homepage Widget', 'home-widget'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		
		extract( $args );

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		
		$primary_text   = $instance['primary_text'];
		$secondary_text = $instance['secondary_text'];
		$body_icon      = $instance['body_icon'];
		$page_url       = $instance['page_url'];
		$page_url_off_site = $instance['page_url_off_site'];

		if( ! empty( $page_url_off_site ) ) {
			$target == '_blank';
		}
		
		echo $before_widget;
		
		$slug = str_replace(' ', '-', strtolower($title));
		?>
		<section class="<?php echo $slug; ?>"> 
			
			<?php
			// Display the widget title 
			if ( $title )
				echo $before_title . '<a href="'.$page_url.'" class="btn">' . $title . '</a>' . $after_title;
				
			?>
		    
		    <p class="primary"><?php echo $primary_text; ?></p>
		    
		    <div class="icon">
		    	<a target="<?php echo $target; ?>" href="<?php echo $page_url; ?>"><img src="<?php echo $body_icon; ?>" alt="<?php echo $title; ?>" /></a>
		    </div>
		    
		    <p class="secondary"><?php echo $secondary_text; ?></p>
		    
		</section>
		<?php
		
		echo $after_widget;
	}

	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
	
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		$instance['primary_text'] = $new_instance['primary_text'];
		$instance['secondary_text'] = $new_instance['secondary_text'];
	
		$instance['page_url'] = $new_instance['page_url'];
		$instance['page_url_off_site'] = $new_instance['page_url_off_site'];

		$instance['body_icon'] = $new_instance['body_icon'];
		
		return $instance;
	}

	
	function form( $instance ) {

		//Set up some default widget settings.
		//$defaults = array( 'title' => __('kipp_widget', 'kipp_widget'), 'name' => __('Bilal Shaheen', 'kipp_widget'), 'show_info' => true );
		
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		$plugin_dir_path = dirname(__FILE__);
		?>
		
		<style type="text/css">
			
			.kipp_widget label{
				
				
			}
			
			.kipp_widget textarea, .kipp_widget input, .kipp_widget select{
				
			
			}
		</style>
		<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url( __FILE__ ); ?>shadowbox.css">
		<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ); ?>shadowbox.js"></script>
		<script type="text/javascript">
		
		
		var fileInput = '';
		
		Shadowbox.init({
		    // let's skip the automatic setup because we don't have any
		    // properly configured link elements on the page
		    skipSetup: true
		});
		
		jQuery().ready( function(){
			
			jQuery('#kipp_widget_media').live( 'click', function(e) {
				
				e.preventDefault();
				
				fileInput = jQuery('#kipp_widget_media');
				
			    Shadowbox.open({
			        content:    'media-upload.php?type=image&amp;TB_iframe=true',
			        title:      "Media Library",
			        player:     'iframe',
			        height:     600,
			        width:      700
			    });

			    window.original_send_to_editor = window.send_to_editor;
			    
			    window.send_to_editor = function(html) {
			        
			        if (fileInput) {
			        	
			        	fileurl = jQuery('img', html).attr('src');
			        	
			        	if (!fileurl) {
			        		fileurl = jQuery(html).attr('src');
			        	}
			        	
			        	jQuery('#kipp_widget_media, .hidden-body-icon').val(fileurl);
			        	
			        	Shadowbox.close();
			        	
			        } else {
			        
			        	window.original_send_to_editor(html);
			        }
			    };
						    
			    return false;
			});
			

		});
		</script>
		
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'kipp_widget'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'primary_text' ); ?>"><?php _e('Primary Text:', 'kipp_widget'); ?></label>
				<textarea id="<?php echo $this->get_field_id( 'primary_text' ); ?>" name="<?php echo $this->get_field_name( 'primary_text' ); ?>" class="widefat"><?php echo $instance['primary_text']; ?></textarea>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'secondary_text' ); ?>"><?php _e('Secondary Text:', 'kipp_widget'); ?></label>
				<textarea id="<?php echo $this->get_field_id( 'secondary_text' ); ?>" name="<?php echo $this->get_field_name( 'secondary_text' ); ?>" class="widefat"><?php echo $instance['secondary_text']; ?></textarea>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'page_url' ); ?>"><?php _e('Link Widget To:', 'kipp_widget'); ?></label>
				<select id="<?php echo $this->get_field_id( 'page_url' ); ?>" name="<?php echo $this->get_field_name( 'page_url' ); ?>" class="widefat">

					<optgroup label="Posts">
					<?php
					$arPosts = get_post_list();
					
					foreach($arPosts as $postKey => $post){
						
						$bCur = ($instance['page_url'] == get_permalink( $postKey ) )?' selected="selected"':null;
						
						echo '<option value="'. get_permalink($postKey).'" '.$bCur.'>'.$post.'</option>'."\n";
					}
					?>
					</optgroup>

					<optgroup label="Pages">
					<?php
					$arPages = get_page_list();
					
					foreach($arPages as $pageKey => $page){
						
						$bCur = ($instance['page_url'] == get_permalink($pageKey) )?' selected="selected"':null;
						
						echo '<option value="'. get_permalink( $pageKey ).'" '.$bCur.'>'.$page.'</option>'."\n";
					}
					?>
					</optgroup>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'page_url_off_site' ); ?>"><?php _e('Optionally link off site:', 'kipp_widget'); ?></label>
				<input id="<?php echo $this->get_field_id( 'page_url_off_site' ); ?>" name="<?php echo $this->get_field_name( 'page_url_off_site' ); ?>" class="widefat" />
			</p>
			<p>
				<label for="kipp_widget_media"><?php _e('Icon:', 'kipp_widget'); ?></label>
				<input id="kipp_widget_media" name="kipp_widget_media" value="<?php echo $instance['body_icon']; ?>" class="widefat" />
				
				<input type="hidden" class="hidden-body-icon" id="<?php echo $this->get_field_id( 'body_icon' ); ?>" name="<?php echo $this->get_field_name( 'body_icon' ); ?>" value="<?php echo $instance['body_icon']; ?>" />
			</p>			
			
		
	<?php
	}
}

function get_post_list(){
	
	$arOptions = array();
	
	$posts = get_posts(array(
	   'numberposts' => -1,
	   'post_type' => 'post',
	   'order' => 'ASC',
	   'orderby' => 'title'
	));
	
	foreach($posts as $k => $v){
		$arOptions[$v->ID] =  $v->post_title;	
	}
	
	return $arOptions;
}

function get_page_list(){
	
	$arOptions = array();
	
	$posts = get_pages(array(
	   'numberposts' => -1,
	   'post_type' => 'page',
	   'order' => 'ASC',
	   'orderby' => 'title'
	));
	
	foreach($posts as $k => $v){
		$arOptions[$v->ID] =  $v->post_title;	
	}
	
	return $arOptions;
}	
?>