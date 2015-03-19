<?php
  $isAmbassador = rwmb_meta("bbr_is_public");
  if($isAmbassador == 'private' && !is_user_logged_in()) {
  	wp_redirect( get_site_url()."/ambassador-login");
		exit;
  }
?>
<?php get_header(); ?>
 		
        <div class="flatPage">
                
<?php the_post(); ?>
 
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-content">
<?php the_content(); ?>
<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'your-theme' ) . '&after=</div>') ?>

                    </div><!-- .entry-content -->
                </div><!-- #post-<?php the_ID(); ?> -->           
 
<?php if ( get_post_custom_values('comments') ) comments_template() // Add a custom field with Name and Value of "comments" to enable comments on this page ?>            
 				</div><!--.flatPage -->
            </div><!-- #content -->
          </div><!-- #container -->
           
<?php get_footer(); ?>