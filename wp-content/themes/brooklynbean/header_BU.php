<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
    <title><?php
        if ( is_single() ) { single_post_title(); }
        elseif ( is_home() || is_front_page() ) { bloginfo('name'); print ' | '; bloginfo('description'); }
        elseif ( is_page() ) { single_post_title(''); }
        elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . wp_specialchars($s);}
        elseif ( is_404() ) { bloginfo('name'); print ' | Not Found'; }
        else { bloginfo('name'); wp_title('|'); }
    ?></title>
    <meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <?php wp_head(); ?>
    <!--[if !IE 7]>
	<style type="text/css">
		#wrap {display:table;height:100%}
	</style>
	<![endif]-->
    <link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/favicon.ico" />
    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <script type="text/javascript" src="//use.typekit.net/ioo7jyl.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
</head>
<body>
<div id="wrapper" class="hfeed">
<div id="header">
        <div id="masthead">
         <div id="centerLogo">
            	<div class="logoBox">
            	<a href="<?php echo get_settings('home'); ?>"><img src="<?php bloginfo('template_url'); ?>/img/logo.png" alt="Brooklyn Beans" width="537" height="217" /></a>
                </div>
            </div>
            <div id="mainNavLinks">
          <div id="access">
                <?php $args = array(
					'include' => '7, 11, 5, 120, 117, 126, 123, 131, 503',
					'title_li' => '',
					'sort_colomn' => 'menu_order'
				);
				
				wp_nav_menu($args); ?>
            </div><!-- #access -->
 			<div class="rightSide">
            	<?php $args = array(
					'include' => '101, 9',
					'title_li' => '',
					'sort_colomn' => 'menu_order'
				);
				wp_nav_menu($args); ?>
                
                <?php $args = array( 'post_type' => 'bbr-links', 'title_li' => 'Get Your BBR');
					  $loop = new WP_Query( $args );?>
					  <div class='menu' style="padding-top:0;">
                        <ul>
                          <li class="page_item"><a>Get Your BBR</a>
                            <ul class="children">
					 <?php while ( $loop->have_posts() ) : $loop->the_post();?>
						<li><a href="<?php echo the_content();?>" target="_blank"><?php echo the_title(); ?></a></li>
					 <?php endwhile; ?>
					    </ul>
                      </li>
                     </ul>
                    </div>
             </div>
            </div> 
           
      </div><!-- #masthead -->
    </div><!-- #header -->
 
    <div id="main">