<?php
/**
 * @package WordPress
 * @subpackage Gurustu
 * @since Gurustu
 */
 get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
		<article class="post" id="post-<?php the_ID(); ?>">

			<h2><?php the_title(); ?></h2>
			<div class="entry">
				<?php
					if( has_post_thumbnail() ){														
						$thumbID = get_post_thumbnail_id($post->ID);
						$thumbTitle = get_the_title( $thumbID );
						$thumbSrc = wp_get_attachment_image_src( $thumbID, 'page-thumb' );
						$banner = array(
						'url' => $thumbSrc[0],
						'width' => $thumbSrc[1],
						'height' => $thumbSrc[2]

						);

						echo '<div class="pic">';
						echo '<img src="'.$banner['url'].'" width="'.$banner['width'].'" height="'.$banner['height'].'" />';
						// echo '<div><span>'.$thumbTitle.'</span></div>';
						echo '</div>';
					}
				?>

				<?php the_content(); ?>
			</div>

			<?php edit_post_link('Edit this page.', '<p>', '</p>'); ?>

		</article>

		<?php endwhile; endif; ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
