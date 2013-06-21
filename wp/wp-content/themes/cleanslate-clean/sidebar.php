<?php
/**
 * @package WordPress
 * @subpackage HTML5-Reset-Wordpress-Theme
 * @since HTML5 Reset 2.0
 */
?>

<aside id="sidebar">

    <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar Widgets')) : else : ?>
    
    
    <div class="sidebar-subpages">

        <ul class="sidenav">

            <?php if( is_blog() || $post->post_parent == get_option('page_for_posts')  ) : ?>
                    
                    <?php 

                        if ( is_active_sidebar( 'primary-widget-area' ) ) :
                            dynamic_sidebar( 'primary-widget-area' );
                        endif; 
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


    
    <?php endif; ?>

</aside>