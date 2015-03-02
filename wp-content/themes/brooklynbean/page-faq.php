<?php get_header(); ?>
 		
        <div class="flatPage bottomNav faq">
                
<?php the_post(); ?>
 
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-content">				
					<?php $args = array(
						'post_type' => 'faq',
						// 'posts_per_page' => -1,
					) ?>
					<?php $query = new WP_Query($args) ?>
					<?php if ($query->have_posts()): ?>
						<?php while ($query->have_posts()): ?>
							<?php $query->the_post() ?>
							<div class="faqBlock">
								<div class="faqQuestion"><?php the_title() ?></div>
								<div class="faqAnswer"><?php the_content() ?></div>
							</div>
							<div class="entryDivider" style="width:700px;"></div>
						<?php endwhile ?>
					<?php endif ?>

                    </div><!-- .entry-content -->
                </div><!-- #post-<?php the_ID(); ?> -->           
 
 				</div><!--.flatPage -->
            </div><!-- #content -->
          </div><!-- #container -->
           
<?php get_footer(); ?>