<?php

function harlequin_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}
add_action( 'admin_init', 'harlequin_add_editor_styles' );


function harlequin_default_menu( $args ) {
	extract( $args );

	$output = wp_list_categories( array(
		'title_li' => '',
		'echo' => 0,
		'number' => 5,
		'depth' => 1,
	) );
	echo "<ul class='$menu_class'>$output</ul>";
}

function harlequin_setup() {

	load_theme_textdomain( 'harlequin', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );	
	add_theme_support( 'post-thumbnails' );	
	add_theme_support( 'custom-background' );
	
	$args = array(
		'width'         => 300,
		'height'        => 300,
	);
	
	add_theme_support( 'custom-header', $args );
	
	$chargs = array(
		'width' => 980,
		'height' => 300,
		'uploads' => true,
	);
	
	set_post_thumbnail_size( 825, 510, true );
	
	if ( ! isset( $content_width ) ) $content_width = 900;

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'harlequin' ),
	) );

	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

}
add_action( 'after_setup_theme', 'harlequin_setup' );

function harlequin_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'harlequin_featured_image' => __( 'Harlequin Thumbnail', "harlequin" )
    ) );
}
add_filter( 'image_size_names_choose', 'harlequin_custom_sizes' );
 
function harlequin_new_image_size(){
	add_image_size ( 'harlequin_featured_image', 1000, 500, true );
}
add_action("init", "harlequin_new_image_size");

function harlequin_save_post_colour(){
	if(isset($_POST["harlequin_post_colour"])){
		global $post;
		update_post_meta($post->ID, "harlequin_post_colour", $_POST["harlequin_post_colour"]);
	}
}
add_action("save_post", "harlequin_save_post_colour");

add_action( 'admin_enqueue_scripts', 'harlequin_scripts_admin' );

function harlequin_picture_category_edit_form_fields ($term) {
	$term_id = $term->term_id;
	$post = get_default_post_to_edit( 'post', true );
	$post_ID = $post->ID;
	?>
        <tr class="form-field">
			<th>Featured Image for this category</th>
            <td>
            	<div id="postimagediv" class="postbox" style="width:95%;" >
                    <div class="inside">
                        <?php wp_enqueue_media( array('post' => $post_ID) ); ?>
                        <?php
							$thumbnail_id = get_option( 'harlequin_picture_'.$term_id.'_thumbnail_id', 0 );
                            echo _wp_post_thumbnail_html( $thumbnail_id, $post_ID );
                        ?>
                    </div>
                    <input type="hidden" name="harlequin_picture_post_id" id="harlequin_picture_post_id" value="<?php echo $post_ID; ?>" />
                    <input type="hidden" name="harlequin_picture_term_id" id="harlequin_picture_term_id" value="<?php echo $term_id; ?>" />
                </div>
        	</td>
		</tr>
	<?php	
}
add_action('category_edit_form_fields','harlequin_picture_category_edit_form_fields');
add_action('post_tag_edit_form_fields','harlequin_picture_category_edit_form_fields');

function harlequin_scripts_admin() {

	wp_enqueue_style( 'harlequin-colour-picker', get_template_directory_uri() . '/css/colour-picker/jquery.minicolors.css' );
	wp_enqueue_style('thickbox');		
	wp_enqueue_script('thickbox');
	
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'harlequin-picture-remove', get_template_directory_uri() . '/js/category/picture-remove.js', array( 'jquery' ) );
	
	wp_enqueue_script( 'harlequin-colour-picker', get_template_directory_uri() . '/js/colour_picker/jquery.minicolors.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'harlequin-colour-picker-init', get_template_directory_uri() . '/js/colour_picker/jquery.minicolors.init.js', array( 'harlequin-colour-picker' ) );
} 

function harlequin_picture_taxonomies_save_meta( $term ) {

	if ( isset( $_POST['harlequin_picture_post_id'] ) && $_POST['harlequin_picture_post_id'] !=""  ) {
		$default = $_POST['harlequin_picture_post_id'];
	}else if ( isset( $_POST['harlequin_picture_term_id'] ) ) {
		$default = $_POST['harlequin_picture_term_id'];
	}
	
	$thumbnail = get_post_meta( $default, '_thumbnail_id', true );

	if($thumbnail){
		update_option( 'harlequin_picture_' . $term . '_thumbnail_id', $thumbnail );
	}
	
}
add_action('edited_category', 'harlequin_picture_taxonomies_save_meta', 10, 2 );  
add_action('edited_post_tag', 'harlequin_picture_taxonomies_save_meta', 10, 2 );    

function harlequin_picture_ajax_set_post_thumbnail() {

	delete_option( 'harlequin_picture_' . $_POST['term_id'] . '_thumbnail_id' );
		
	$return = _wp_post_thumbnail_html( null, $_POST['post_id']);

	echo $return;
	
	die(0);
	
}
add_action('wp_ajax_simulacra-category-remove-image', 'harlequin_picture_ajax_set_post_thumbnail' );  

function harlequin_category_edit_form_fields ($term) {
	$term_id = $term->term_id;
	?>
        <tr class="form-field">
			<th>Colour for this category</th>
            <td>
            	<div id="postimagediv" class="postbox" style="width:95%;" >
					<?PHP
						$colour = get_option( 'harlequin_' . $term_id . '_colour');
					?>
					<input type="text" name="harlequin_post_colour" id="inline" class="demo minicolors-input" data-inline="true" value="<?PHP echo $colour; ?>" size="7">
                    <input type="hidden" name="harlequin_term_id" id="harlequin_term_id" value="<?php echo $term_id; ?>" />
                </div>
        	</td>
		</tr>
	<?php	
}
add_action('category_edit_form_fields','harlequin_category_edit_form_fields');
add_action('post_tag_edit_form_fields','harlequin_category_edit_form_fields');

function harlequin_taxonomies_save_meta( $term ) {

	if(isset($_POST["harlequin_post_colour"])){
		update_option( 'harlequin_' . $term . '_colour', $_POST["harlequin_post_colour"] );
	}
	
}
add_action('edited_category', 'harlequin_taxonomies_save_meta', 10, 2 );  
add_action('edited_post_tag', 'harlequin_taxonomies_save_meta', 10, 2 );     

function harlequin_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area Bottom', 'harlequin' ),
		'id'            => 'sidebar-bottom',
		'description'   => __( 'Add widgets here to appear in your footer.', 'harlequin' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'harlequin_widgets_init' );
  
function harlequin_scripts() {
	wp_enqueue_style( 'harlequin-style-custom', get_template_directory_uri() . '/css/custom.css' );
	wp_enqueue_style( 'harlequin-core-style', get_template_directory_uri() . '/css/wp_core.css' );
	wp_enqueue_style( 'harlequin-style-mobile-575', get_template_directory_uri() . '/css/mobile575.css' );
	wp_enqueue_style( 'harlequin-style-mobile-768', get_template_directory_uri() . '/css/mobile768.css' );
	wp_enqueue_style( 'harlequin-style-mobile-1000', get_template_directory_uri() . '/css/mobile1000.css' );
	wp_enqueue_style( 'harlequin-style', get_template_directory_uri() . '/css/main.css' );
	wp_enqueue_style( 'harlequin-main-menu-style', get_template_directory_uri() . '/css/menu/main-menu.css' );

	wp_enqueue_script( 'harlequin-table-fix', get_template_directory_uri() . '/js/display/table_fix.js', array( 'jquery' ) );
	wp_enqueue_script( 'harlequin-masonry', get_template_directory_uri() . '/js/display/masonry.js', array( 'jquery' ) );
	wp_enqueue_script( 'harlequin-search', get_template_directory_uri() . '/js/search/search-form.js', array( 'jquery' ) );
	wp_enqueue_script( 'harlequin-main-menu', get_template_directory_uri() . '/js/menus/main-menu.js', array( 'jquery' ) );
	if ( is_singular() ) wp_enqueue_script( "comment-reply" );

}
add_action( 'wp_enqueue_scripts', 'harlequin_scripts' );

function harlequin_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

function harlequin_extra_style(){

	?><style>
	
		<?PHP
			$background = explode(" ", get_theme_mod("bkgsetting"));
			$clean = array_filter($background);
			shuffle($clean);
		?>
		
		html{
			<?PHP
				if(get_theme_mod("bkgsetting")!=""){ ?>
			background-image: url('<?PHP echo wp_get_attachment_url( $clean[0], array(1200,1200) ); ?>');
			<?PHP
				}
			?>
			background-color: <?PHP echo get_theme_mod('site_allsite_background_colour'); ?>;
			color: <?PHP echo get_theme_mod('site_alltext_colour'); ?>;
		}
		
		.site-navigation ul li a{
			color :  <?PHP echo get_theme_mod('site_menu_text_colour'); ?>;
		}
		
		.site-navigation li a:hover, 
		.site-navigation li a:focus {
			transition: background-color 0.5s ease;
			color: <?PHP echo get_theme_mod('site_menu_text_hover_colour'); ?>;
		}
		
		.site-navigation li:hover, 
		.site-navigation li:focus {
			transition: background-color 0.5s ease;
			background-color: <?PHP echo get_theme_mod('site_menu_background_hover_colour'); ?>;
		}
		
		.site-navigation ul li .current-menu-item a{
			background: <?PHP echo get_theme_mod('site_menu_background_current_colour'); ?>;  
			background-color: <?PHP echo get_theme_mod('site_menu_background_current_colour'); ?>;  
		}
		
		#searchform form input[type=text],
		#commentform input[type=text],
		#commentform input[type=email],
		#commentform input[type=url],
		textarea{
			background-color: <?PHP echo get_theme_mod('site_menu_background_colour'); ?>;
			color: <?PHP echo get_theme_mod('pagination_link_colour'); ?>; 
		}
		
		<?PHP
			$hex = harlequin_hex2rgb(get_theme_mod('site_header_colour'));
		?>
	
		#header-area,
		.widget-area aside,
		main .page-header,
		#primary-navigation,
		#sidebar-left,
		.search-no-results main,
		.error404 main{
			background-color: rgba(<?PHP echo $hex[0] . "," . $hex[1] . "," . $hex[2]; ?>, 1.0); 
		}

		<?PHP
			$hex = harlequin_hex2rgb(get_theme_mod('pagination_background_colour'));
		?>
		
		.pagination *,
		.pagination a,
		.pagination span{
			background-color: rgba(<?PHP echo $hex[0] . "," . $hex[1] . "," . $hex[2]; ?>, 1.0); 
			color: <?PHP echo get_theme_mod('pagination_link_colour'); ?>; 
		}	
		
		<?PHP
			$hex = harlequin_hex2rgb(get_theme_mod('pagination_current_background_colour'));
		?>
		
		.pagination span.current{
			background-color: rgba(<?PHP echo $hex[0] . "," . $hex[1] . "," . $hex[2]; ?>, 0.5); 
		}	

		<?PHP
			$hex = harlequin_hex2rgb(get_theme_mod('site_bottom_sidebar_background_colour'));
		?>
		
		#widget-area-bottom aside{
			background-color: rgba(<?PHP echo $hex[0] . "," . $hex[1] . "," . $hex[2]; ?>, 1); 
			color : <?PHP echo get_theme_mod('site_bottom_sidebar_text_colour'); ?>;
		}
		
		#widget-area-bottom aside a{
			color : <?PHP echo get_theme_mod('site_bottom_sidebar_link_colour'); ?>;
		}
		
		#widget-area-bottom aside a:hover{
			transition: background-color 0.5s ease;
			color: <?PHP echo get_theme_mod('site_alllink_hover_colour'); ?>;
		}
		
		<?PHP
			$hex = harlequin_hex2rgb(get_theme_mod('site_right_sidebar_background_colour'));
		?>
		
		#widget-area-right aside{
			background-color: rgba(<?PHP echo $hex[0] . "," . $hex[1] . "," . $hex[2]; ?>, 0.5); 
			color : <?PHP echo get_theme_mod('site_right_sidebar_text_colour'); ?>;
		}
		
		#widget-area-right aside a{
			color : <?PHP echo get_theme_mod('site_right_sidebar_link_colour'); ?>;
		}
		
		#widget-area-right aside a:hover{
			transition: background-color 0.5s ease;
			color: <?PHP echo get_theme_mod('site_alllink_hover_colour'); ?>;
		}
		
		<?PHP
			$hex = harlequin_hex2rgb(get_theme_mod('site_post_background_colour'));
		?>
	
		.single .entry-content,
		.single .entry-footer,
		.page-title,
		.page .entry-content,
		.taxonomy-description,
		#comments{
			background-color: rgba(<?PHP echo $hex[0] . "," . $hex[1] . "," . $hex[2]; ?>, 1); 
		}
	
		a{
			color: <?PHP echo get_theme_mod('site_alllink_colour'); ?>;
		}
		
		#content a:hover,
		#content a:focus{
			transition: background-color 0.5s ease;
			color: <?PHP echo get_theme_mod('site_alllink_hover_colour'); ?>;
		}
		
		header#masthead h1 a,
		header#masthead p a{
			color: <?PHP echo get_theme_mod("site_title_colour"); ?>;
		}
		
		header#masthead h1 a:hover,
		header#masthead p a:hover{
			transition: background-color 0.5s ease;
			color: <?PHP echo get_theme_mod('site_alllink_hover_colour'); ?>;
		}
		
		button,
		input[type=submit]{
			background-color:  <?PHP echo get_theme_mod("site_button_colour"); ?>;
			color:  <?PHP echo get_theme_mod("site_button_text_colour"); ?>;
		}
		
		article .entry-title{
			color:  <?PHP echo get_theme_mod("site_title_colour"); ?>;
		}
		
		<?PHP
			$hex = harlequin_hex2rgb(get_theme_mod('site_name_border_colour'));
		?>
		
		<?PHP
			if(get_theme_mod('widgetcss')=="full"){
				?>
					#sidebar-bottom aside{
						width: 100%;
						padding: 10px;
					}
				<?PHP
			}else if(get_theme_mod('widgetcss')=="two"){
				?>
					#sidebar-bottom aside{
						width: 46%;
						margin: 1%;
						padding: 10px;
					}
				<?PHP


			}else{
				?>
					#sidebar-bottom aside{
						margin: 1%;
						padding: 10px;
						width: 20%;
					}
				<?PHP
			}
		?>
	
	</style><?PHP

}
add_action("wp_head", "harlequin_extra_style");

function harlequin_excerpt_more( $excerpt ) {
	$parts = explode(" ", $excerpt);
	array_pop($parts);
	$replace ='<a href="' . get_post_permalink() . '">' . _x("Read more", 'Read more of this post', "harlequin") . "</a>";
	return implode(" ", $parts) . "... " . $replace;
}
add_filter( 'excerpt_more', 'harlequin_excerpt_more' );

function harlequin_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'harlequin_excerpt_length', 999 );

function harlequin_init(){

	if(!get_option("harlequin_colours")){

		set_theme_mod('site_allsite_background_colour', '#c6c6c6'); 
		set_theme_mod('site_title_colour', '#555555'); 
		set_theme_mod('site_alltext_colour', '#888888'); 
		set_theme_mod('site_alllink_hover_colour', '#222222');
		set_theme_mod('site_menu_text_colour', '#000000'); 
		set_theme_mod('site_menu_text_hover_colour', '#FF0000'); 
		set_theme_mod('site_menu_background_hover_colour', '#aaaaaa'); 
		set_theme_mod('site_menu_background_current_colour', '#cccccc'); 
		set_theme_mod('site_menu_background_colour', '#dddddd');
		set_theme_mod('site_header_colour', '#dddddd');
		set_theme_mod('pagination_background_colour', '#dddddd');
		set_theme_mod('pagination_link_colour', '#ff0000'); 
		set_theme_mod('site_bottom_sidebar_background_colour', '#dddddd');
		set_theme_mod('site_bottom_sidebar_text_colour', '#ffffff'); 
		set_theme_mod('site_bottom_sidebar_link_colour', '#ff0000');
		set_theme_mod('site_right_sidebar_background_colour', '#dddddd');
		set_theme_mod('site_right_sidebar_text_colour', '#ffffff'); 
		set_theme_mod('site_right_sidebar_link_colour', '#ff0000'); 
		set_theme_mod('site_post_background_colour', '#dddddd');
		set_theme_mod('site_alllink_colour', '#ff0000');
		set_theme_mod("site_button_colour", '#dddddd'); 
		set_theme_mod("site_button_text_colour", '#ffffff'); 
		set_theme_mod("site_post_background_colour",'#dddddd');
		set_theme_mod("site_post_default_background_colour",'#a5a5a5');
		set_theme_mod('site_post_default_title_colour','#fff');
		set_theme_mod("pagination", 'on'); 
		set_theme_mod("search", 'on'); 
		set_theme_mod("author", 'on'); 
		add_option("harlequin_colours", 1);
	
	}

}
add_action("wp_loaded", "harlequin_init");

function harlequin_featured_category_create(){

	if(!get_option("harlequin_featured")){

		$id = wp_create_category(_x("Featured Content", 'Content from the featured category', "harlequin"));
		add_option("harlequin_featured", $id);
	
	}
		
}
add_action("admin_head", "harlequin_featured_category_create");

function harlequin_post_colour(){
	add_meta_box( "harlequin_post_colour", "Post Colour", "harlequin_post_colour_set", "post", "side");
	add_meta_box( "harlequin_post_colour", "Post Colour", "harlequin_post_colour_set", "page", "side");
}	
add_action("admin_head", "harlequin_post_colour");

function harlequin_post_colour_set(){
	global $post;
	
	$colour = get_post_meta($post->ID, "harlequin_post_colour", true);
	?><input type="text" name="harlequin_post_colour" id="inline" class="demo minicolors-input" data-inline="true" value="<?PHP echo $colour; ?>" size="7"><?PHP
}

require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/menus/Walker_Menu.php';
