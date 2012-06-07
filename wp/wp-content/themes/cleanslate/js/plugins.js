// place any jQuery/helper plugins in here, instead of separate, slower script files.


/*
 * Try/Catch the console
 */
try{
    console.log('Hello Console.');
} catch(e) {
    window.console = {};
    var cMethods = "assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(",");
    for (var i=0; i<cMethods.length; i++) {
        console[ cMethods[i] ] = function(){};
    }
}

(function($) {
	$("#newsletter-signup").live("submit",function(event) {
		event.preventDefault();
		if (!/\S+@\S+\.\S+/.test($(this).find("[name=email]").val())) {
			alert("Please enter your email address");
			return;
		}
		 $.ajax({
			type:'POST',
			url: Guru.Url + "/wp/wp-admin/admin-ajax.php", 
			data: $(this).serialize(),
			cookie: encodeURIComponent(document.cookie),
			success:  function(str){
			      alert(str);
			}
		});		
	});
})(jQuery);





