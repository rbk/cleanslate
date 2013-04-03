<?php function guru_use_iframe(){ 

 include "empty-header.php"; ?>
 
	<script type="text/javascript">

		jQuery(document).ready(function($){
		
			var panelLinks = $('.button-list a');

			$('.button-list a').click(function(){

				$(this).each(function(){
					panelLinks.removeClass('active');
				});

				$(this).addClass('active');

				var iframeWidth = $('#iframe').width();
				var newSize = $(this).attr('iframe-data');

				if( parseInt(newSize) == 100 ) {
					$('#iframe').stop().animate({width: '100%' });
				} else {
					if( iframeWidth != parseInt(newSize) ){
						$('#iframe').stop().animate({width: newSize }, 'slow');
					}
				}
			});
			var maxWidth = $(window).width();
			$('#iframe').attr('width', maxWidth);
			var maxHeight = $(window).height();
			$('iframe').attr('height', maxHeight- 1);

			$('.rsp-hide').click(function(){
				$('#rsp-frame-ctrl-panel .button-list').fadeOut(function(){
					$('.rsp-show').fadeIn();
				});
			});
			$('.rsp-show').click(function(){
				$('#rsp-frame-ctrl-panel .button-list').fadeIn('slow');
				$('.rsp-show').hide();
			});

			$(window).resize(function(){
				$('iframe').css({height: $(window).height() });
			});

		});

	</script>
	<div id="rsp-frame-ctrl-panel">
		<ul class="button-list">
			<li><a href="#" iframe-data="100" class="rsp-frame-100 active">100%</a></li>
			<li><a href="#" title="13&#34; Mac Book"iframe-data="1280">1280px</a></li>
			<!-- <li><a href="#" title="desktop" iframe-data="960">960px</a></li> -->
			<li><a href="#" title="Small Tablet" iframe-data="768">720px</a></li>
			<li><a href="#" title="Mobile Phone" iframe-data="480">480px</a></li>
			<li><a href="#" title="IPHONE" iframe-data="320">320px</a></li>
			<li><a href="#" class="rsp-hide">Hide</a></li>
		</ul>
		<a href="#" style="display:none;" class="rsp-show active">show</a>
	</div>

	<div id="iframe" style="margin:0 auto;">
		<iframe width="100%" height="" src="<?php echo bloginfo('url'); ?>/?url=dev"></iframe>
	</div>
</body>
</html>
<?php 
	exit();

	} // end function
function guru_iframe_links(){ ?>
		<style type="text/css">
			body {
				display: none;
			}
		</style>

		<script type="text/javascript">
		jQuery(document).ready(function($){
			var links = $("a");
			links.not( $('#rsp-frame-ctrl-panel .button-list a') ).each(function(){
				var href = $(this).attr("href");
				$(this).attr("href", href + "?url=dev");
			});
			$('body').fadeIn();
		});
		</script>

<?php } ?>