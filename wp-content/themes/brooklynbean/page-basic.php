<?php 
/*
Template Name: Basic Page
*/
?>
<?php get_header(); ?>
 		
        <div class="flatPage">
                
<?php the_post(); ?>
 
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-content">
                    	<?php $heroText =  rwmb_meta('bbr_hero_tag') ?>
                    	<h2><?php echo $heroText ?></h2>
                    	<?php $hero = rwmb_meta('bbr_hero_image', 'type=image') ?>
                    	<?php foreach ($hero as $image): ?>
                    		<img class="basicHeroImage" src="<?php echo $image['full_url'] ?>" />
                    	<?php endforeach ?>
                    	<?php the_content(); ?>
                    </div><!-- .entry-content -->
                </div><!-- #post-<?php the_ID(); ?> -->           
          
 				</div><!--.flatPage -->
            </div><!-- #content -->
          </div><!-- #container -->
           
<?php get_footer(); ?>