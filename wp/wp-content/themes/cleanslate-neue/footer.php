<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo">
		<?php
			$fDate = '&copy; 2012';
			if ( date('Y') != '2012' ) $fDate = $fDate.' - '.date('Y');
		?>
		<span class="foot-left"><span>Copyright <?php echo $fDate; ?></span><span class="hyph"> - </span><span><?php bloginfo('name'); ?>. </span><span>All Rights Reserved.</span></span>
		<span class="foot-right">Site by <a href="http://www.gurustugroup.com" id="guruLink" title="GuRuStu. Branding, Marketing & Web Design." target="_blank">GuRuStu Group</a></span>
		<div class="clearfix"></div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>