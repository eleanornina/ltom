<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = wp_get_theme();
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'esell'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	$test_array = array(
		'4' => __('4', 'esell'),
		'8' => __('8', 'esell'),
		'12' => __('12', 'esell'),
		'16' => __('16', 'esell'),
		'20' => __('20', 'esell')
	);

	$test_arraycol = array(
		'1' => __('1', 'esell'),
		'2' => __('2', 'esell'),
		'3' => __('3', 'esell'),
		'4' => __('4', 'esell'),
		'5' => __('5', 'esell')
	);


	$multicheck_array = array(
		'one' => __('French Toast', 'esell'),
		'two' => __('Pancake', 'esell'),
		'three' => __('Omelette', 'esell'),
		'four' => __('Crepe', 'esell'),
		'five' => __('Waffle', 'esell')
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);
	
	

	// Background Defaults
	$background_defaults = array(
		'color' => '#F3F3F3',
		'image' => '',
		'repeat' => 'repeat',
		'attachment'=>'scroll' );


	// Typography Defaults
	$typography_defaults = array(
		'size' => '13px',
		'face' => 'false',
		'style' => 'normal',
		'color' => '#555555' );
		
	$typography_entrytitle = array(
		'size' => '28px',
		'face' => 'false',
		'style' => 'normal',
		'color' => '#555555' );
	$typography_bottomheading = array(
		'size' => '20px',
		'face' => 'false',
		'style' => 'normal',
		'color' => '#012351' );
	$typography_bottomdesc = array(
		'size' => '13px',
		'face' => 'false',
		'style' => 'normal',
		'color' => '#76AB19' );
		
	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => false,
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	$options = array();
 $options[] = array(
 'desc' => '<h2 style="color: #FFF !important;">' . esc_attr__( 'Upgrade to Premium Theme & Enable Full Features!', 'esell' ) . '</h2>
            <li>' . esc_attr__( 'SEO Optimized WordPress Theme.', 'esell' ) . '</li>
            <li>' . esc_attr__( 'More Slides for your slider.', 'esell' ) . '</li>
            <li>' . esc_attr__( 'Theme Customization help & Support Forum.', 'esell' ) . '</li>
            <li>' . esc_attr__( 'Page Speed Optimize for better result.', 'esell' ) . '</li>
            <li>' . esc_attr__( 'Color Customize of theme.', 'esell' ) . '</li>
            <li>' . esc_attr__( 'Custom Widgets and Functions.', 'esell' ) . '</li>
            <li>' . esc_attr__( 'Social Media Integration.', 'esell' ) . '</li>
            <li>' . esc_attr__( 'Responsive Website Design.', 'esell' ) . '</li>
            <li>' . esc_attr__( 'Different Website Layout to Select.', 'esell' ) . '</li>
            <li>' . esc_attr__( 'Many of Other customize feature for your blog or website.', 'esell' ) . '</li>
            <p><span class="buypre"><a href="' . esc_url(__('http://www.insertcart.com/esell','esell')) . '" target="_blank">' . esc_attr__( 'Upgrade Now', 'esell' ) . '</a></span><span class="buypred"><a href="' . esc_url(__('http://www.wrock.org/setup-esell-woocommerce-premium-theme-guide/','esell')) . '" target="_blank">' . esc_attr__( 'How to Setup Theme !', 'esell' ) . '</a></span></p>',
            'class' => 'tesingh',
            'type' => 'info');

	
	$options[] = array(
		'name' => __('Basic Settings', 'esell'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('Custom Favicon URL', 'esell'),
		'desc' => __('Upload Favicon Image.', 'esell'),
		'id' => 'esell_favicon',
		'std' => '',
		'type' => 'upload');
	$options[] = array(
		'name' => __('Upload Site Logo', 'esell'),
		'desc' => __('Upload Website Logo here. Note you can upload any size it will automatic resize .', 'esell'),
		'class' => 'sesell_logo',
		'id' => 'esell_logo',
		'type' => 'upload'
		);

	$options[] = array(
		'name' => __('Show Author Profile', 'esell'),
		'desc' => __('Check the box to show Author Profile Below the Post and Pages.', 'esell'),
		'id' => 'esell_author',
		'std' => '',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Show Latest Posts in Sidebar', 'esell'),
		'desc' => __('Show 5 Latest Posts with Thumbnail in Sidebar.', 'esell'),
		'id' => 'esell_activate_ltposts',
		'std' => '1',
		'type' => 'checkbox');
	
	
		$options[] = array(
		'name' => __('Home Page', 'esell'),
		'type' => 'heading');
		$options[] = array(
		'name' => __('Show blog posts on front page', 'esell'),
		'desc' => __('Check the box to show 5 posts on front page.', 'esell'),
		'id' => 'esell_frontposts',
		'std' => 'on',
		'type' => 'radio',
		'options' => array(
						'on' => 'Show',
						'off' => 'Hide'
						));
		$options[] = array(
		'name' => __('Configure Main Featured Are with Image', 'esell'),
		'desc' => __('Enter Title', 'esell'),
		'id' => 'esell_slidtext1',
		'std' => 'You Main Headline here',
		'type' => 'text');
		$options[] = array(
		'desc' => __('Enter Link', 'esell'),
		'id' => 'esell_slidlink1',
		'std' => '',
		'type' => 'text');
		$options[] = array(
		'id' => 'esell_slidimg1',
		'type' => 'upload');
		$options[] = array(
		'desc' => __('Put description about image or product here.', 'esell'),
		'id' => 'esell_slidedesc',
		'std' => 'Set you description here from theme options > home page link to any page and upload image here. This is only for demonstration purpose you can set your own description here. ',
		'type' => 'textarea');
		
		$options[] = array(
		'name' => __('Bottom Column 1 Configure ', 'esell'),
		'desc' => __('Column 1 Heading 1', 'esell'),
		'id' => 'esell_columnh1',
		'std' => 'Column Title here',
		'type' => 'text');
		$options[] = array(
		'id' => 'esell_colimg1',
		'type' => 'upload');
		$options[] = array(
		'desc' => __('Put description about image or product here.', 'esell'),
		'id' => 'esell_columndesc1',
		'std' => 'Put description or feature detail here from theme option > home page and customize fonts',
		'type' => 'textarea');
		$options[] = array(
		'desc' => __('Column 1 Heading 2', 'esell'),
		'id' => 'esell_columnh2',
		'std' => 'Column Title here',
		'type' => 'text');
		$options[] = array(
		'id' => 'esell_colimg2',
		'type' => 'upload');
		$options[] = array(
		'desc' => __('Put description about image or product here.', 'esell'),
		'id' => 'esell_columndesc2',
		'std' => 'Put description or feature detail here from theme option > home page and customize fonts',
		'type' => 'textarea');
		$options[] = array(
		'name' => __('Bottom Column 2 Configure ', 'esell'),
		'desc' => __('Column 2 Heading 1', 'esell'),
		'id' => 'esell_columnh3',
		'std' => 'Column title here',
		'type' => 'text');
		$options[] = array(
		'id' => 'esell_colimg3',
		'type' => 'upload');
		$options[] = array(
		'desc' => __('Put description about image or product here.', 'esell'),
		'id' => 'esell_columndesc3',
		'std' => 'Put description or feature detail here from theme option > home page and customize fonts',
		'type' => 'textarea');
		$options[] = array(
		'desc' => __('Column 2 Heading 2', 'esell'),
		'id' => 'esell_columnh4',
		'std' => 'Column Title here',
		'type' => 'text');
		$options[] = array(
		'id' => 'esell_colimg4',
		'type' => 'upload');
		$options[] = array(
		'desc' => __('Put description about image or product here.', 'esell'),
		'id' => 'esell_columndesc4',
		'std' => '',
		'type' => 'textarea');
		$options[] = array(
		'name' => __('Bottom Column 3 Configure ', 'esell'),
		'desc' => __('Column 3 Heading', 'esell'),
		'id' => 'esell_columnh5',
		'std' => 'Column Title here',
		'type' => 'text');
		$options[] = array(
		'id' => 'esell_colimg5',
		'type' => 'upload');
		$options[] = array(
		'desc' => __('Put description about image or product here.', 'esell'),
		'id' => 'esell_columndesc5',
		'std' => 'Put description or feature detail here from theme option > home page and customize fonts',
		'type' => 'textarea');
		$options[] = array(
		'desc' => __('Column 3 Heading 2', 'esell'),
		'id' => 'esell_columnh6',
		'std' => 'Column Title here',
		'type' => 'text');
		$options[] = array(
		'id' => 'esell_colimg6',
		'type' => 'upload');
		$options[] = array(
		'desc' => __('Put description about image or product here.', 'esell'),
		'id' => 'esell_columndesc6',
		'std' => 'Put description or feature detail here from theme option > home page and customize fonts',
		'type' => 'textarea');
		
		
		$options[] = array(
		'desc' => __('<span class="pre-titlehome">Color Cutomize (Premium Only)</span>'), 
		'type' => 'info');
		$options[] = array(
		'name' => __('Numbers of Featured Woocommerce Products', 'esell'),
		'desc' => __('Select how many product (Featured products)you want to display on front page Default: 8', 'esell'),
		'id' => 'esell_wooproducts',
		'std' => '8',
		'type' => 'select',
		'class' => 'tiny', //mini, tiny, small
		'options' => $test_array);
		$options[] = array(
		'desc' => __('Product Per column default : 4', 'esell'),
		'id' => 'esell_wooproductscol',
		'std' => '4',
		'type' => 'select',
		'class' => 'tiny', //mini, tiny, small
		'options' => $test_arraycol);
		$options[] = array(
		'name' => __('Info and Demo Button text', 'esell'),
		'desc' => __('Change Info and Demo Button text from woocommerce product', 'esell'),
		'id' => 'esell_moreinfo',
		'std' => '+ Info & Demo',
		'class' => 'mini',
		'type' => 'text');
		$options[] = array(
		'name' => __('Top Account navigation Color', 'esell'),
		'desc' => __('My Account Background Color.', 'esell'),
		'id' => 'esell_myaccount',
		'std' => '#39E083',
		'type' => 'color' );
		$options[] = array(
		'desc' => __('Cart Item Background Color.', 'esell'),
		'id' => 'esell_mycart',
		'std' => '#F64E4E',
		'type' => 'color' );
		
		$options[] = array(
		'name' => __('Main features Product area', 'esell'),
		'desc' => __('Main features product backgroud color Change.', 'esell'),
		'id' => 'esell_esellallpages',
		'std' => '#ffffff',
		'type' => 'color' );
		$options[] = array(
		'desc' => __('Change Background color of 3 bottom info area.', 'esell'),
		'id' => 'esell_info',
		'std' => '#ffffff',
		'type' => 'color' );
		$options[] = array( 'name' => __('Customize Theme Fonts', 'esell'),
		'desc' => __('Change Fonts Color and size of 3 info boxes.', 'esell'),
		'id' => "esell_bottomheading",
		'std' => $typography_bottomheading,
		'type' => 'typography' );
		$options[] = array( 
		'desc' => __('Change description color and size of 3 boxes', 'esell'),
		'id' => "esell_bottomdesc",
		'std' => $typography_bottomdesc,
		'type' => 'typography'
		);
		
$options[] = array(
		'name' => __('Social Media', 'esell'),
		'type' => 'heading');
		$options[] = array(
		'name' => __('Show share buttons on Top Navigation', 'esell'),
		'desc' => __('Check or uncheck Box to show and hide share buttons', 'esell'),
		'id' => 'esell_sharebut',
		'std' => '1',
		'type' => 'checkbox');
		$options[] = array(
		'name' => __('Facebook Link', 'esell'),
		'desc' => __('Enter your Facebook URL if you have one.', 'esell'),
		'id' => 'esell_fb',
		'std' => '',
		'type' => 'text');
		$options[] = array(
		'name' => __('Twitter Follow Link', 'esell'),
		'desc' => __('Enter your Twitter URL if you have one.', 'esell'),
		'id' => 'esell_tw',
		'std' => '',
		'type' => 'text');
		$options[] = array(
		'name' => __('YouTube Channel Link', 'esell'),
		'desc' => __('Enter your YouTube URL if you have one.', 'esell'),
		'id' => 'esell_youtube',
		'std' => '',
		'type' => 'text');
		$options[] = array(
		'name' => __('Google+ URL', 'esell'),
		'desc' => __('Enter your Google+ Link if you have one.', 'esell'),
		'id' => 'esell_gp',
		'std' => '',
		'type' => 'text');
		$options[] = array(
		'name' => __('RSS Feed URL', 'esell'),
		'desc' => __('Enter your RSS Feed URL if you have one', 'esell'),
		'id' => 'esell_rss',
		'std' => '',
		'type' => 'text');
		$options[] = array(
		'name' => __('Linked In URL', 'esell'),
		'desc' => __('Enter your Linkedin URL if you have one.', 'esell'),
		'id' => 'esell_in',
		'std' => '',
		'type' => 'text');
		$options[] = array(
		'name' => __('Pinterest In URL', 'esell'),
		'desc' => __('Enter your Pinterest URL if you have one.', 'esell'),
		'id' => 'esell_pinterest',
		'std' => '',
		'type' => 'text');
		$options[] = array(
		'name' => __('Email Address to Contact', 'esell'),
		'desc' => __('Enter your email address if you have one', 'esell'),
		'id' => 'esell_email',
		'std' => '',
		'type' => 'text');
		$options[] = array(
		'name' => __('Stumbleupon In URL', 'esell'),
		'desc' => __('Enter your Stumbleupon  address if you have one', 'esell'),
		'id' => 'esell_stumbleupon',
		'std' => '',
		'type' => 'text');
		
		

		
$options[] = array(
		'name' => __('Custom Styling', 'esell'),
		'type' => 'heading');
	$options[] = array(
		'name' => __('Custom CSS', 'esell'),
		'desc' => __('Quickly add some CSS to your theme by adding it to this block.', 'esell'),
		'id' => 'esell_customcss',
		'std' => '',
		'type' => 'textarea');
		
$options[] = array(
		'name' => __('Ads Management', 'esell'),
		'type' => 'heading');
	$options[] = array(
		'name' => __('Paste Ads code below navigation', 'esell'),
		'desc' => __('Activate Ads Space Below Navigation and put code in below test field.', 'esell'),
		'id' => 'esell_banner_top',
		'std' => '',
		'type' => 'textarea');
	$options[] = array(
		 'name' => __( 'AD Code For Single Post', 'esell' ),
            'desc' => 'Paste Ad code for single post it show ads below post title and before content.',
            'id' => 'esell_ad2',
            'std' => '',
            'type' => 'textarea');
     $options[] = array(
		'name' => __( 'AD Code For Footer', 'esell' ),
		'desc' => __('Paste Ad Code for Footer Area.', 'esell'),
            'id' => 'esell_ad1',
            'std' => '',
            'type' => 'textarea');	
		
$options[] = array(
		'name' => __('Advance Options', 'esell'),
		'type' => 'heading');
	
				
		$options[] = array(
		'desc' => __('<span class="pre-title">New Features [Pro Only]</span>'), 
		'type' => 'info');
		
		$options[] = array(
		'name' => __('Popular Posts in Sidebar', 'esell'),
		'desc' => __('Display Popular Post Sidebar Widget.', 'esell'),
		'id' => 'esell_popular',
		'std' => '0',
		'type' => 'checkbox');
		$options[] = array(
		'name' => __('Floating Share Buttons', 'esell'),
		'desc' => __('Display Floating Share widget with count.', 'esell'),
		'id' => 'esell_flowshare',
		'std' => '0',
		'type' => 'checkbox');
		
		$options[] = array(
		'name' => __('Responsive Website Design', 'esell'),
		'desc' => __('Enable Responsive Design for you website to increase experience on Mobile Devices', 'esell'),
		'id' => 'esell_responsive',
		'std' => '0',
		'type' => 'checkbox');
		$options[] = array(
		'name' => __('Display navigation step in Woocommerce ', 'esell'),
		'desc' => __('Show or Hide navigation step in Woocommerce (1: Add to cart 2: View Cart 3: proceed to checkout 4: Detail & Payment 5: Get Product !).', 'esell'),
		'id' => 'esell_pronaviinfo',
		'std' => 'on',
		'type' => 'radio',
		'options' => array(
						'on' => 'Show',
						'off' => 'Hide'
						));
		$options[] = array(
		'name' => __('Excerpt Length (Number of words display in post description)', 'esell'),
		'desc' => __('Number of words display in every post description Default is 45.', 'esell'),
		'id' => 'esell_excerp',
		'std' => '45',
		'class' => 'mini',
		'type' => 'text');
		$options[] = array(
		'name' =>  __('Change Background', 'esell'),
		'desc' => __('Change the background CSS Color or Image.', 'esell'),
		'id' => 'esell_bg',
		'std' => $background_defaults,
		'type' => 'background' );
		$options[] = array(
		'desc' => __('Change background color of content area.', 'esell'),
		'id' => 'esell_pageinner',
		'std' => '#ffffff',
		'type' => 'color' );
		$options[] = array(
		'name' => __('Change Link Color', 'esell'),
		'desc' => __('Select Links Color.', 'esell'),
		'id' => 'esell_linkcolor',
		'std' => '#2D89A7',
		'type' => 'color' 
);
		$options[] = array(
		'desc' => __('Change Link Hover Color.', 'esell'),
		'id' => 'esell_linkhover',
		'std' => '#E44C4C',
		'type' => 'color' );
		$options[] = array(
		'name' => __('Top Navigation Colors', 'esell'),
		'desc' => __('Main Navigation Background.', 'esell'),
		'id' => 'esell_mainnavibg',
		'std' => '#333',
		'type' => 'color' );
		
		$options[] = array(
		'desc' => __('Main Navigation hover Color.', 'esell'),
		'id' => 'esell_mainnavilinkcolor',
		'std' => '#2C343F',
		'type' => 'color' );
		$options[] = array(
		'name' => __('Home Icon from Top and Main Navigation', 'esell'),
		'desc' => __('Show or Hide Home Icon.', 'esell'),
		'id' => 'esell_homeicon',
		'std' => 'on',
		'type' => 'radio',
		'options' => array(
						'on' => 'Show',
						'off' => 'Hide'
						));
		
		$options[] = array(
		'name' => __('Page Number Navigation Color Change ', 'esell'),
		'desc' => __('Change Current Page Background.', 'esell'),
		'id' => 'esell_pageanvibg',
		'std' => '#333',
		'type' => 'color' );
		$options[] = array(
		'desc' => __('Change background color of other pages.', 'esell'),
		'id' => 'esell_pageanvia',
		'std' => '#E44C4C',
		'type' => 'color' );
		$options[] = array(
		'desc' => __('Numbers text Color Change.', 'esell'),
		'id' => 'esell_pageanvilink',
		'std' => '#ffffff',
		'type' => 'color' );
		
		$options[] = array( 'name' => __('Customize Theme Fonts', 'esell'),
		'desc' => __('Change <b>Body (Theme) Font</b> color and Size.', 'esell'),
		'id' => "esell_bodyfonts",
		'std' => $typography_defaults,
		'type' => 'typography' );
		$options[] = array( 
		'desc' => __('Change <b>H1 Posts and Pages Title </b>Font color or Size.', 'esell'),
		'id' => "esell_entrytitle",
		'std' => $typography_entrytitle,
		'type' => 'typography' );
		$options[] = array(
		'name' => __('Footer Widget Area Settings', 'esell'),
		'desc' => __('Show or Hide Footer Widget Area.', 'esell'),
		'id' => 'esell_footerwidget',
		'std' => 'on',
		'type' => 'radio',
		'options' => array(
						'on' => 'Show',
						'off' => 'Hide'
						));
				
		$options[] = array(
		'name' => __('Edit "Read More" Button', 'esell'),
		'desc' => __('Show or Hide "Continue reading" or read more Button  Button .', 'esell'),
		'id' => 'esell_countinue',
		'std' => 'on',
		'type' => 'radio',
		'options' => array(
						'on' => 'Show',
						'off' => 'Hide'
						));
		$options[] = array(
		'desc' => __('Read More Button Color Change.', 'esell'),
		'id' => 'esell_readmorecolor',
		'std' => '#E44C4C',
		'type' => 'color' );					
		$options[] = array(
		    'desc' => __('Paste You Custom text for Continue reading <b>Default: Continue reading &raquo; </b>.', 'esell'),
            'id' => 'esell_fullstory',
            'std' => 'Read More &raquo;',
            'type' => 'text');				

		$options[] = array(
		'name' => __('Website layout', 'esell'),
		'desc' => __('Select Images for Website layout.', 'esell'),
		'id' => 'esell_layout',
		'std' => 's2',
		'type' => "images",
		'options' => array(
			's1' => $imagepath . 's1.png',
			'sl' => $imagepath . 'sl.png',
			'fc' => $imagepath . 'fc.png')
	);
		$options[] = array(
		'desc' => '<span class="pre-titleseo">SEO & Meta Options</span>', 
		'type' => 'info');
		$options[] = array(
		'name' => __('Google+ Publisher URL', 'esell'),
		'desc' => __('Paste Your Google Publisher URL https://plus.google.com/YOUR-GOOGLE+ID/posts.', 'esell'),
		'id' => 'esell_googlepub',
		'std' => '',
		'type' => 'text');
		$options[] = array(
		'name' => __('Bing Site Verification', 'esell'),
		'desc' => __('Enter the ID only. It will be verified by Yahoo as well.', 'esell'),
		'id' => 'esell_bingvari',
		'std' => '',
		'type' => 'text');
		$options[] = array(
		'name' => __('Google Site verification', 'esell'),
		'desc' => __('Enter your ID only.', 'esell'),
		'id' => 'esell_googlevari',
		'std' => '',
		'type' => 'text');
		
		
		$options[] = array(
		'desc' => '<span class="pre-titlecus">Customization</span>', 
		'type' => 'info');
		$options[] = array(
		'name' => __('Breadcrumbs Options', 'esell'),
		'desc' => __('Check Box to Enable or Disable Breadcrumbs.', 'esell'),
		'id' => 'esell_bread',
		'std' => '1',
		'type' => 'checkbox');
		$options[] = array(
		'name' => __('Enable Post Meta Info.', 'esell'),
		'desc' => __('Check Box to Show or Hide Tags ', 'esell'),
		'id' => 'esell_tags',
		'std' => '1',
		'type' => 'checkbox');
		$options[] = array(
		'desc' => __('Check Box to Show or Hide Comments ', 'esell'),
		'id' => 'esell_comments',
		'std' => '1',
		'type' => 'checkbox');
		$options[] = array(
		'desc' => __('Check Box to Show or Hide Categories ', 'esell'),
		'id' => 'esell_categrious',
		'std' => '1',
		'type' => 'checkbox');
		$options[] = array(
		'desc' => __('Check Box to Show or Hide Author and date ', 'esell'),
		'id' => 'esell_autodate',
		'std' => '1',
		'type' => 'checkbox');
			
		$options[] = array(
		'name' => __('Next and Previous Post Link', 'esell'),
		'desc' => __('Show or Hide Next and Previous Post Link below every post.', 'esell'),
		'id' => 'esell_links',
		'std' => 'on',
		'type' => 'radio',
		'options' => array(
						'on' => 'Show',
						'off' => 'Hide'
						));
		$options[] = array(
		'name' => __('Show or Hide Copy Right Text', 'esell'),
		'desc' => __('Show or Hide Copyright Text and Link.', 'esell'),
		'id' => 'esell_copyright',
		'std' => 'on',
		'type' => 'radio',
		'options' => array(
						'on' => 'Show',
						'off' => 'Hide'
						));
		$options[] = array(
'desc' => __('Paste Ad code for single post it show ads below post title and before content.','esell'),
            'id' => 'esell_ftarea',
            'std' => esc_attr__( 'Copyright  &#169; 2013 Theme by: ', 'esell' ) . '<a href="' . esc_url(__('http://www.insertcart.com/esell','esell')) . '" title="' . esc_attr__( 'insertcart.com', 'esell' ) . '">' . esc_attr__( 'insertcart.com', 'esell' ) . '</a>',
            'type' => 'textarea');
			

	return $options;
}