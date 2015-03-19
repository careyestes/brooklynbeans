<?php
	add_action('wp_enqueue_scripts', 'loadStyles');
	function loadStyles() {
		wp_register_style('fancybox_css', get_template_directory_uri().'/styles/jquery.fancybox.css');
		wp_enqueue_style('fancybox_css');
		wp_register_style('main_styles', get_template_directory_uri().'/style.css', array('fancybox_css'), '2.0');
		wp_enqueue_style('main_styles');
	}
	add_action('wp_enqueue_scripts', 'reload_jquery');
	function reload_jquery() {
		// if( !is_admin() ){
		// 	wp_deregister_script('jquery');
		// 	wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js');
		// 	wp_enqueue_script('jquery');
		// }
	}
	//Load scripts
	add_action( 'wp_enqueue_scripts', 'loadScripts');
	function loadScripts() {
		wp_register_script( 'jquery_color', get_template_directory_uri(). '/js/jquery_color.js', array('jquery'));
		wp_enqueue_script('jquery_color');
		wp_register_script( 'fancybox', get_template_directory_uri(). '/js/jquery.fancybox.js', array('jquery'));
		wp_enqueue_script('fancybox');
		wp_register_script( 'fancybox_pack', get_template_directory_uri(). '/js/jquery.fancybox.pack.js', array('jquery', 'fancybox'));
		wp_enqueue_script('fancybox_pack');
		wp_register_script( 'jquery_validate', get_template_directory_uri(). '/js/jquery.validate.min.js', array('jquery'));
		wp_enqueue_script('jquery_validate');
	}

	// Load custom admin styling
	function my_admin_enqueue($hook_suffix) {
        wp_enqueue_style('custom_admin_styles', get_template_directory_uri() . '/styles/admin_styles.css');
        ?>
        <script type="text/javascript">
        //<![CDATA[
        var template_directory = '<?php echo get_template_directory_uri() ?>';
        //]]>
        </script>
        <?php
	}
	add_action('admin_enqueue_scripts', 'my_admin_enqueue');
	
	//Add Featured Image Functionality
	add_theme_support( 'post-thumbnails', array( 'post','bbr_roasts') ); 
	add_theme_support( 'menus' );
	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable($locale_file) )
	    require_once($locale_file);
	// For category lists on category archives: Returns other categories except the current one (redundant)
	function cats_meow($glue) {
	    $current_cat = single_cat_title( '', false );
	    $separator = "\n";
	    $cats = explode( $separator, get_the_category_list($separator) );
	    foreach ( $cats as $i => $str ) {
	        if ( strstr( $str, ">$current_cat<" ) ) {
	            unset($cats[$i]);
	            break;
	        }
	    }
	    if ( empty($cats) )
	        return false;

	    return trim(join( $glue, $cats ));
	} // end cats_meow
	
	// For tag lists on tag archives: Returns other tags except the current one (redundant)
	function tag_ur_it($glue) {
	    $current_tag = single_tag_title( '', '',  false );
	    $separator = "\n";
	    $tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
	    foreach ( $tags as $i => $str ) {
	        if ( strstr( $str, ">$current_tag<" ) ) {
	            unset($tags[$i]);
	            break;
	        }
	    }
	    if ( empty($tags) )
	        return false;

	    return trim(join( $glue, $tags ));
	} // end tag_ur_it
	
	// Register widgetized areas
	function theme_widgets_init() {
	    // Area 1
	    register_sidebar( array (
	    'name' => 'Primary Widget Area',
	    'id' => 'primary_widget_area',
	    'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
	    'after_widget' => "</li>",
	    'before_title' => '<h3 class="widget-title">',
	    'after_title' => '</h3>',
	  ) );

	    // Area 2
	    register_sidebar( array (
	    'name' => 'Secondary Widget Area',
	    'id' => 'secondary_widget_area',
	    'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
	    'after_widget' => "</li>",
	    'before_title' => '<h3 class="widget-title">',
	    'after_title' => '</h3>',
	  ) );
	} // end theme_widgets_init

	add_action( 'init', 'theme_widgets_init' );
	
	$preset_widgets = array (
	    'primary_widget_area'  => array( 'search', 'pages', 'categories', 'archives' ),
	    'secondary_widget_area'  => array( 'links', 'meta' )
	);
	if ( isset( $_GET['activated'] ) ) {
	    update_option( 'sidebars_widgets', $preset_widgets );
	}
	// update_option( 'sidebars_widgets', NULL );
	
	// Check for static widgets in widget-ready areas
	function is_sidebar_active( $index ){
	  global $wp_registered_sidebars;

	  $widgetcolums = wp_get_sidebars_widgets();

	  if ($widgetcolums[$index]) return true;

	    return false;
	} // end is_sidebar_active
	
	//Add custom post types for bottom navigation
	add_action( 'init', 'create_post_type' );
	function create_post_type() {
	register_post_type( 'bbr_roasts',
		array(
			'labels' => array(
				'name' => __( 'Our Roasts' ),
				'singular_name' => __( 'Roast' )
			),
		'public' => true,
		'has_archive' => true,
		'supports' => array( 'title', 'editor', 'thumbnail' )
		)
	);
}

// Query Roast Types for dropdown menu
function getRoastTypes() {
	global $post;
	$roastTypes = array();
	$args = array(
			'post_type' => 'bbr_roasts',
			'posts_per_page' => -1
		);
		$query = new WP_Query( $args ); 
		
		// The Loop
		while ( $query->have_posts() ) {
			$query->the_post();
			$roastTypes[get_the_title()] = get_the_title();
		}
	return $roastTypes;
}
$roastTypes = getRoastTypes();

// Add FAQ
function register_faq(){
    $args = array(
        'label' => __('FAQ'),
       	'singular_label' => __('FAQ'),
       	'public' => true,
       	'show_ui' => true,
       	'capability_type' => 'post',
       	'hierarchical' => false,
		'rewrite' => array("slug" => "faq",'with_front' => true), // Permalinks format
		'supports' => array( 'title', 'editor'),
		'add_new' => __( 'Add New FAQ' ),
		'add_new_item' => __( 'Add New FAQ' ),
		'edit' => __( 'Edit FAQ' ),
		'edit_item' => __( 'Edit FAQ' ),
		'new_item' => __( 'New FAQ' ),
		'view' => __( 'View FAQ' ),
		'view_item' => __( 'View FAQ' ),
		'search_items' => __( 'Search faq' ),
		'not_found' => __( 'No faq found' ),
		'not_found_in_trash' => __( 'No faq found in Trash' ),
		'parent' => __( 'Parent Info' ),
		'menu_position' =>__( 50 ),
       );

   	register_post_type( 'faq' , $args );
}

add_action('init', 'register_faq');

$prefix = "bbr_";
$meta_boxes = array();


//  META BOXES
$meta_boxes[] = array(
	'id' => 'roast_tag',      
	'title' => 'Roast Info',  
	'pages' => array( 'bbr_roasts' ), 	
	'context' => 'normal',                  
	'priority' => 'high',                   
	'fields' => array(                      
		array(
			'id' => $prefix.'roast_tag',
			'name' => 'Roast Flavor Tagline',
			'type' => 'text'
		),
		array(
			'id' => $prefix.'roast_type',
			'name' => 'Roast Flavor Type',
			'type' => 'select',
			'options' => $roastTypes
		)
	)
);
$meta_boxes[] = array(
	'id' => 'roast_background_image',      
	'title' => 'Background Image',  
	'pages' => array( 'bbr_roasts' ), 	
	'context' => 'side',                  
	'priority' => 'default',                   
	'fields' => array(                      
		array(
			'id' => $prefix.'roast_bg_image',
			'name' => 'Roast Flavor Background Image',
			'type' => 'image_advanced',
			'desc' => 'Only upload one image here'
		)
	)
);

$meta_boxes[] = array(
	'id' => 'roast_type',      
	'title' => 'Roast Type',  
	'pages' => array( 'roast-name' ), 	
	'context' => 'normal',                  
	'priority' => 'high',                   
	'fields' => array(                      
		array(
			'id' => $prefix.'roast_type',
			'name' => 'Roast Flavor Type',
			'type' => 'select',
			'options' => $roastTypes
		)
	)
);
$meta_boxes[] = array(
	'id' => 'roast_image',      
	'title' => 'Roast Info',  
	'pages' => array( 'roast-name' ), 	
	'context' => 'normal',                  
	'priority' => 'high',                   
	'fields' => array(                      
		array(
			'id' => $prefix.'roast_cap',
			'name' => 'Roast Flavor Cap',
			'desc' => 'Upload images @ 190px x 190px. This will help with page load.',
			'type' => 'image_advanced',
			'class' => 'imageMeta'
		),
		array(
			'id' => $prefix.'roast_gallery',
			'name' => 'Roast Gallery',
			'desc' => 'Images should be resized to 800px x 800px for best results. Images should have background removed and uploaded as .png file type. Just because you save it as a .png does not remove the background. You gotta use an image editor to do that. Photoshop works best for this. Here is a <a target="_blank" href ="http://www.howtogeek.com/howto/29770/quickly-remove-backgrounds-in-photoshop-using-the-magic-eraser/">good tutorial.</a>',
			'type' => 'image_advanced',
			'class' => 'imageMeta'
		)
	)
);
$meta_boxes[] = array(
	'id' => 'video_url',      
	'title' => 'Our Videos Info',  
	'pages' => array( 'videos' ), 	
	'context' => 'normal',                  
	'priority' => 'high',                   
	'fields' => array( 
		array(
			'id' => $prefix.'videosHeader',
			'name' => 'Tagline',
			'desc' => 'This section is for the video entry title.',
			'type' => 'text'
		),                     
		array(
			'id' => $prefix.'videos',
			'name' => 'Video Url Code',
			'desc' => 'Vimeo videos have a unique ID code in their url. Enter that code here. <br>For instance, if the url is <em>http://player.vimeo.com/video/48136340</em>, enter 48136340 in the field above.',
			'type' => 'text',
			'clone' => true
		)
	)
);
$meta_boxes[] = array(
	'id' => 'bbr_link',      
	'title' => 'Link URL',  
	'pages' => array( 'bbr-links' ), 	
	'context' => 'normal',                  
	'priority' => 'high',                   
	'fields' => array( 
		array(
			'id' => $prefix.'link',
			'name' => 'URL',
			'desc' => 'Make sure to include http://',
			'type' => 'text'
		)
	)
);

$meta_boxes[] = array(
	'id' => 'bbr_basic_tag',      
	'title' => 'Tag',  
	'pages' => array( 'page' ), 	
	'context' => 'normal',                  
	'priority' => 'high',                   
	'fields' => array( 
		array(
			'id' => $prefix.'hero_tag',
			'name' => 'Tagline',
			'desc' => 'This field is used <strong>ONLY</strong> for pages using the "Basic Page" template.<br>This is the line that shows up above the hero image.',
			'type' => 'text',
			'class' => 'heroText'
		)
	)
);

$meta_boxes[] = array(
	'id' => 'bbr_basic_hero_image',      
	'title' => 'Images',  
	'pages' => array( 'page' ), 	
	'context' => 'normal',                  
	'priority' => 'high',                   
	'fields' => array( 
		array(
			'id' => $prefix.'hero_image',
			'name' => 'Hero Image',
			'desc' => 'This field is used <strong>ONLY</strong> for pages using the "Basic Page" template. This will be the large image at the top of the page.<br>It should be resized 960px x 300px for best results.',
			'type' => 'image_advanced',
			'class' => 'heroImageBox'
		)
	)
);

$meta_boxes[] = array(
	'id' => 'bbr_privacy_option',      
	'title' => 'Intranet',  
	'pages' => array( 'page' ), 	
	'context' => 'side',                  
	'priority' => 'low',
	'required' => 1,                   
	'fields' => array( 
		array(
			'id' => $prefix.'is_public',
			'name' => 'Ambassadors Only?',
			'desc' => 'If checked private, only logged in distributors can access this page.',
			'type' => 'radio',
			'options' => array('public' => 'Public', 'private' => 'Private'),
			'class' => 'distributor_radio_button'
		)
	)
);
/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
function bbr_register_meta_boxes()
{
	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( !class_exists( 'RW_Meta_Box' ) )
		return;

	global $meta_boxes;
	foreach ( $meta_boxes as $meta_box )
	{
		new RW_Meta_Box( $meta_box );
	}
}
add_action( 'admin_init', 'bbr_register_meta_boxes' );

// Custom styling for comments in suggestion page
function restyle_comments($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
?>
		<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
		<div class="commentTop"></div>
		<div class="commentBody">
			<?php if ( 'div' != $args['style'] ) : ?>
			<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
			<?php endif; ?>
			<div class="comment-author vcard">
			<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			<?php printf(__('<cite class="fn" style="font-style:normal;">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
			</div>
			<?php if ($comment->comment_approved == '0') : ?>
					<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
					<br />
			<?php endif; ?>

			<?php comment_text() ?>
			
		</div>
		<div class="commentBottom"></div>
<?php
        }
