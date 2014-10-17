<?php
// Start the engine
require_once( get_template_directory() . '/lib/init.php' );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', '13th Floor - Genesis Child Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );

// Add Viewport meta tag for mobile browsers
add_action( 'genesis_meta', 'sample_viewport_meta_tag' );
function sample_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

// Add support for custom background
add_theme_support( 'custom-background' );

// Add support for custom header
add_theme_support( 'genesis-custom-header', array(
	'width' => 688, //1152 original
	'height' => 166 //120 original
) );

// Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//Changes "Speak your mind" to "Leave a comment"
function change_default_comment_text($args) {
    $args['title_reply'] = 'Leave a Comment';
    return $args;
}
add_filter( 'genesis_comment_form_args', 'change_default_comment_text' );

add_action('wp_print_styles','lm_dequeue_header_styles');
function lm_dequeue_header_styles()
{
  wp_dequeue_style('yarppWidgetCss');
}

add_action('get_footer','lm_dequeue_footer_styles');
function lm_dequeue_footer_styles()
{
  wp_dequeue_style('yarppRelatedCss');
}


//Make it so category pages are just a list of titles as links
//Custom loop added 10/16/2014
add_action( 'pre_get_posts', 'mjg_show_titles_only_category_pages' );
function mjg_show_titles_only_category_pages( $query ) {
 
	if( $query->is_main_query() && $query->is_category() ) {
		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'ASC' );
		
		
		
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'mjg_custom_loop' );
	}
}
 
function mjg_custom_loop() {
	echo '<div class="category-title">';
	single_cat_title( 'Category: ', true );
	
	echo '</div>';
	
 	echo '<ul class="category-post-title-list">';
	while (have_posts()) : the_post();
		?>
		<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>
	<?php
	endwhile;

}
