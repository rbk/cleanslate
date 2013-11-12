<?php
/**
 * @package WordPress
 * @subpackage Gurustu
 * @since Gurustu
 * This template is used as the blog page by default. http://codex.wordpress.org/Template_Hierarchy
 */
 get_header(); ?>
 	<section class="postlist">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article <?php post_class() ?> id="post-<?php the_ID(); ?>">

				<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

				<?php posted_on(); ?>

				<div class="entry">
					<?php the_excerpt(); ?>
					<a href="<?php the_permalink();?>" class="read-more">Read more</a>
				</div>

				<footer class="postmetadata">
					<?php //the_tags('Tags: ', ', ', '<br />'); ?>
					<?php //_e('Posted in','html5reset'); ?> <?php //the_category(', ') ?>  
					<?php //comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
				</footer>

			</article>
		<?php endwhile; ?>
	</section>
	<?php //post_navigation(); ?>

	<?php else : ?>

		<h2><?php _e('Nothing Found','html5reset'); ?></h2>

	<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
