<?php get_header(); ?>
<div class="flatPage singleBlogPost">
        <div id="container">
            <div id="content">

				<?php the_post(); ?>

                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<h2 class="entry-title"><?php the_title(); ?></h2>
					
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'hbd-theme' ) . '&after=</div>') ?>
					</div><!-- .entry-utility -->
					
					<!-- #post-<?php the_ID(); ?> -->           
 
            
 				<?php //comments_template('', true); ?>

            </div><!-- #content -->
        </div><!-- #container -->
 </div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>