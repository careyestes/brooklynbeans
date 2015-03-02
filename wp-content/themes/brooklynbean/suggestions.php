<?php
/*
Template Name: suggestionsPage
*/
?>
<?php get_header(); ?>

        <?php include("bottomNavLoops.php"); ?>
 		
        <div class="flatPage commentsPage">
                
<?php the_post(); ?>
 
                <div id="post-<?php the_ID(); ?>" class="commentsListing">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-content">
						<div class="commentlist">
							<?php
								//Gather comments for a specific page/post 
								$comments = get_comments(array(
									'post_id'     => 11,
									'status'      => 'approve', //Change this to the type of comments to be displayed
								));
								//Display the list of comments
								wp_list_comments(array(
									'per_page'          => 10, //Allow comment pagination
									'reverse_top_level' => false, //Show the latest comments at the top of the list
									'avatar_size'       => 0,
									'style'             => 'div',
									'format'            => 'html5',
									'callback'			=> 'restyle_comments'
								), $comments);
							?>
						</div>  
                    </div><!-- .entry-content -->
                </div><!-- #post-<?php the_ID(); ?> -->
                <?php if($_POST['submit']): ?>
				  <p>Form was submitted</p>
				<?php endif ?>
               	<?php the_content(); ?>
				<?php if ( get_post_custom_values('comments') ) comments_template() // Add a custom field with Name and Value of "comments" to enable comments on this page ?>
				<br>
				<p class="privacyPolicy"><a target="_blank" href="<?php echo get_site_url( $blog_id = null, $path = 'privacy-policy', $scheme = null ); ?>">Privacy Policy</a></p>       
 		</div><!--.flatPage -->
    </div><!-- #content -->
</div><!-- #container -->       
<?php get_footer(); ?>