<?php

/*
Plugin Name: GuRuStu Mailchimp Signup
Description: Allows the easy creation of mailchimp widgets.
Version: 1
Author: The GuRuStu Group
Author URI: http://gurustugroup.com
*/


/**
 * Adds GuRuStu_Mailchimp_Widget widget.
 */
class GRS_Mailchimp_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'grs_mailchimp_widget', // Base ID
			'GuRuStu Mailchimp Signup', // Name
			array( 'description' => __( 'A Mailchimp signup Widget', 'text_domain' ), ) // Args
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
		
		// We encode the widget's instance ID in the form so we can potentially have
		// multiple signup widgets for different lists.
		$widgetIdComponents = explode("-",$args['widget_id']);
		
		?>


		<li class="mailchimp-widget">
			<h2><?php echo $instance['title']; ?></h2>
			<p><?php echo $instance['caption']; ?></p>
			<form id="newsletter-signup">
				<input type="hidden" name="action" value="grs_mailchimp">				
				<input type="hidden" name="widget_id" value="<?php echo $widgetIdComponents[1]; ?>">
				<input type="text" placeholder="Email" name="email"/>
				<button class="button" type="submit">Submit</button>
				<div class="clearfix"></div>
			</form>
		</li>

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
		foreach (array('title','list_id','caption','api_key','submit_url') as $field) {
			$instance[$field] = strip_tags( $new_instance[$field]);
		}

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
		<?php foreach (array('title'=>'Title','api_key'=>'API Key','list_id'=>'List ID','submit_url'=>'Submit URL') as $field => $title): ?>
		<p>
			<label for="<?php echo $this->get_field_id( $field ); ?>"><?php _e( $title . ':' ); ?></label> 
			<input type="text" id="<?php echo $this->get_field_id( $field ); ?>" name="<?php echo $this->get_field_name( $field ); ?>" value="<?php if (isset($instance[$field])) echo $instance[$field]; ?>" >	
		</p>
		<?php endforeach; ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'caption' ); ?>"><?php _e( 'Caption:' ); ?></label> 
			<textarea id="<?php echo $this->get_field_id( 'caption' ); ?>" name="<?php echo $this->get_field_name( 'caption' ); ?>"><?php if (isset($instance['caption'])) echo $instance['caption']; ?></textarea>	
		</p>
		<?php 
	}

} // class 


add_action( 'widgets_init', create_function( '', 'register_widget( "grs_mailchimp_widget" );' ) );


function getRealIpAddr(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      //check ip from share internet
	  $ip=$_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	  //to check ip is pass from proxy
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function mailchimp_signup() {
	$widget = get_option('widget_grs_mailchimp_widget');
	$apiKey = $widget[$_REQUEST['widget_id']]['api_key'];
	$listID = $widget[$_REQUEST['widget_id']]['list_id'];
	$submit_url = $widget[$_REQUEST['widget_id']]['submit_url'];
	$email = $_REQUEST['email'];
	
	$double_optin=false;
	$update_existing=false;
	$replace_interests=true;
	$send_welcome=false;
	$email_type = 'html';
	
	$ip = getRealIpAddr();
	
	
	$merges = array(
		'OPTINIP'=>$ip
	
	);
	
	$dataToSend = array(
		'email_address' => $email,
		'apikey' => $apiKey,
		'merge_vars' => $merges,
		'id' => $listID,
		'double_optin' => $double_optin,
		'update_existing' => $update_existing,
		'replace_interests' => $replace_interests,
		'send_welcome' => $send_welcome,
		'email_type' => $email_type
	);
	$payload = json_encode($dataToSend);
	 
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $submit_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));
	 
	$result = curl_exec($ch);
	curl_close ($ch);
	
	$dataB = json_decode($result);
	if ($dataB == "true")
	    echo "Thank you for subscribing to our newsletter.";
	else if ($dataB->code == 214)
	    echo "The email address you entered is already subscribed to our newsletter.";
	else {
	    echo "We were unable to add you to our mailing list at this time.";
	    error_log("Mailchimp error " . $dataB->code . ":" . $dataB);
	}
	exit;
}
add_action('wp_ajax_grs_mailchimp', 'mailchimp_signup');

?>