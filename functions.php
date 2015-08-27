<?php
/*
Author: Eddie Machado - Brian Clovis
URL: htp://themble.com/frankentheme/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

// LOAD frankentheme CORE (if you remove this, the theme will break)
require_once( 'library/frankentheme-kicker.php' );

// USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
require_once( 'library/custom-post-type.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
require_once( 'library/admin.php' );


/*********************
LAUNCH frankentheme
Let's get everything up and running.
*********************/

function lets_get_rocked() {

  // let's get language support going, if you need it
  load_theme_textdomain( 'frankentheme', get_template_directory() . '/library/translation' );

  // launching operation cleanup
  add_action( 'init', 'frankentheme_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'frankentheme_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'frankentheme_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'frankentheme_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'frankentheme_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'frankentheme_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  frankentheme_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'frankentheme_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'frankentheme_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'frankentheme_excerpt_more' );

} /* end frankentheme ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'lets_get_rocked' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'frankentheme-thumb-600', 1200, 900, true );
add_image_size( 'frankentheme-thumb-310', 310, 270, true );
add_image_size( 'frankentheme-thumb-300', 300, 200, true );
add_image_size( 'footer-image', 80, 80, true );
add_image_size('admin-list-thumb',80,80,true);
add_image_size('full-slide',1920,1200,true);

add_filter( 'image_size_names_choose', 'frankentheme_custom_image_sizes' );

function frankentheme_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'frankentheme-thumb-600' => __('1200px by 900px'),
        'frankentheme-thumb-300' => __('300px by 200px'),
        'full-slide' => __('1920 x 1200'),
        'admin-list-thumb' => __('80px by 80px'),
    ) );
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function frankentheme_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'frankentheme' ),
		'description' => __( 'The first (primary) sidebar.', 'frankentheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));


	register_sidebar(array(
		'id' => 'footer',
		'name' => __( 'Footer Images', 'frankentheme' ),
		'description' => __( 'Area For Footer Images', 'frankentheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

} // don't remove this bracket!

/************* IMAGE TAXONOMY **********************/
function wptp_add_categories_to_attachments() {
    register_taxonomy_for_object_type( 'category', 'attachment' );
}
add_action( 'init' , 'wptp_add_categories_to_attachments' );

// apply tags to attachments
function wptp_add_tags_to_attachments() {
    register_taxonomy_for_object_type( 'post_tag', 'attachment' );
}
add_action( 'init' , 'wptp_add_tags_to_attachments' );


/************* COMMENT LAYOUT *********************/

// Comment Layout
function frankentheme_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('group'); ?>>
    <article  class="group">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'frankentheme' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'frankentheme' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'frankentheme' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'frankentheme' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content group">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!


/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
function frankentheme_fonts() {
  wp_register_style('googleFonts', '//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
  wp_enqueue_style( 'googleFonts');
}

add_action('wp_print_styles', 'frankentheme_fonts');


//ONE, TWO, THREE, THREE EXCERPT LENGTH
		function frankentheme_excerptlength_teaser($length) {
    		return 30;
		}
		function frankentheme_excerptlength_index($length) {
    		return 35;
		}
		function frankentheme_excerptlength_blog($length) {
    		return 80;
		}
		function frankentheme_excerptmore($more) {
			global $post;
    		return '<a class="more" href="'. get_permalink($post->ID) . '">Read More</a>';
		}

		function frankentheme_excerpt($length_callback='', $more_callback='') {
			global $post;
		if(function_exists($length_callback)){
			add_filter('excerpt_length', $length_callback);
		}
		if(function_exists($more_callback)){
			add_filter('excerpt_more', $more_callback);
		}
		$output = get_the_excerpt();
		$output = apply_filters('wptexturize', $output);
		$output = apply_filters('convert_chars', $output);
		$output = '<p>'.$output.'</p>';
		echo $output;
		}

//WANNA UPLOAD SVG...GOTCHA COVERED
		function cc_mime_types( $mimes ){
			$mimes['svg'] = 'image/svg+xml';
			return $mimes;
		}
add_filter( 'upload_mimes', 'cc_mime_types' );

//CUSTOM POST TYPE FOR HERITAGE TIME LINE
add_action('init', 'create_timeline');
	     function create_timeline() {
	       $feature_args = array(
	          'labels' => array(
	           'name' => __( 'Timeline' ),
	           'singular_name' => __( 'Timeline' ),
	           'add_new' => __( 'Add New Year' ),
	           'add_new_item' => __( 'Add New Year' ),
	           'edit_item' => __( 'Edit Year' ),
	           'new_item' => __( 'Add New Year' ),
	           'view_item' => __( 'View Year' ),
	           'search_items' => __( 'Search Years' ),
	           'not_found' => __( 'No slider years found' ),
	           'not_found_in_trash' => __( 'No years found in trash' )
	         ),
	       'public' => true,
	       'show_ui' => true,
	       'menu_icon' => 'dashicons-calendar',
	       'capability_type' => 'post',
	       'hierarchical' => false,
	       'rewrite' => true,
	       'menu_position' => null,
	       'capability_type' => 'post',
	       'supports' => array('title', 'editor', 'thumbnail','timeline_meta_boxes')
	     );
	  register_post_type('timeline',$feature_args);
	}
// Custom Post types for Feature project on home page 
	   add_action('init', 'create_slider');
	     function create_slider() {
	       $feature_args = array(
	          'labels' => array(
	           'name' => __( 'Full Page Slider' ),
	           'singular_name' => __( 'Full Page Slider' ),
	           'add_new' => __( 'Add New Image' ),
	           'add_new_item' => __( 'Add New Image' ),
	           'edit_item' => __( 'Edit Image' ),
	           'new_item' => __( 'Add New Image' ),
	           'view_item' => __( 'View Image' ),
	           'search_items' => __( 'Search Images' ),
	           'not_found' => __( 'No slider images found' ),
	           'not_found_in_trash' => __( 'No images found in trash' )
	         ),
	       'public' => true,
	       'show_ui' => true,
	       'menu_icon' => 'dashicons-images-alt2',
	       'capability_type' => 'post',
	       'hierarchical' => false,
	       'rewrite' => true,
	       'menu_position' => null,
	       'capability_type' => 'post',
	       'supports' => array('title', 'editor', 'thumbnail','author','order_meta')
	     );
	  register_post_type('slider',$feature_args);
	}
	add_filter("manage_feature_edit_columns", "feature_edit_columns");


	add_action('manage_posts_custom_column','frankentheme_custom_columns');
	add_filter('manage_edit_gallery_columns','frankentheme_add_new_gallery_columns');
	function frankentheme_custom_columns($column){
		global $post;

		switch($column){
			case 'frankentheme_post_thumb' : echo the_post_thumbnail('admin-list-thumb'); break;
			case 'description' : the_excerpt(); break;
		}
	}
	add_filter('manage_posts_columns','frankentheme_add_post_thumbnail_column',5);
	function frankentheme_add_post_thumbnail_column($cols){
		$cols['frankentheme_post_thumb'] = __('Thumbnail');
		return $cols;
	}
	class Child_Wrap extends Walker_Nav_Menu
{
    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"level\"><ul class=\"sub-menu\">\n";
    }
    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    }
}
add_action('admin_head', 'my_custom_fonts');
function my_custom_fonts() {
  echo '<style>
    body, td, textarea, input, select {
      font-family: "Helvetica";
      font-size: 16px;
    } 
  </style>';
}


// Custom WordPress Admin Color Scheme
function admin_css() {
	wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/build/css/admin.css' );
}
add_action('admin_print_styles', 'admin_css' );
//QUICK AND BULK EDIT CUSTOM

//add to slider
add_filter( 'manage_posts_columns', 'brian_clovis_slider_order', 10, 2 );
function brian_clovis_slider_order( $columns, $post_type ) {
   if ( $post_type == 'slider' )
      $columns[ 'post_order' ] = 'Post Order';
   return $columns;
}
//add to posts
add_filter( 'manage_posts_columns', 'brian_clovis_post_cols', 5, 5 );
function brian_clovis_post_cols( $columns, $post_type ) {
   switch ($post_type){

   		case 'post';
   			$new_columns = array();
   			foreach ($columns as $key => $value){
   				$new_columns[$key] =$value;

   				if($key == 'categories')
   					$new_columns['slidePlacement'] = 'Post Order';
   			}
   			return $new_columns;
   			break;
   }
   return $columns;
}
//popultae columns
add_action( 'manage_posts_custom_column', 'brian_clovis_pop_custom_columns', 10, 2 );
function brian_clovis_pop_custom_columns( $column_name, $post_id ) {

   switch( $column_name ) {
      case 'slidePlacement':
         echo '<div id="slidePlacement-' . $post_id . '">' . get_post_meta(get_the_id(), "slidePlacement", true) . '</div>';
         break;
   }
}
add_action( 'bulk_edit_custom_box', 'brian_clovis_add_to_edit', 10, 2 );
add_action( 'quick_edit_custom_box', 'brian_clovis_add_to_edit', 10, 2 );
function brian_clovis_add_to_edit( $column_name, $post_type ) {

	$order = get_post_meta(get_the_id(), "slidePlacement", true);
   switch ( $post_type ) {
    case 'slider':
   		switch( $column_name ) {
      	case 'post_order':
     		?><fieldset class="inline-edit-col-right">
      			<div class="inline-edit-group">
         			<label>
            		<span class="title">Post Order</span>
                	<input type="number" name="post_order" value="<?php echo $order ?>" />
             	</label>
          	</div>
           </fieldset><?php
         break;
       }
   	break;
    case 'post':
      switch( $column_name ) {
      	case 'slidePlacement':
       	?><fieldset class="inline-edit-col-right">
            <div class="inline-edit-group">
             	<label>
                <span class="title">Post Order</span>
                  <input type="number" name="slidePlacement" id="slidePlacement" value="<?php echo $order ?>" />
             	</label>
            </div>
         	</fieldset><?php
         break;
         }
     break;
   }
}
add_action( 'save_post','brian_clovis_quick_save_save', 10, 2 );
function brian_clovis_quick_save_save( $post_id, $post ) {
   // don't save for autosave
   if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return $post_id;
   // dont save for revisions
   if ( isset( $post->post_type ) && $post->post_type == 'revision' )
      return $post_id;
   switch( $post->post_type ) {
      case 'post':
	 			if ( array_key_exists( 'slidePlacement', $_POST ) )
	    		update_post_meta( $post_id, 'slidePlacement', $_POST[ 'slidePlacement' ] );
			 break;
			 case 'slide':
	 			if ( array_key_exists( 'slidePlacement', $_POST ) )
	    		update_post_meta( $post_id, 'slidePlacement', $_POST[ 'slidePlacement' ] );
			 break;
   }
}

//PUT GRAVITY FORM SCRIPT IN BOTTOM
	add_filter("gform_init_scripts_footer", "init_scripts");
		function init_scripts() {
			return true;
	}
?>
