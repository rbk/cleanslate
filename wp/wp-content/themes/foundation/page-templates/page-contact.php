<?php
/**
* Template name: Contact Page Template
* @package WordPress
* @subpackage Gurustu
* @since Gurustu
*/
    get_header(); ?>
        <div class="row">
            <div class="columns large-9">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="post" id="post-<?php the_ID(); ?>">

                    <h2><?php the_title(); ?></h2>

                    <div class="entry">
                        <?php echo do_shortcode('[location coordinates="' . get_option('guru_location_coordinates') . '" id="test" height="200" zoom="18"]');?>
                        <?php the_content(); ?>
                        <?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

                    </div>

                    <?php edit_post_link('Edit this page.', '<p>', '</p>'); ?>

                </article>
            <?php endwhile; endif; ?>
            </div>
            <div class="columns large-3">
                <?php get_sidebar(); ?>
            </div>
        </div>
<?php get_footer(); ?>