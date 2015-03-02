<?php get_header(); ?>
 		
        <div class="flatPage bottomNav ourRoasts">
                
<?php the_post(); ?>
 
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-content">
				        <?php $args = array( 'post_type' => 'bbr_roasts');
				              $loop = new WP_Query( $args );
				              $i = 0;
				              while ( $loop->have_posts() ) : $loop->the_post(); ?>
							  	<a href="<?php echo the_permalink() ?>" class='roastBox roast_<?php echo $i ?>'>
							  		<div class='roastThumbnail'><?php echo the_post_thumbnail('medium'); ?></div>
									<p><?php echo the_title(); ?></p>
								</a>	
								<?php $i++; ?>					 
				        <?php endwhile;  ?>

                    </div><!-- .entry-content -->
                </div><!-- #post-<?php the_ID(); ?> -->           
 
 				</div><!--.flatPage -->
            </div><!-- #content -->
          </div><!-- #container -->
           
<?php get_footer(); ?>