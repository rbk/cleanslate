<?php
/**
 * @package WordPress
 * @subpackage HTML5-Reset-Wordpress-Theme
 * @since HTML5 Reset 2.0
 */
?>
<div class="clearfix"></div>
</div> <!-- end wrap -->
	<div class="wrap">
	<div id="container" class="js-masonry" data-masonry-options='{"itemSelector": "article" }'>
		<article class="third">Lorem ipsum dolor sit amet, conseceiusmod tempor incididunt ut labore et dolore magna aliqua. Ut eni</article>	
		<article class="third">Lorem ipsum dolor sit amet, conset labore et dolore magna aliqua. Ut eni</article>
		<article class="third">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut eni</article>	
		<article class="third">
			Lorem ipsum dolor sit amet, consectetur adipisicinr incididunt ut labore 
			et dolore magna aliqua. Ut enpsum dolor sit amet, consectetur adipisicinr incididunt ut labore 
			et dolore magna aliqua. Ut enpsum dolor sit amet, consectetur adipisicinr incididunt ut labore 
			et dolore magna aliqua. Ut enpsum dolor sit amet, consectetur adipisicinr incididunt ut labore 
			et dolore magna aliqua. Ut eni
		</article>
		<article class="third">Ut eni</article>	
		<article class="third">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut eni</article>	
		<article class="third">
			Lorem ipsum dolor sit amet, consectetur adipisicinr incididunt ut labore 
			et dolore magna aliqua. Ut enpsum dolor sit amet, consectetur adipisicinr incididunt ut labore 
			et dolore magna aliqua. Ut enpsum dolor sit amet, consectetur adipisicinr incididunt ut labore 
			et dolore magna aliqua. Ut enpsum dolor sit amet, consectetur adipisicinr incididunt ut labore 
			et dolore magna aliqua. Ut eni
		</article>
		<article class="third">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut eni</article>	
		<article class="third">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut eni</article>	
		<article class="third">Lorem ipsum dolor sit amet, consectetur adipisicing consectetur adipisicing consectetur adipisicing elitmpor incididunt ut labore et dolore magna aliqua. Ut eni</article>
	<article class="third">Lorem ipsum dolor sit amet, consectetur a, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut eni</article>	
		<article class="third">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut eni</article>
		<article class="third">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut eni</article>	
		<article class="third">
			Lorem ipsum dolor sit amet, consectetur adipisicinr incididunt ut labore 
			et dolore magna aliqua. Ut enpsum dolor sit amet, consectetur adipisicinr incididunt ut labore 
			et dolore magna aliqua. Ut enpsum dolor sit amet, consectetur adipisicinr incididunt ut labore 
			et dolore magna aliqua. Ut enpsum dolor sit amet, consectetur adipisicinr incididunt ut labore 
			et dolore magna aliqua. Ut eni
		</article>
		<article class="third">Ut eni</article>	
		<article class="third">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut eni</article>	
		<article class="third">
			Lorem ipsum dolor sit amet, consectetur adipisicinr incididunt ut labore 
			et dolore magna aliqua. Ut enpsum dolor sit amet, consectetur adipisicinr incididunt ut labore 
			et dolore magna aliqua. Ut enpsum dolor sit amet, consectetur adipisicinr incididunt ut labore 
			et dolore magna aliqua. Ut enpsum dolor sit amet, consectetur adipisicinr incididunt ut labore 
			et dolore magna aliqua. Ut eni
		</article>
		<article class="third">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut eni</article>	
		<article class="third">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut eni</article>	
		<article class="third">Lorem ipsum dolor sit amet, consectetur adipisicing consectetur adipisicing consectetur adipisicing elitmpor incididunt ut labore et dolore magna aliqua. Ut eni</article>		
		<div class="clearfix"></div>
	</div>
	</div>

	<footer id="footer" role="contentinfo" class="wrap">
			<div class="container">
				<?php
					$fDate = '&copy; 2012';
					if ( date('Y') != '2012' ) $fDate = $fDate.' - '.date('Y');
				?>
				<span class="foot-left"><span>Copyright <?php echo $fDate; ?></span><span class="hyph"> - </span><span><?php bloginfo('name'); ?>. </span><span>All Rights Reserved.</span></span>
				<span class="foot-right">Site by <a href="http://www.gurustugroup.com" id="guruLink" title="GuRuStu. Branding, Marketing & Web Design." target="_blank">GuRuStu Group</a></span>
				<div class="clearfix"></div>
			</div>
	</footer><!-- footer -->
		



	<?php wp_footer(); ?>


<!-- here comes the javascript -->

<!-- jQuery is called via the Wordpress-friendly way via functions.php -->

<!-- this is where we put our custom functions -->

<!-- Asynchronous google analytics; this is the official snippet.
	 Replace UA-XXXXXX-XX with your site's ID and uncomment to enable.
	 
<script>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-XXXXXX-XX']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
-->
	
</body>

</html>
