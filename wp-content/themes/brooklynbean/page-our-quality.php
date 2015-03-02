<?php 
/*
Template Name: Our Quality
*/
?>
<?php get_header(); ?>
 		
        <div class="flatPage ourQuality">
                
<?php the_post(); ?>
 
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-content">						
					 <?php $args = array( 'post_type' => 'passion');
		              $loop = new WP_Query( $args );
		              
		              while ( $loop->have_posts() ) : $loop->the_post();?>
						  <p><?php the_content() ?></p>
		             <?php endwhile; ?>

                    </div><!-- .entry-content -->
                </div><!-- #post-<?php the_ID(); ?> -->           
 
 				</div><!--.flatPage -->
            </div><!-- #content -->
          </div><!-- #container -->
           
<?php get_footer(); ?>