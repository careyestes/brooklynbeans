<?php get_header(); ?>
 		
        <div class="flatPage bottomNav ourVideos">
                
<?php the_post(); ?>
 
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-content">
					<?php $args = array( 'post_type' => 'videos');
			              $loop = new WP_Query( $args );?>
			              
			        <?php while ( $loop->have_posts() ) : $loop->the_post();?>
			        	<div class="videoEntry">
						  	  <h2><?php the_title() ?></h2>
						  	  <?php $videoCodes = rwmb_meta("bbr_videos");?>
						  	  <?php $videoHeader = rwmb_meta('bbr_videosHeader'); ?>
						  	  <div class="videoBlock">
							  	  <div class="alignright">
							  	  	<?php foreach ($videoCodes as $code): ?>
							  	  		<iframe class="ourVideosIframe" src="http://player.vimeo.com/video/<?php echo $code ?>" height="330" width="600" allowfullscreen="" frameborder="0"></iframe>
							  	  	<?php endforeach ?>
							  	  </div>
							  	  <h3><?php echo $videoHeader ?></h3>
								  <p><?php the_content() ?></p>
							  </div>
						</div>
						<div class="entryDivider" style="height: 30px;"></div>
			        <?php endwhile; ?>

                    </div><!-- .entry-content -->
                </div><!-- #post-<?php the_ID(); ?> -->           
 
 				</div><!--.flatPage -->
            </div><!-- #content -->
          </div><!-- #container -->
           
<?php get_footer(); ?>