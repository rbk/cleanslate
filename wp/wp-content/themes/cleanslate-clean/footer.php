<?php
/**
 * @package WordPress
 * @subpackage Gurustu
 * @since Gurustu
 */
?>	
	</div> <!-- end site-main -->

	<footer id="footer" role="contentinfo" class="wrap">
			<div class="container">
				<?php
					$fDate = '&copy; 2012';
					if ( date('Y') != '2012' ) $fDate = $fDate.' - '.date('Y');
				?>
				<span class="foot-left"><span>Copyright <?php echo $fDate; ?></span><span class="hyph"> - </span><span><?php bloginfo('name'); ?>. </span><span>All Rights Reserved.</span></span>
				<span class="foot-right">Site by <a href="http://www.gurustugroup.com" id="guruLink" title="GuRuStu. Branding, Marketing & Web Design." target="_blank">GuRuStu</a></span>
				<div class="clearfix"></div>
			</div>
	</footer><!-- footer -->

	<?php wp_footer(); ?>
	<?php gurustu_google_analytics();?>
	
</body>

</html>
