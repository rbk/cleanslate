
<?php
/**
 * Template Name: Contact Page
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry-page-image">
						<?php the_post_thumbnail(); ?>
					</div><!-- .entry-page-image -->
				<?php endif; ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header>

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->

					<div id="gMap"></div>
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

					<?php 
						if (function_exists('guru_make_location_list'))
							echo guru_make_location_list();
					?>					
					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->
				</article><!-- #post -->

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>