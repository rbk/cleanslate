
<?php
/**
 *
 * @package WordPress
 * @subpackage Gurustu
 * @since Gurustu
 *
 */
?>
<?php if (function_exists('dynamic_sidebar') && is_active_sidebar('sidebar-primary') ) : ?>
<aside id="sidebar">

<?php dynamic_sidebar('sidebar-primary');?>

</aside>
<div class="clearfix"></div>
<?php else : ?>


    <aside id="sidebar">
        <div class="sidebar-subpages">
            <ul class="sidenav">
                <?php if( is_blog() || $post->post_parent == get_option('page_for_posts')  ) : ?>
                        
                        <?php 

                            // if ( is_active_sidebar( 'primary-widget-area' ) ) :
                            //     dynamic_sidebar( 'primary-widget-area' );
                            // endif; 
                        ?>


                <?php else: ?>


                    <?php

                        wp_list_pages(
                            array(
                                'title_li' => ''
                                )
                        );

                    ?>
        

                <?php endif; ?>
            </ul>
        </div>
    </aside>
<?php endif; ?>