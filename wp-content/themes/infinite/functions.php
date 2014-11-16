<?php
/*****************************************************************************************************/
/* DEFINE CONSTANTS */
/*****************************************************************************************************/
define('THEMEROOT', get_template_directory_uri());
define('IMAGES', THEMEROOT.'/images');

if ( ! isset( $content_width ) ) $content_width = 870;


include 'framework/widgets/infinite_tags_widget.php';
include 'framework/widgets/infinite_contactinfo_widget.php';
include 'framework/widgets/infinite_recentposts_widget.php';

include 'framework/metaboxes/metaboxes.php';



if ( !function_exists( 'optionsframework_init' ) ) {
    define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/framework/options-framework/' );
    require_once dirname( __FILE__ ) . '/framework/options-framework/options-framework.php';
}

include 'framework/plugin-framework/plugin-framework.php';



/*Infinite Setup*/
add_action('after_setup_theme', 'infinite_setup');
function infinite_setup(){
    
    // Add post thumbnail functionality
    add_theme_support('post-thumbnails');
    add_image_size('blog-grid', 270, 210, true);
    add_image_size('blog-full', 1170, 470, true);
    add_image_size('blog-normal', 810, 325, true);
    add_image_size('blog-two-column', 550, 410, true);
    add_image_size('related-post', 210, 171, true);
    add_image_size('thumb-large', 120, 120, true);
    add_image_size('post-thumb', 80, 80, true);

    register_nav_menus(array(
        'main-menu' => __('Main Menu','infinite-framework') 
    ));

    add_theme_support( 'automatic-feed-links' );

    $args = array(
        'default-color' => '#6a6767',
        'default-image' => get_template_directory_uri() . '/images/patterns/noisy_grid.png',
    );
    add_theme_support( 'custom-background', $args );

    load_theme_textdomain('infinite-framework', get_template_directory() . '/languages');

}

function infinite_load_resource_files(){

    global $wp_styles;

    if(!defined("PRODUCTION_ENV") || PRODUCTION_ENV){
        wp_enqueue_script( 'jquery-masonry', array( 'jquery' ) );
        wp_enqueue_script( 'infinite_all', get_template_directory_uri() . '/js/infinite.allscripts.min.js', array('jquery'), '1.0', true );
    }else{
        wp_enqueue_script('modernizr', get_template_directory_uri().'/js/modernizr.custom.js');
        wp_enqueue_script( 'flexSlider', get_template_directory_uri() . '/js/jquery.flexslider.min.js', array('jquery'), '1.0', true );
        wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.min.js', array('jquery'), '1.0', true );
        wp_enqueue_script( 'colorbox', get_template_directory_uri() . '/js/jquery.colorbox-min.js', array('jquery'), '1.0', true );
        wp_enqueue_script( 'jquery-masonry', array( 'jquery' ) );
        wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', '', '1.0', true );

        wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/js/imagesloaded.js', array('jquery'), '1.0', true );
        wp_enqueue_script( 'shuffle', get_template_directory_uri() . '/js/jquery.shuffle.min.js', array('jquery'), '1.0', true );

        wp_enqueue_script( 'infinite', get_template_directory_uri() . '/js/infinite.js', array('jquery'), '1.0', true );
    }

    if (!is_admin()) {
        if (is_singular() && comments_open() && (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
    
    $protocol = is_ssl() ? 'https' : 'http';
    wp_enqueue_style('googleFonts', "$protocol://fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&subset=latin%2Clatin-ext");
    wp_enqueue_style('infinite-style', get_template_directory_uri().'/style.css');

    // Load style.css from child theme
    if (is_child_theme()) {
        wp_enqueue_style('infinite-child', get_stylesheet_uri(), false, null);
    }

    wp_enqueue_style('fontawesome', get_template_directory_uri().'/css/font-awesome.min.css');
    wp_enqueue_style('responsive-1170', get_template_directory_uri().'/css/responsive-1170.css');
    wp_enqueue_style('responsive', get_template_directory_uri().'/css/responsive.css');
    wp_enqueue_style('font-awesome-ie7', get_template_directory_uri().'/css/font-awesome-ie7.min.css');
    wp_enqueue_style('ie-styles', get_template_directory_uri().'/css/ie.css');
    
    $wp_styles->add_data( 'font-awesome-ie7', 'conditional', 'lt IE 8' );
    $wp_styles->add_data( 'ie-styles', 'conditional', 'lt IE 10' );

}
add_action( 'wp_enqueue_scripts', 'infinite_load_resource_files' );


function infinite_custom_colors_css() {
    load_template( get_template_directory() . '/custom.css.php' );
}
add_action( 'wp_head', 'infinite_custom_colors_css' );


// add ie conditional html5 shim to header
function infinite_add_ie_html5_shim () {
    echo '<!--[if lt IE 9]>';
    echo '<script src="'. get_template_directory_uri() .'/js/html5.js"></script>';
    echo '<![endif]-->';
}
add_action('wp_head', 'infinite_add_ie_html5_shim');


function infinite_admin_custom_js () {
    wp_register_script( 'infinite_custom_js', get_template_directory_uri() .'/js/admin.js', array( 'jquery', 'wp-color-picker') );
    wp_enqueue_script( 'infinite_custom_js' );

    wp_enqueue_style( 'wp-color-picker' );

    wp_enqueue_style ('admin_panel_font', get_template_directory_uri() . '/css/font-awesome.min.css');
    wp_enqueue_style ('admin_panel_css', get_template_directory_uri() . '/css/admin.css');
}
add_action( 'admin_enqueue_scripts', 'infinite_admin_custom_js' );


/*Filter for Custom excerpt*/
function infinite_excerpt_more( $more ) {
    return ' [...] <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">Read More <i class="icon-double-angle-right"></i></a>';
}
add_filter( 'excerpt_more', 'infinite_excerpt_more' );


// Filter function for wp_title
function infinite_filter_wp_title( $old_title, $sep, $sep_location ){
 
    // add padding to the sep
    $ssep = ' ' . $sep . ' ';
     
    // find the type of index page this is
    if( is_category() ) $insert = $ssep . __('Category','infinite-framework');
    elseif( is_tag() ) $insert = $ssep . __('Tag','infinite-framework');
    elseif( is_author() ) $insert = $ssep . __('Author','infinite-framework');
    elseif( is_year() || is_month() || is_day() ) $insert = $ssep . __('Archives','infinite-framework');
    elseif( is_home() ) $insert = $ssep . get_bloginfo('description');
    else $insert = NULL;
     
    // get the page number we're on (index)
    if( get_query_var( 'paged' ) )
    $num = $ssep . __('Page ','infinite-framework') . get_query_var( 'paged' );
     
    // get the page number we're on (multipage post)
    elseif( get_query_var( 'page' ) )
    $num = $ssep . __('Page ','infinite-framework') . get_query_var( 'page' );
     
    // else
    else $num = NULL;

     
    // concoct and return new title
    return get_bloginfo( 'name' ) . $insert . $old_title . $num;
}
add_filter( 'wp_title', 'infinite_filter_wp_title', 10, 3 );


/*****************************************************************************************************/
/* REGISTER SIDEBARS & WIDGETS */
/*****************************************************************************************************/

function infinite_widgets_init(){

    register_sidebar( array( 
        'name'            => __('Main Sidebar','infinite-framework'),
        'id'            => __('main-sidebar','infinite-framework'),
        'description'    => __('The Main sidebar area','infinite-framework'),
        'before_widget'    => '<div class="sidebar-widget clearfix %2$s" id="%1$s">',
        'after_widget'    => "</div>\n",
        'before_title'    => '<h3>',
        'after_title'    => "</h3>\n"
        )    
    );

    register_sidebar( array( 
        'name'            => __('Footer Widget 1 (First Row)','infinite-framework'),
        'id'            => __('footer-widget1','infinite-framework'),
        'description'    => __('The first Row of Footer Widgets, place widgets as per no. of footer widgets setting you set in Theme Options','infinite-framework'),
        'before_widget'    => '<article class="span4 %2$s" id="%1$s">',
        'after_widget'    => "</article>\n",
        'before_title'    => '<h1>',
        'after_title'    => "</h1>\n"
        )    
    );

    register_sidebar( array( 
        'name'            => __('Footer Widget 2 (Second Row)','infinite-framework'),
        'id'            => __('footer-widget2','infinite-framework'),
        'description'    => __('The first Row of Footer Widgets, place widgets as per no. of footer widgets setting you set in Theme Options','infinite-framework'),
        'before_widget'    => '<article class="span4 %2$s" id="%1$s">',
        'after_widget'    => "</article>\n",
        'before_title'    => '<h1>',
        'after_title'    => "</h1>\n"
        )    
    );

    register_widget('infinite_ContactInfo_Widget');
    register_widget('infinite_RecentPosts_Widget');
    register_widget('infinite_Tags_Widget');

}
add_action( 'widgets_init', 'infinite_widgets_init' );


/*****************************************************************************************************/
/* MENUS */
/*****************************************************************************************************/

class infinite_mob_menu extends Walker_Nav_Menu {
  
    // add classes to ul sub-menus
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        // depth dependent classes
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1); // because it counts the first submenu as 0
      
        // build html
        $output .= "\n" . $indent . '<ul class="dl-submenu">' . "\n";
    }
         
}

// Filter wp_nav_menu() to add additional links and other output
function infinite_nav_menu_items($items) {
    $items .= '<li class="menu-item" id="menu-item-search"><a href="#"><i class="icon-search"></i></a><form class="search" action="'.get_site_url().'" method="get"><div class="arrow-up"></div><input name="s" type="text" placeholder="Search ..."></form></li>';
    return $items;
}
add_filter( 'wp_nav_menu_items', 'infinite_nav_menu_items' );


/*****************************************************************************************************/
/* FUNCTION TO DISPLAY COMMENTS */
/*****************************************************************************************************/

function infinite_comments($comment, $args, $depth){

    $GLOBALS['comment'] = $comment;

    if(get_comment_type() == 'pingback' || get_comment_type() == 'trackback') : ?>
    
        <li class="pingback" id="comment-<?php comment_ID() ?>">
            <article <?php comment_class('clearfix') ?>>
                <div class="comment-meta">
                    <?php _e('Pingback:','infinite-framework') ?>
                    <?php edit_comment_link() ?>
                </div>
                <div class="comment-content">
                    <?php comment_author_link(); ?>
                </div>
            </article>
        </li>
    
    <?php elseif(get_comment_type() == 'comment') : ?>
    
        <li id="comment-<?php comment_ID() ?>">
            <article <?php comment_class('clearfix') ?>>
                <div class="avatar">
                    <?php  echo get_avatar($comment, 70);    ?>
                </div>
                <div class="comment-meta">
                    <?php $author_url = get_comment_author_url();
                        if(empty( $author_url ) || 'http://' == $author_url) : ?>
                        <i class="icon-user"></i>
                        <span class="comment-author"><?php comment_author(); ?></span>
                    <?php else :?>
                        <i class="icon-user"></i>
                        <a class="comment-author" href="<?php $author_url; ?>"><?php comment_author(); ?></a>
                    <?php endif; ?>
                    <!-- <a class="comment-author" href="">Admin</a> -->
                    <span class="comment-date post-date"><i class="icon-calendar"></i> <?php comment_date(); ?> at <?php comment_time(); ?></span>
                    <span class="comment-reply">
                        <i class="icon-reply"></i>
                        <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                    </span>
                </div>
                <div class="comment-content">
                    <?php if($comment->comment_approved == '0') : ?>
                        <p><?php _e('Your comment is awaiting moderation','infinite-framework') ?></p>
                    <?php endif; ?>
                    <?php comment_text(); ?>
                </div>
            </article>

    <?php endif; ?>

<?php
}

function infinite_custom_comment_fields() {
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : ' ');
}

add_filter( 'comment_form_default_fields', 'infinite_custom_comment_fields');


/*****************************************************************************************************/
/* PAGINATION/BREADCRUMB FUNCTIONS BY KRIESI */
/*****************************************************************************************************/

function infinite_pagination($total){
    $big = 999999999; // need an unlikely integer

    $pagination = paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $total,
        'prev_text'    => __('<i class="icon-double-angle-left"></i>'),
        'next_text'    => __('<i class="icon-double-angle-right"></i>'),
        'type' => 'array'
    ));

    if(!empty($pagination)){
        echo '<div class="pagination pagination-centered"><ul>';
        foreach ($pagination as $page) {
            echo "<li>$page</li>";
        }
        echo '</ul></div>';
    }
}


function infinite_breadcrumb() {
        global $post;
        echo '<ul class="breadcrumbs">';
        
         if ( !is_front_page() ) {
        echo '<li><a href="';
        echo esc_url( home_url( '/' ) );
        echo '">'.__('Home', 'infinite-framework');
        echo "</a></li>";
        }
        
        if ( is_category() || is_single() && !is_singular('portfolio')) {
            $category = get_the_category();
            if(isset($category[0])){
                $ID = $category[0]->cat_ID;
                echo '<li>'.get_category_parents($ID, TRUE, '', FALSE ).'</li>';
            }
        }

        if(is_singular('portfolio')) {
            echo get_the_term_list($post->ID, 'portfolio_category', '<li>', ' - ', '</li>');   
        }

        if(is_home()) { echo '<li>'.of_get_option('blog_title', 'Blog').'</li>'; }
        if(is_single() || is_page()) { echo '<li>'.get_the_title().'</li>'; }
        if(is_tag()){ echo '<li>'."Tag: ".single_tag_title('',FALSE).'</li>'; }
        if(is_404()){ echo '<li>'.__("404 - Page not Found", 'infinite-framework').'</li>'; }
        if(is_search()){ echo '<li>'.__("Search", 'infinite-framework').'</li>'; }
        if(is_year()){ echo '<li>'.get_the_time('Y').'</li>'; }

        echo "</ul>";
}

function infinite_colourBrightness($hex, $percent) {
    $hash = '';
    if (stristr($hex,'#')) {
        $hex = str_replace('#','',$hex);
        $hash = '#';
    }
    $rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
    for ($i=0; $i<3; $i++) {
        if ($percent > 0) {
            $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
        } else {
            $positivePercent = $percent - ($percent*2);
            $rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
        }
        if ($rgb[$i] > 255) {
            $rgb[$i] = 255;
        }
    }
    $hex = '';
    for($i=0; $i < 3; $i++) {
        $hexDigit = dechex($rgb[$i]);
        if(strlen($hexDigit) == 1) {
        $hexDigit = "0" . $hexDigit;
        }
        $hex .= $hexDigit;
    }
    return $hash.$hex;
}


function infinite_hextoRgb($hex){
    if (stristr($hex,'#')) {
        $hex = str_replace('#','',$hex);
        $hash = '#';
    }
    $rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
    return $rgb;
}



/*-----------------------------------------------------------------------------------*/
/*  Register Portfolio Templates
/*-----------------------------------------------------------------------------------*/

function infinite_get_single_portfolio_template($single_template) {
    global $post;

    if ($post->post_type == 'portfolio') {

        if ( file_exists( get_stylesheet_directory() . '/single-portfolio.php' ) )
                return get_stylesheet_directory() . '/single-portfolio.php';    
        
        return $single_template = dirname( __FILE__ ) . '/templates/single-portfolio.php';
    }
    return $single_template;
}

function infinite_get_taxonomy_portfolio_template($single_template) {
    global $post;

    if ($post->post_type == 'portfolio') {

        $file = 'portfolio-four-column.php';

        if ( file_exists( get_stylesheet_directory() . '/'.$file ) )
                return get_stylesheet_directory() . '/'.$file;    
        
        return $single_template = dirname( __FILE__ ) . '/templates/'.$file;
    }
    return $single_template;
}


function infinite_get_archive_portfolio_template($single_template) {
    global $post;

    if ($post->post_type == 'portfolio') {

        if ( file_exists( get_stylesheet_directory() . '/archive-portfolio.php' ) )
                return get_stylesheet_directory() . '/archive-portfolio.php';    
        
        return $single_template = dirname( __FILE__ ) . '/templates/archive-portfolio.php';
    }
    return $single_template;
}

if(class_exists('Portfolio_Post_Type')){
    add_filter( "single_template", "infinite_get_single_portfolio_template" ) ;
    add_filter( "taxonomy_template", "infinite_get_taxonomy_portfolio_template" ) ;
    add_filter( "archive_template", "infinite_get_archive_portfolio_template" ) ;
}

?>