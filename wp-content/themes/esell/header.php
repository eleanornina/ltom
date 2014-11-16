<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="wrapper">
<!-- BEGIN HEADER -->
	<div id="header">
    <div id="header-inner" class="clearfix">
		<div id="logo">
			<?php if (of_get_option( 'esell_logo' )): ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo of_get_option( 'esell_logo' ); ?>"  alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/></a>
      			<?php else : ?>        
            <h1 class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
      
    <?php endif; ?>
	
		</div>
		<?php if (class_exists('woocommerce')) {load_template(get_template_directory() . '/wooacc.php'); }else { ?><div id="search"><?php get_search_form(); ?></div><?php } ?> 
				
	    </div> 	</div> 
	<!-- BEGIN TOP NAVIGATION -->		
	<div id="navigation" class="nav"> 
    <div id="navigation-inner" class="clearfix">
	<div class="secondary">
<div id="logo">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="http://www.eleanornina.com/littletouchofmagic/wp-content/uploads/2014/10/ltom_logo.gif"/></a>
</div>		<?php wp_nav_menu(array('container' => '', 'theme_location' => 'esell-navigation', 'fallback_cb' => 'esell_hdmenu')); ?>
		</div>
	
		</div></div>