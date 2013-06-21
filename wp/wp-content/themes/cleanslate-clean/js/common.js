/*
 *
 * Add custom javascript.
 * Don't get too crazy and use comments.
 * 
 *
*/
jQuery(document).ready(function($){
	
	// equalWidthTopNavItems();

});

function equalWidthTopNavItems(){
	// Have the top nav links resize to fit the screen all the time. 
	var menu_items = $('nav.access li');
	var menu_count = menu_items.length;
	menu_items.css({'width': (100 / menu_count) + '%' });
}

