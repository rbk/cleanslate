<?php
/*
Plugin Name: Guru Settings
Plugin URI: http://www.gurustugroup.com/
Description: Handles common settings and options
Version: 0.1
Author: GuRuStu Group
Author URI: http://www.gurustugroup.com/
License: A "Slug" license name e.g. GPL2
*/

$arPages = array(
	
	'general' => array(
		'title' => 'General',
		'description' => 'Contact Information etc&hellip;'
	),
	'social' => array(
		'title' => 'Social',
		'description' => 'Manage Your Social Network Settings'
	),
	'map_options' => array(
		'title' => 'Map Options',
		'description' => 'Change Your Map Settings'
	),
	'more_options' => array(
		'title' => 'More Options',
		'description' => ''
	)
);

$arFields = array(
	
	'general' => array(
		'email' => array(
			'type' => 'text',
			'title' => 'Primary Email'
		),
		'phone' => array(
			'type' => 'text',
			'title' => 'Phone Number'
		),
		'fax' => array(
			'type' => 'text',
			'title' => 'Fax'
		),
		'address' => array(
			'type' => 'text',
			'title' => 'Primary Address'
		),
		'hours' => array(
			'type' => 'text',
			'title' => 'Hours'
		)
	),
	'social' => array(
		
		'linkedin' => array(
			'type' => 'text',
			'title' => 'Linkedin'
		),	
		'flickr' => array(
			'type' => 'text',
			'title' => 'Flickr'
		),		
		'pinterest' => array(
			'type' => 'text',
			'title' => 'Pinterest'
		),	
		'twitter' => array(
			'type' => 'text',
			'title' => 'Twitter'
		),	
		'facebook' => array(
			'type' => 'text',
			'title' => 'Facebook'
		)	
	),
	'map_options' => array(
		'google_api_key' => array(
			'type' => 'text',
			'title' => 'Google Maps API Key'
		),
		'location_coordinates' => array(
			'type' => 'text',
			'title' => 'Coordinates'
		)
	),
	'more_options' => array(
		
		'slide_speed' => array(
			'type' => 'text',
			'title' => 'Slider Speed'
		),
		'meta_google_analytics_code' => array(
			'type' => 'text',
			'title' => 'Google Analytics Code',
			'std' => 'UA-xxxxxxxx-x'
		)
	)
);


function guru_settings_style(){

	wp_enqueue_style('guru-styles', plugin_dir_url( __FILE__ ).'css/guru-settings.css');
}
add_action( 'admin_enqueue_scripts', 'guru_settings_style' );

// create custom plugin settings menu
add_action('admin_menu', 'guru_create_menu');

function guru_create_menu() {

	//create new top-level menu
	add_menu_page('GuRuStu Plugin Settings', 'GuRuStu Settings', 'administrator', __FILE__, 'guru_settings_page', plugins_url('/images/favicon-16.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	
	global $arFields;
	
	foreach($arFields as $key => $val){
		
		foreach($val as $iKey => $iVal){
			
			register_setting( 'guru-settings-group', 'guru_'.$iKey );
		}
		
	}
}

function guru_settings_page() {
	
	global $arFields, $arPages;
?>

<script type="text/javascript">
jQuery().ready( function($){
	
	var first = $(".side-menu ul li").get(0),
		current = $("form#guru_settings fieldset").get(0);
		
	$("a", first).addClass("current");
	$(current).fadeIn();
	
	$(".side-menu ul li a").click( function(el){
	
	    el.preventDefault();
	    
	    var currentSection = $(this).attr("href");
	    
	    $(".side-menu ul li a").removeClass("current");
	    $(this).addClass("current");
	    $("form#guru_settings fieldset").hide();
	    $("form#guru_settings fieldset" + currentSection).fadeIn();
	});
});
</script>

<div class="wrap guru-container">

	<section>
		<h2>GuRuStu Settings</h2>
	</section>
	
	<aside class="side-menu">
		<ul>
			<?php echo guru_get_pages_nav($arPages); ?>
		</ul>
	</aside>
	
	<section class="guru-content">
		<form method="post" action="options.php" id="guru_settings">
			
		    <?php settings_fields( 'guru-settings-group' ); ?>
		    <?php do_settings_sections( 'guru-settings-group' ); ?>
		    
		    <?php echo guru_get_pages($arFields, $arPages); ?>
		    
		    <p class="submit">
		    	
		   		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		    </p>
		</form>
		<div class="clearfix"></div>
	</section>
	
	<div class="clearfix"></div>
</div>
<?php 

}

function guru_get_pages_nav($arPages){
	
	if(!@count($arPages)) return false;
	
	$disp = null;
	
	foreach( $arPages as $key => $val){
	    
	    $disp .= '<li>
	    		<a href="#section-'.$key.'">'.$val['title'].'</a>
	    		<span>'.$val['description'].'</span>
	    	  </li>';
	}
	
	return $disp;	
}

function guru_get_pages($arFields = null, $arPages = null){

	if(!@count($arFields) || !@count($arPages)) return false;
	
	$disp = null;
		
	foreach( $arFields as $key => $val){
	    
	    echo '<fieldset id="section-'.$key.'">
	              <legend>'.$arPages[$key]['title'].'</legend>
	              <table class="form-table">';
	              
	    foreach( $val as $iKey => $iVal){
	    	
	    	echo '
	    	<tr valign="top">
	    	  <th scope="row">'.$iVal['title'].'</th>
	    	  <td><input type="'.$iVal['type'].'" name="guru_'.$iKey.'" value="'.get_option('guru_'.$iKey).'" /></td>
	    	</tr>';			    	
	    }
	                  
	    echo '	</table>
	         </fieldset>';			    
	}
	
	return $disp;
}
// Modifiy this as needed
function guru_get_social(){
	
	$prefix = 'guru_';
	
	$arFields = array(
		'linkedin' => 'Add us on Linkedin', 
		'flickr' => 'View Our Flickr Stream', 
		'pinterest' => 'Follow our Pins', 
		'twitter' => 'Follow us on Twitter', 
		'facebook' => 'Friend us on Facebook', 
		'email' => 'Send us a message',
		'google' => 'Plus 1'
	);
	?>
	<ul class="guru-social">
		<?php
		foreach($arFields as $key => $val){
			
			$link = get_option($prefix.$key);

			if(!empty($link) && $key != 'email' ){
				echo '<li class="'.$key.'"><a target="_blank" href="'.$link.'">'.$val.'</a></li>';
			} elseif( !empty($link) ) {
				echo '<li class="'.$key.'"><a target="_blank" href="mailto:'.$link.'">'.$val.'</a></li>';
			} else {
				
			}
		}
		?>	
	</ul>
	<?php
}
?>