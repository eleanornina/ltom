<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}


/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	
	$options[] = array(
		'name' => __('General Settings', 'options_framework_theme'),
		'type' => 'heading');


	 $options[] = array( "name" => "Logo",
						"desc" => "The logo for the website - max width of 166px and min/max height of 66px",
						"id" => "logo",
						"type" => "upload",
						'std' => '');

	$options[] = array(
			'id' => 'custom_css',
			'type' => 'textarea',
			'name' => __('Custom CSS', 'nhp-opts'),
			'desc' => __('Just want to do some quick CSS changes? Enter them here, they will be applied to the theme.)', 'nhp-opts'),
			'validate' => 'html',
			);

	//APPEARANCE
	$options[] = array(
		'name' => __('Appearance', 'options_framework_theme'),
		'type' => 'heading');

	// //LAYOUT TYPE
	$options[] = array(
		'name' => __('Layout type - Boxed or Wide', 'options_framework_theme'),
		'desc' => __('The layout type you want, choose either Boxed or Wide', 'options_framework_theme'),
		'id' => 'layout_type',
		'std' => 'fluid-layout',
		'type' => 'select',
		'class' => 'mini',
		'options' => array(
						'fluid-layout' => __('Wide','options_framework_theme'),
						'boxed-layout' => __('Boxed','options_framework_theme')
						));


	$options[] = array(
	'name' => __('Show Related Posts in the single post page ?', 'options_framework_theme'),
	'desc' => __('Do you want to show the realted posts slider in the single post page ?', 'options_framework_theme'),
	'id' => 'related_posts',
	'std' => 'yes',
	'type' => 'select',
	'class' => 'mini',
	'options' => array(
					'yes' => __('Yes','options_framework_theme'),
					'no' => __('No','options_framework_theme')
					));



	$options[] = array(
	'name' => __('Enable Post Slideshows', 'options_framework_theme'),
	'desc' => __('Do you want to enable slideshows in posts ?', 'options_framework_theme'),
	'id' => 'post_slideshows',
	'std' => 'yes',
	'type' => 'select',
	'class' => 'mini',
	'options' => array(
					'yes' => __('Yes','options_framework_theme'),
					'no' => __('No','options_framework_theme')
					));


	$options[] = array(
		'name' => "Color Schemes",
		'desc' => "Select a color scheme",
		'id' => "color_scheme",
		'std' => "light-blue",
		'type' => "images",
		'options' => array(
			'alizarin' => get_template_directory_uri() . '/images/color_schemes/alizarin.jpg',
			'belize-hole' => get_template_directory_uri() . '/images/color_schemes/belize-hole.jpg',
			'emerald' => get_template_directory_uri() . '/images/color_schemes/emerald.jpg',
			'light-blue' => get_template_directory_uri() . '/images/color_schemes/light-blue.jpg',
			'nephritis' => get_template_directory_uri() . '/images/color_schemes/nephritis.jpg',
			'pink' => get_template_directory_uri() . '/images/color_schemes/pink.jpg',
			'pumpkin' => get_template_directory_uri() . '/images/color_schemes/pumpkin.jpg',
			'purple' => get_template_directory_uri() . '/images/color_schemes/purple.jpg',
			)
	);

    $options[] = array( "name" => "Accent/Theme Color (Link Color - Hover State)",
					    "desc" => "",
					    "id" => "link_color",
					    "std" => "#26ade5",
					    "type" => "text" );


	//SOCIAL ICONS
	$options[] = array(
		'name' => __('Social Media', 'options_framework_theme'),
		'type' => 'heading');


	$options[] = array(
		'name' => __('Facebook Link', 'options_framework_theme'),
		'id' => 'social_facebook',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Twitter Link', 'options_framework_theme'),
		'id' => 'social_twitter',
		'std' => '',
		'type' => 'text');


	$options[] = array(
		'name' => __('Google+ Link', 'options_framework_theme'),
		'id' => 'social_googleplus',
		'std' => '',
		'type' => 'text');


	$options[] = array(
		'name' => __('Linkedin Link', 'options_framework_theme'),
		'id' => 'social_linkedin',
		'std' => '',
		'type' => 'text');

	return $options;
}