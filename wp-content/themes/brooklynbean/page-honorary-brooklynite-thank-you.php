<?php 
/*
Template Name: Honorary Brooklynite Thank You Page
*/
?>
<?php get_header(); ?>
 		
        <div class="flatPage brooklynite">
                
<?php the_post(); ?>
 
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-content">
						<?php the_content(); ?>

                    </div><!-- .entry-content -->
                </div><!-- #post-<?php the_ID(); ?> -->           
 
 				</div><!--.flatPage -->
            </div><!-- #content -->
          </div><!-- #container -->
<?php get_footer(); ?>