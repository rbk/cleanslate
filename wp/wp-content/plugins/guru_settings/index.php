<?php
/*
Plugin Name: Guru Settings
Plugin URI: http://www.gurustugroup.com/
Description: Handles common settings and options. Includes a Google maps plugin.
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
	// 'map_options' => array(
	// 	'title' => 'Map Options',
	// 	'description' => 'Change Your Map Settings'
	// ),
	'more_options' => array(
		'title' => 'Other Options',
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
		),
		'youtube' => array(
			'type' => 'text',
			'title' => 'YouTube'
		),	
		'instagram' => array(
			'type' => 'text',
			'title' => 'Instagram'
		)	
	),
	'map_options' => array(
		'google_api_key' => array(
			'type' => 'text',
			'title' => 'Google Maps API Key'
		),
		'map_address' => array(
			'type' => 'text',
			'title' => 'Address'
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

/*

 Ideas: 
 	-Register activation hook that creates a home page and contact page. Also the hook can set some basic wordpress settings.


*/


function guru_settings_styles_scripts(){

	wp_enqueue_style('guru-styles', plugin_dir_url( __FILE__ ).'css/guru-settings.css');
	wp_enqueue_script('guru-jquery-maps', plugin_dir_url( __FILE__ ).'js/map_plugin.js');
	wp_enqueue_script('guru-scripts', plugin_dir_url( __FILE__ ).'js/general_scripts.js');
	wp_enqueue_script( 'google_maps_api_v3', '//maps.googleapis.com/maps/api/js?&sensor=true', array('jquery') );

}
add_action( 'admin_enqueue_scripts', 'guru_settings_styles_scripts' );

function guru_settings_frontend_scripts(){

	wp_enqueue_script('guru-jquery-maps', plugin_dir_url( __FILE__ ).'js/map_plugin.js',array('jquery'));
	$map_api_key = get_option('guru_google_api_key');

	if( empty($map_api_key) ){
		// wp_enqueue_script( 'google_maps_api_v3', '//maps.googleapis.com/maps/api/js?&sensor=true', array('jquery') );
	} else {
		// wp_enqueue_script( 'google_maps_api_v3', '//maps.googleapis.com/maps/api/js?key=' . get_option('guru_google_api_key') . '&sensor=true', array('jquery') );
	}
}
add_action( 'wp_enqueue_scripts', 'guru_settings_frontend_scripts' );


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

	// Keep section
	var current_section = localStorage.getItem('guru_settings_section');
	if( current_section ){
		$("form#guru_settings fieldset").hide();
		$(".side-menu ul li a").removeClass("current");
		$('.side-menu ul li a[href="' + current_section + '"]').addClass("current");
		$("form#guru_settings fieldset" + current_section ).fadeIn();
	}
	
	$(".side-menu ul li a").click( function(el){
	
	    el.preventDefault();
	    
	    var currentSection = $(this).attr("href");

	    localStorage.setItem('guru_settings_section',currentSection);
	    
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
	    	// error_log( $iKey );
	    	if( $iKey == 'map_address' ){
		    	echo '
		    	<tr valign="top">
		    	  <th scope="row">'.$iVal['title'].'</th>
		    	  <td><input type="'.$iVal['type'].'" name="guru_'.$iKey.'" id="guru_'.$iKey.'" value="'.get_option('guru_'.$iKey).'" />
		    	  <input type="submit" id="geocode" value="Geocode Address"/><div id="map-preview"></div>
		    	  </td>
		    	</tr>';	
	    	} else {
		    	echo '
		    	<tr valign="top">
		    	  <th scope="row">'.$iVal['title'].'</th>
		    	  <td><input type="'.$iVal['type'].'" name="guru_'.$iKey.'" id="guru_'.$iKey.'" value="'.get_option('guru_'.$iKey).'" /></td>
		    	</tr>';			    	
	    	}
	    }
	                  
	    echo '	</table>
	         </fieldset>';			    
	}
	
	return $disp;
}
/*
 *
 * API - Add helpful functions here or just put them in the theme functions.php.
 *
 *
*/
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

function guru_map($atts, $content=null){ 

	extract( shortcode_atts( array(
		'coordinates' => '36.1562139,-95.98288109999999',
		'id' => 'map_' . mt_rand(),
		'height' => '200',
		'zoom' => '4'
	), $atts ) );
	?>
	<style type="text/css">
		#<?php echo $atts["id"]; ?> {
			max-height: <?php echo $atts['height'];?>px;
			padding-top: 50%;
		}
		iframe {
			max-width: 100% !important;
		}
	
	</style>
	<div id="<?php echo $atts['id']; ?>"></div>
	<a target="_blank" href="http://maps.google.com/maps?daddr=<?php echo urlencode(get_option('guru_map_address'));?>">Get directions</a><br/>
	<script>
		jQuery(document).ready(function($){
			$('#<?php echo $atts["id"]; ?>').googleMap({
				'coordinates' : '<?php echo $atts["coordinates"];?>',
				'zoom' : <?php echo $atts["zoom"];?>,
				'infobox' : false
			});
		})
	</script>
<?php
}
add_shortcode( 'location', 'guru_map' );

// Function adds GA tracking code to footer
function gurustu_google_analytics(){

	$ga_tracking = get_option('guru_meta_google_analytics_code');
	if( $ga_tracking ):

	?>
	<script>

		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $ga_tracking; ?>']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();

	</script>

	<?php
	endif;
	
}

?>