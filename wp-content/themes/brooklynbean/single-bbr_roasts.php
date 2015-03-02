	<?php get_header(); ?>
<?php the_post(); ?>
<div class="roastThumbBox">
	<div class="roastFlavorThumb"><?php echo the_post_thumbnail('large'); ?></div>
</div>
<div class="flatPage roastFlavor">
		<?php $image = rwmb_meta('bbr_roast_bg_image', 'type=image'); ?>
		<?php foreach ($image as $bg) {
				$bgUrl = $bg['full_url'];
		} ?>
		<div class="roastBg" style="background-image: url(<?php echo $bgUrl ?>)"></div>
        <div id="container">
            <div id="content">
				 <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<h1 class="entry-title"><?php the_title(); ?></h1>
					
					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-utility -->
					
					<!-- Load Tagline -->
					<?php $tag = rwmb_meta( "bbr_roast_tag"); ?>
					<h2><?php echo $tag ?></h2>
					
					<!-- Get Meta Value -->
					<?php $metaValue = rwmb_meta("bbr_roast_type", "type=select");?>
					<!-- Query roast meta -->
					<?php 
						$args = array(
						'post_type' => 'roast-name',
						'posts_per_page' => -1,
						'meta_value' => $metaValue
					);
					$query = new WP_Query( $args ); 
					$i = 1;
					// The Loop
					while ( $query->have_posts()): ?>
					<?php $query->the_post(); ?>
						<div class="roastEntry">
							<div class="roastEntryThumbnail">
								<?php $cap = rwmb_meta("bbr_roast_cap", "type=image");?>
								<?php foreach ($cap as $entry) {
									$url = $entry['full_url'];
									$title = $entry['title'];
								} ?>
								<img src="<?php echo $url ?>" title="<?php echo $title ?>" />
							</div>
							<div class="roastTitle"><?php echo get_the_title() ?></div>
							<div class="roastDescription"><?php echo get_the_content() ?></div>
								<?php $gallery = rwmb_meta("bbr_roast_gallery", "type=image");?>
								<?php if($gallery) : ?>
									<div class="roastGallery">
									<p class="roastGalleryHeader">Brooklyn Bean single serve coffee cups available in these sizes:</p>
									<?php foreach ($gallery as $image):
										$fullUrl = $image['full_url'];
										$url = $image['url'];
										$title = $image['title']; 
										$caption = $image['caption'];
										$descrip = $image['description'];
										?>
										<a class="roastGalleryImageBlock" rel="gallery_<?php echo $i ?>" href="<?php echo $fullUrl ?>" title="<?php echo ($descrip ? $descrip  : $caption) ?>">
											<img class="roastGalleryImage" src="<?php echo $url ?>" alt="<?php echo $title ?>" />
											<p class="roastGalleryCaption"><?php echo $caption ?></p>
										</a>
										
									<?php endforeach ?>
									</div>
								<?php endif ?>
						</div>
						<div style="clear:left;margin:30px 0 0;height:10px;border-top:1px solid #555150;"></div>
						<?php $i++ ?>
					<?php endwhile ?>
					

            </div><!-- #content -->
        </div><!-- #container -->
 </div>
 <script>
 jQuery(document).ready(function($) {
	$(".roastGalleryImageBlock").fancybox({
		prevEffect		: 'elastic',
		nextEffect		: 'elastic',
		helpers		: {
			title	: { type : 'inside' },
			}
	});
});
 </script>
<?php get_footer(); ?>