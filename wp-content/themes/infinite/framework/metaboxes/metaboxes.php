<?php 
require_once("meta-box-class.php");

//All meta boxes prefix, inherited from theme Shortname
$prefix = 'infinite_meta_';


//Meta box config
$meta_page_config = array(
  'id' => 'page_options',               // meta box id, unique per meta box
  'title' => 'Page Options',              // meta box title
  'pages' => array('page'),         // post types, accept custom post types as well, default is array('post'); optional
  'context' => 'normal',                // where the meta box appear: normal (default), advanced, side; optional
  'priority' => 'high',               // order of meta box: high (default), low; optional
  'fields' => array(),                // list of meta fields (can be added by field arrays)
  'local_images' => true,             // Use local or hosted images (meta box images for add/remove)
  'use_with_theme' => true              //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );


$meta_post_config = array(
  'id' => 'post_options',               // meta box id, unique per meta box
  'title' => 'Post Options',              // meta box title
  'pages' => array('post'),         // post types, accept custom post types as well, default is array('post'); optional
  'context' => 'normal',                // where the meta box appear: normal (default), advanced, side; optional
  'priority' => 'high',               // order of meta box: high (default), low; optional
  'fields' => array(),                // list of meta fields (can be added by field arrays)
  'local_images' => true,             // Use local or hosted images (meta box images for add/remove)
  'use_with_theme' => true              //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );


$yesNo = array('Yes' => 'Yes', 'No' => 'No');

//Initiate Meta box for Pages
$infinite_page_meta =  new AT_Meta_Box($meta_page_config);

$infinite_page_meta->addSelect($prefix.'show_sidebar', $yesNo , array('name'=> 'Display Sidebar','desc' => 'Do you want to display the sidebar for this page ?', 'dont_show_in' => 'frontpage-template.php'));
$infinite_page_meta->addSelect($prefix.'show_flex_slideshow', $yesNo , array('name'=> 'Display Flex Slideshow','desc' => 'Do you want to display the Flex slider slideshow for the attached images in this page ?', 'dont_show_in' => 'contact-us.php,frontpage-template.php'));
$infinite_page_meta->addSelect($prefix.'show_title', $yesNo , array('name'=> 'Display Title','desc' => 'Do you want to display the Title for this page ?', 'dont_show_in' => 'contact-us.php,frontpage-template.php'));


if(function_exists('camera_Install')){
  $camera_added_slideshows = camera_get_option( 'camera_added_slideshows' );
  $camera_arr = array('none' => 'None');
  foreach($camera_added_slideshows as $option => $value) {
    $camera_arr[sanitize_title($value)] = $value;
  }
  $infinite_page_meta->addSelect('camera_meta_slideshow', $camera_arr , array('name'=> 'Camera Slider','desc' => 'Select the camera slider you want to show in this page, this will be the first item in the page', 'page_template' => 'frontpage-template.php', 'dont_show_in' => 'contact-us.php'));  
}


$infinite_page_meta->addSelect($prefix.'show_recent_blog', $yesNo , array('name'=> 'Show Recent Blog','desc' => 'Do you want to show recent blog posts in this page ?', 'page_template' => 'frontpage-template.php', 'dont_show_in' => 'contact-us.php'));
$infinite_page_meta->addText($prefix.'recent_blog_title', array('name' => 'Title for Recent Posts', 'desc' => 'Title you want to show for Recent blog posts, leave it empty if you don\'t want to show a title', 'page_template' => 'frontpage-template.php', 'dont_show_in' => 'contact-us.php'));
$infinite_page_meta->addNumber($prefix.'recent_blog_count', array('name' => 'No. of Recent Posts', 'desc' => 'No. of recent blog posts you want to display, default is 8', 'page_template' => 'frontpage-template.php', 'dont_show_in' => 'contact-us.php'));

if(class_exists('Portfolio_Post_Type')){

  $infinite_page_meta->addSelect($prefix.'show_recent_portfolio', $yesNo , array('name'=> 'Show Recent Portfolio','desc' => 'Do you want to show recent Portfolio posts in this page ?', 'page_template' => 'frontpage-template.php', 'dont_show_in' => 'contact-us.php'));
  $infinite_page_meta->addText($prefix.'recent_portfolio_title', array('name' => 'Title for Recent Portfolio Items', 'desc' => 'Title you want to show for Recent Portfolio posts, leave it empty if you don\'t want to show a title', 'page_template' => 'frontpage-template.php', 'dont_show_in' => 'contact-us.php'));
  $infinite_page_meta->addNumber($prefix.'recent_portfolio_count', array('name' => 'No. of Recent Portfolio Items', 'desc' => 'No. of recent Portfolio posts you want to display, default is 8', 'page_template' => 'frontpage-template.php', 'dont_show_in' => 'contact-us.php'));


  $meta_portfolio_config = array(
          'id' => 'portfolio_options',               // meta box id, unique per meta box
          'title' => 'Portfolio Options',              // meta box title
          'pages' => array('portfolio'),         // post types, accept custom post types as well, default is array('post'); optional
          'context' => 'normal',                // where the meta box appear: normal (default), advanced, side; optional
          'priority' => 'high',               // order of meta box: high (default), low; optional
          'fields' => array(),                // list of meta fields (can be added by field arrays)
          'local_images' => true,             // Use local or hosted images (meta box images for add/remove)
          'use_with_theme' => true              //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
          );

  $infinite_portfolio_meta =  new AT_Meta_Box($meta_portfolio_config);

  $infinite_portfolio_meta->addSelect($prefix.'show_flex_slideshow', $yesNo , array('name'=> 'Display Flex Slideshow','desc' => 'Do you want to display the Flex slider slideshow for the attached images in this page ?'));

  $infinite_portfolio_meta->addText($prefix.'project_url', array('name' => 'Project Url', 'desc' => 'The url of this project'));
  $infinite_portfolio_meta->addText($prefix.'project_url_text', array('name' => 'Project Url Text', 'desc' => 'The Text you want to display for the url'));

  $infinite_portfolio_meta->addWysiwyg($prefix.'project_task', array('name' => 'Task', 'desc' => 'Your task for this project (HTML is allowed)'));
  $infinite_portfolio_meta->addWysiwyg($prefix.'project_client', array('name' => 'Client', 'desc' => 'The client for this project (HTML is allowed)'));


  $infinite_portfolio_meta->Finish();

}


$infinite_page_meta->addSelect($prefix.'show_call_to_action', $yesNo , array('name'=> 'Show Call to Action','desc' => 'Do you want to show call to action section in this page ?', 'page_template' => 'frontpage-template.php', 'dont_show_in' => 'contact-us.php'));
$infinite_page_meta->addTextArea($prefix.'call_to_action_text', array('name' => 'Call To Action text', 'desc' => 'Call to Action text', 'page_template' => 'frontpage-template.php', 'dont_show_in' => 'contact-us.php'));
$infinite_page_meta->addText($prefix.'call_to_action_url', array('name' => 'Call To Action URL', 'desc' => 'Call to Action URL', 'page_template' => 'frontpage-template.php', 'dont_show_in' => 'contact-us.php'));
$infinite_page_meta->addText($prefix.'call_to_action_url_text', array('name' => 'Call To Action URL text', 'desc' => 'Call to Action URL text', 'page_template' => 'frontpage-template.php', 'dont_show_in' => 'contact-us.php'));


$infinite_page_meta->addSelect($prefix.'show_services', $yesNo , array('name'=> 'Show Services','desc' => 'Do you want to show Services in this page ?', 'page_template' => 'frontpage-template.php', 'dont_show_in' => 'contact-us.php'));
$infinite_page_meta->addService($prefix.'services_info', array('name'=> 'Services','desc' => '', 'page_template' => 'frontpage-template.php', 'dont_show_in' => 'contact-us.php'));

$infinite_page_meta->addTaxonomy($prefix.'include_categories',array('taxonomy' => 'category', 'type' => 'checkbox_list'),array('name'=> 'Include Categories','desc' => 'Select the categories you want to show the posts from, if you want to display posts from all categories, dont check anything', 'page_template' => 'blog-grid.php,blog-normal.php', 'dont_show_in' => 'contact-us.php'));

$infinite_page_meta->Finish();


//Initiate meta box for posts
$infinite_post_meta =  new AT_Meta_Box($meta_post_config);

$infinite_post_meta->addSelect($prefix.'show_sidebar', $yesNo , array('name'=> 'Display Sidebar','desc' => 'Do you want to display the sidebar for this page ?'));
$infinite_post_meta->addSelect($prefix.'show_flex_slideshow', $yesNo , array('name'=> 'Display Flex Slideshow','desc' => 'Do you want to display the Flex slider slideshow for the attached images in this page ?'));

$infinite_post_meta->Finish();

?>