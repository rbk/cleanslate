<?php
/**
 * @package WordPress
 * @subpackage HTML5-Reset-Wordpress-Theme
 * @since HTML5 Reset 2.0
 */
 get_header(); ?>


	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
		<article class="post" id="post-<?php the_ID(); ?>">
			
			<h2><?php the_title(); ?></h2>
			
			<div class="entry">
				
				<?php the_content(); ?>
				<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
			
			</div>
			
			<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
		
		</article>
		
		<?php //comments_template(); ?>
	
	<?php endwhile; endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
