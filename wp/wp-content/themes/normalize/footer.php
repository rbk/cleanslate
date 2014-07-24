<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package underscores
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<span class="alignleft">Copyright <?php echo Date('Y'); ?>, <?php echo bloginfo('name'); ?></span>
			<span id="gurustu" class="alignright">Web Design by <a target="_blank" href="http://gurustu.co" title="Best Website Design, Branding, Marketing, SEO, Videography, Animation, 3D Projection, Graphic Design, Social Media &amp; PR, Custom Website Design in Tulsa.">GuRuStu</a></span>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>