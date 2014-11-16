<?php

define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
require_once dirname( __FILE__ ) . '/inc/options-framework.php';
include_once('baztro.php');

function esell_scripts() {
		wp_enqueue_style( 'esell-style', get_stylesheet_uri() );
/**
 * Enqueues the javascript for comment replys 
 * 
 * */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	}
add_action( 'wp_enqueue_scripts', 'esell_scripts' );

	/*
	* Home Icon for Menu
	*/
	function esell_hdmenu() {
		echo '<ul>';
		if ('page' != get_option('show_on_front')) {
		if (is_front_page())
$class = 'class="current_page_item home-icon"';
else
$class = 'class="home-icon"';
			echo '<li ' . $class . ' ><a href="'.esc_url( home_url() ). '/"><img src="'. get_template_directory_uri() . '/images/home.jpg" width="26" height="24"/></a></li>';
		}
		wp_list_pages('title_li=');
		echo '</ul>';
	}

add_filter( 'wp_nav_menu_items', 'esell_home_link', 10, 2 );

function esell_home_link($items, $args) {
if (is_front_page())
$class = 'class="current_page_item home-icon"';
else
$class = 'class="home-icon"';
$homeMenuItem =
'<li ' . $class . '>' .
$args->before .
'<a href="' . esc_url( home_url( '/')). '" title="Home">' .
$args->link_before . '<img src="'. get_template_directory_uri() . '/images/home.jpg" width="26" height="24" alt="Home" />' . $args->link_after .
'</a>' .
$args->after .
'</li>';
$items = $homeMenuItem . $items;
return $items;
}


/* Enable support for post-thumbnails ********************************************/
		
	// If we want to ensure that we only call this function if
	// the user is working with WP 2.9 or higher,
	// let's instead make sure that the function exists first
	
function esell_theme_setup() { 
		if ( function_exists( 'add_theme_support' ) ) { 
		add_theme_support( 'post-thumbnails' );
	}	
		add_image_size( 'defaultthumb', 200, 200 );
	
	    load_theme_textdomain('esell', get_template_directory() . '/languages');
	
        add_editor_style('esell');
		register_nav_menus(
			array(
 				'esell-navigation' => __('Navigation', 'esell' ),
			)		
		);
        add_theme_support('automatic-feed-links');
		}
		// Sets up the content width value based on the theme's design
	global $content_width;
	if ( ! isset( $content_width ) ) {
	$content_width = 670;}

		//woocommerce plugin support
		add_theme_support( 'woocommerce' );

		// Setup the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'magazine_custom_background_args', array(
		'default-color' => 'F3F3F3',
		'default-image' => '',
	) ) );
	add_action( 'after_setup_theme', 'esell_theme_setup' );
	
function esell_post_meta_data() {
	printf( __( '%2$s  %4$s', 'esell' ),
	'meta-prep meta-prep-author posted', 
	sprintf( '<span itemprop="datePublished" class="timestamp updated">%3$s</span>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_html( get_the_date() )
	),
	'byline',
	sprintf( '<span class="author vcard" itemprop="author" itemtype="http://schema.org/Person"><span class="fn">%3$s</span></span>',
		get_author_posts_url( get_the_author_meta( 'ID' ) ),
		sprintf( esc_attr__( 'View all posts by %s', 'esell' ), get_the_author() ),
		esc_attr( get_the_author() )
		)
	);
}

/* Excerpt ********************************************/

    function esell_excerptlength_teaser($length) {
    return 12;
    }
    function esell_excerptlength_index($length) {
    return 45;
    }
    function esell_excerptmore($more) {
    return '...';
    }
    
    
    function esell_excerpt($length_callback='', $more_callback='') {
    global $post;
    add_filter('excerpt_length', $length_callback);
 
    add_filter('excerpt_more', $more_callback);
   
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>'.$output.'</p>';
    echo $output;
    }

function esell_readinfo() {

 echo '<a class="promaxmore" href="';
 echo ''.the_permalink().'';
 echo '">'.of_get_option('esell_moreinfo' ).'</a>';
}
add_action('woocommerce_after_shop_loop_item', 'esell_readinfo');

/* Widgets ********************************************/

    function esell_widgets_init() {

	register_sidebar(array(
		'name' => __( 'Sidebar', 'esell' ),
	    'before_widget' => '<div class="box clearfloat"><div class="boxinside clearfloat">',
	    'after_widget' => '</div></div>',
	    'before_title' => '<h4 class="widgettitle">',
	    'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'name' => __( 'Bottom Menu 1', 'esell' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
	    'after_widget' => '</div>',
	    'before_title' => '<h4>',
	    'after_title' => '</h4>',
	));

	register_sidebar(array(
		'name' => __( 'Bottom Menu 2', 'esell' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
	    'after_widget' => '</div>',
	    'before_title' => '<h4>',
	    'after_title' => '</h4>',
	));	

	register_sidebar(array(
		'name' => __( 'Bottom Menu 4', 'esell' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
	    'after_widget' => '</div>',
	    'before_title' => '<h4>',
	    'after_title' => '</h4>',
	));	

}
add_action('widgets_init', 'esell_widgets_init');
//---------------------------- [ Pagenavi Function ] ------------------------------//
 

function esell_pagenavi() {
	global $wp_query;
	$big = 123456789;
	$page_format = paginate_links( array(
	    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	    'format' => '?paged=%#%',
	    'current' => max( 1, get_query_var('paged') ),
	    'total' => $wp_query->max_num_pages,
	    'type'  => 'array'
	) );
	if( is_array($page_format) ) {
	            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
	            echo '<div class="wp-pagenavi">';
	            echo '<span class="pages">'. $paged . ' of ' . $wp_query->max_num_pages .'</span>';
	            foreach ( $page_format as $page ) {
	                    echo "$page";
	            }
	           echo '</div>';
	 }
}
/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since eSell 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function esell_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'esell' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'esell_wp_title', 10, 2 );

?>