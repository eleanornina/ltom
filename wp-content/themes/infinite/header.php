<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js" >
<head>
	<meta charset="<?php bloginfo('charset') ?>">
	<title><?php wp_title() ?></title>

	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<?php wp_head() ?>

</head>

<body <?php body_class(); ?>> 
<div id="<?php echo of_get_option('layout_type', 'fluid-layout')  ?>" class="<?php echo of_get_option('header_layout', 'fixed-header') ?>">
	<header class="main-header clearfix">
		<div class="container-wrapper">
			<div class="container">
				<div class="row">
					<div class="span3 logo-container">
						<h1 class="logo">
							<a href="<?php echo esc_url( home_url( '/' ) ) ?>">
								<?php $logo = of_get_option('logo', ''); ?>
								<?php if($logo != ''): ?>
									<img src="<?php echo esc_url($logo) ?>" alt="<?php bloginfo('name') ?> | <?php bloginfo('description') ?>">
								<?php else: ?>
									<div class="site-title"><?php echo get_bloginfo( 'name' ) ?></div>
								<?php endif; ?>
							</a>
						</h1>
					</div> <!-- end span3 -->
					<div class="span9 menu-container">
						<nav class="main-menu">
							<?php wp_nav_menu(array(
								'theme_location' => 'main-menu'
							)); ?>
						</nav> <!-- end nav -->

						<!-- Mobile Menu -->
						<div class="main-menu-sma dl-menuwrapper" id="dl-menu">
							<button class="dl-trigger"><?php _e('Open Menu','infinite-framework') ?></button>
							<?php wp_nav_menu(array(
								'theme_location' => 'main-menu',
								'menu_class' => 'dl-menu',
								'container' => false,
								'walker' => new infinite_mob_menu()
							)); ?>
						</div>

					</div> <!-- end span9 -->
				</div><!-- end row -->
			</div> <!-- end container -->
			<?php do_action('infinite_main_header'); ?>
		</div> <!-- end container-wrapper -->
	</header> <!-- end header -->

<div class="container-wrapper clearfix fixed-header-fix">
	<div class="container">
		<div class="row">
		</div>
	</div>
</div>

<?php if(is_home() && !is_front_page()): ?>
	<div class="container-wrapper" id="title-container">
		<div class="container title-container">
			<div class="row">
				<div class="span4"><h3><?php the_title(); ?></h3></div>
				<div class="span8">
					<?php infinite_breadcrumb();	 ?>
				</div>
			</div>
		</div>
	</div>

<?php elseif(is_single()): ?>
	<div class="container-wrapper" id="title-container">
		<div class="container title-container">
			<div class="row">
				<div class="span4"><h3><?php the_title(); ?></h3></div>
				<div class="span8">
					<?php infinite_breadcrumb();	 ?>
				</div>
			</div>
		</div>
	</div>

<?php elseif(is_search()): ?>
	<div class="container-wrapper" id="title-container">
		<div class="container title-container">
			<div class="row">
				<div class="span4"><h3><?php _e('Search results for: ', 'infinite-framework'); ?> <?php echo get_search_query(); ?></h3></div>
				<div class="span8">
					<?php infinite_breadcrumb();	 ?>
				</div>
			</div>
		</div>
	</div>

<?php elseif(is_archive()): ?>
	<div class="container-wrapper" id="title-container">
		<div class="container title-container">
			<div class="row">
				<div class="span4"><h3><?php single_cat_title(); ?></h3></div>
				<div class="span8">
					<?php infinite_breadcrumb();	 ?>
				</div>
			</div>
		</div>
	</div>

<?php endif; ?>