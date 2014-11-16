<?php 


	$link_color = of_get_option('link_color','#289dcc');
	$link_color_dark = of_get_option('link_color_dark', '#333333');
	$link_color_light = infinite_colourBrightness($link_color, 0.60);
	$border_color = of_get_option('border_color','#e5e5e5');
	$text_color = of_get_option('text_color', '#6a6767');
	$dark_text = infinite_colourBrightness($text_color, -0.85);
	$background = of_get_option('page_bg_image','');
?>
<style type="text/css">

	body {
		font: 13px/1.4em 'Open Sans' sans ;
		color: <?php echo $text_color ?>;
		<?php if(of_get_option('page_bg_image')):; ?>
		background: url(<?php echo $background ?>) <?php echo of_get_option('page_bg_repeat','repeat') ?> center center <?php echo of_get_option('page_bg_position') ?> <?php echo of_get_option('page_bg_color') ?>;
		<?php else: ?>
		<?php if(of_get_option('page_pattern','dark_wood') == '')
		$bgImage = 'dark_wood';
		else
		$bgImage = of_get_option('page_pattern','dark_wood');
		?>
		background: url(<?php echo get_template_directory_uri() . '/images/patterns/'.$bgImage.'.png'  ?>) <?php echo of_get_option('page_bg_repeat','repeat') ?> center center <?php echo of_get_option('page_bg_position') ?> <?php echo of_get_option('page_bg_color') ?>;
		<?php endif; ?>
	}

	h1{
		font-size: <?php echo of_get_option('heading_font_size','22') ?>px;
	}

	h1, h2, h3, h4, h5, h6 {
		font-family: 'Open Sans' sans ;
	}

	#title-container{
		background: <?php echo of_get_option('title_bg_image') ? 'url('.of_get_option('title_bg_image').') no-repeat' : ''; ?> <?php echo of_get_option('title_bg_color','#f9f8f8'); ?>;
		background-size: cover;
	}

	a, p a, span a, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
		color: <?php echo $link_color_dark ?>;
	}

	a:hover,p a:hover,span a:hover,h1 a:hover,h2 a:hover,h3 a:hover,h4 a:hover,h5 a:hover,h6 a:hover {
		color: <?php echo $link_color ?>;
	}
	a.tag{
		background: <?php echo $text_color ?>;
	}

	.action-icon,a .action-icon {
		display: inline-block;
	}

	.main-menu ul .current-menu-item > a,
	.main-menu ul .current-menu-ancestor > a,
	.main-menu ul .current-menu-parent > a {
		border-top: 3px solid <?php echo $link_color ?>;
		color: <?php echo $link_color ?>;
	}
	.main-menu ul > li .current-menu-item > a,
	.main-menu ul > li .current-menu-ancestor > a,
	.main-menu ul > li .current-menu-parent > a {
		color: <?php echo $link_color ?>;
	}
	.main-menu ul > li a:hover {
		color: <?php echo $link_color ?>;
	}
	.main-menu ul > li ul {
		border-top: 3px solid <?php echo $link_color ?>;
	}
	.main-menu ul > li ul li ul {
		border-top: 3px solid <?php echo $link_color ?>;
		border-bottom: 1px solid <?php echo $border_color ?>;
	}
	.main-menu ul > li:hover > a {
		border-color: <?php echo $link_color ?>;
	}
	#menu-item-search a.active-icon {
		background: <?php echo $link_color ?>;
		color: #fff;
	}
	.main-menu-small > ul li a:hover {
		color: #fff;
		background-color: <?php echo $link_color ?>;
	}
	.action,
	.post-content blockquote {
		border-left: 2px solid <?php echo $link_color ?>;
	}
	.action-icon.normal {
		color: <?php echo $link_color ?>;
		border: 3px solid <?php echo $link_color ?>;
	}
	.action-icon.normal:after {
		background: <?php echo $link_color ?>;
	}
	.action-icon.normal:hover {
		background: <?php echo $link_color ?>;
	}
	a.tag:hover {
		background: <?php echo $link_color ?>;
	}

	.main-footer a.tag:hover {
		background: <?php echo $link_color ?>;
	}
	.post-grid .post-image .icon-search,
	.recent-post .post-image .icon-search {
		background: <?php echo $link_color ?>;
	}
	.post-two-column .post-image .icon-search,
	.post-three-column .post-image .icon-search,
	.post-four-column .post-image .icon-search,
	.post-half .post-image .icon-search {
		background: <?php echo $link_color ?>;
	}
	.post-content strong {
		color: <?php echo $link_color ?>;
	}
	.pagination a {
		color: <?php echo $link_color ?>;
	}
	.social-icon-container .social-icon:hover {
		color: #fff;
		background: <?php echo $link_color ?>;
	}
	#portfolio_filter li a.active, #portfolio_filter li a:hover {
		background: <?php echo $link_color ?>;
	}

	.post-content ul .portfolio-grid-alt-item{
		list-style-type: none;
	}

	#portfolio_filter li {
		list-style-type: none;
	}

	.pricing-table .header h2 {
		background: <?php echo $link_color ?>;
	}
	.data-table table tr th {
		background: <?php echo $link_color ?>;
	}
	.dropcap {
		color: <?php echo $link_color ?>;
	}
	.normal .nav-tabs :after {
		background: <?php echo $link_color ?>;
	}
	.normal .nav-tabs > li.active {
		background: <?php echo $link_color ?>;
	}
	.tabs-left.normal .nav-tabs :after {
		background: <?php echo $link_color ?>;
	}
	.tabs-left.normal .nav-tabs > li.active:last-child {
		border-bottom: <?php echo $link_color ?>;
	}
	.normal .nav-tabs.nav-tabs-mob > li.active:last-child {
		border-bottom: <?php echo $link_color ?>;
	}
	.accordion .accordion-group .accordion-heading a.expanded {
		/*color: <?php echo $link_color ?>;*/
	}
	.infinite-twitter li .tweet-actions .twitter-reply:hover,
	.infinite-twitter li .tweet-actions .twitter-retweet:hover,
	.infinite-twitter li .tweet-actions .twitter-favorite:hover {
		color: <?php echo $link_color ?>;
	}
	.tp-title span:nth-child(2) {
		color: <?php echo $link_color ?>;
	}
	.no-touch .back:hover {
		background: <?php echo $link_color ?>;
	}
	.cbp_tmtimeline > li .cbp_tmlabel .post-image a .icon-search {
		background: <?php echo $link_color ?>;
	}
	.dl-menuwrapper button,
	.dl-menuwrapper button.dl-active,
	.dl-menuwrapper ul {
		background: <?php echo $link_color ?>;
	}
	.dl-menuwrapper button:hover{
		background: <?php echo infinite_colourBrightness($link_color, 0.8); ?>;	
	}

	/*BORDERS*/
	.main-header .container-wrapper {
		border-bottom: 1px solid <?php echo $border_color ?>;
	}
	.main-menu ul > li ul li {
		border-bottom: 1px solid <?php echo $border_color ?>;
	}
	.main-menu ul > li ul li ul {
		border-top: 3px solid <?php echo $link_color ?>;
		border-bottom: 1px solid <?php echo $border_color ?>;
	}
	#menu-item-search form {
		border: 1px solid <?php echo $border_color ?>;
	}
	#menu-item-search form .arrow-up:before {
		border-bottom-color: <?php echo $border_color ?>;
	}
	#menu-item-search form input {
		border: 1px solid <?php echo $border_color ?>;
	}
	#title-container {
		border-bottom: 1px solid <?php echo $border_color ?>;
	}
	#main-slider,
	.camera_slider.camera_wrap {
		border-bottom: 1px solid <?php echo $border_color ?>;
	}
	.post-grid,
	.recent-post {
		border: 1px solid <?php echo $border_color ?>;
	}
	.pagination.post-pagination {
		border-top: 1px solid <?php echo $border_color ?>;
	}
	.pagination.post-pagination a{
		color: <?php echo $dark_text ?>
	}
	.pagination.post-pagination a:hover {
		color: <?php echo $link_color ?>;
	}
	#comments #reply-title, .post-comments-heading h2 {
		border-top: 1px solid <?php echo $border_color ?>;
	}
	.portfolio-grid-alt-bg {
		border: 1px solid <?php echo $border_color ?>;
	}
	.pricing-table .price-item {
		border: 1px solid <?php echo $border_color ?>;
	}
	.pricing-table ul li {
		border-bottom: 1px solid <?php echo $border_color ?>;
	}
	.pricing-table .price h2 {
		border-bottom: 1px solid <?php echo $border_color ?>;
	}
	.data-table table {
		border: 1px solid <?php echo $border_color ?>;
	}
	.data-table table tr td {
		border-bottom: 1px solid <?php echo $border_color ?>;
	}
	.tab-container {
		border: 1px solid <?php echo $border_color ?>;
	}
	.testimonial .popover {
		border: 1px solid <?php echo $border_color ?>;
	}
	.gallery-container .gallery-item {
		border: 1px solid <?php echo $border_color ?>;
	}
	.cbp_tmtimeline > li .cbp_tmlabel {
		border: 1px solid <?php echo $border_color ?>;
	}
	.cbp_tmtimeline > li .cbp_tmlabel h2 {
		border-bottom: 1px solid <?php echo $border_color ?>;
	}
	.cbp_tmtimeline > li .cbp_tmlabel:before {
		border-right-color: <?php echo $border_color ?>;
	}
	.call-to-action {
		border-top: 1px solid <?php echo $border_color ?>;
	}

	<?php $lightBorder =  infinite_colourBrightness($border_color, 0.60); ?>

	hr.fancy {
		background: <?php echo $border_color ?>;
		background-image: -webkit-linear-gradient(left, <?php echo $lightBorder  ?>, <?php echo $border_color ?>, <?php echo $lightBorder  ?>);
		background-image: -moz-linear-gradient(left, <?php echo $lightBorder  ?>, <?php echo $border_color ?>,<?php echo $lightBorder  ?>);
		background-image: -o-linear-gradient(left, <?php echo $lightBorder  ?>, <?php echo $border_color ?>, <?php echo $lightBorder  ?>);
		background-image: -ms-linear-gradient(left, <?php echo $lightBorder  ?>, <?php echo $border_color ?>, <?php echo $lightBorder  ?>);
		background-image: linear-gradient(left, <?php echo $lightBorder  ?>, <?php echo $border_color ?>, <?php echo $lightBorder  ?>);
	}


	<?php $btnDark = infinite_colourBrightness($link_color, -0.85); ?>

	.button, #submit {
		background: <?php echo $link_color ?>;
		box-shadow: 0 6px <?php echo $btnDark ?>;
	}

	.button:hover, #submit:hover {
		background: <?php  echo infinite_colourBrightness($link_color, -0.92); ?>;
		box-shadow: 0 4px <?php echo $btnDark; ?>;
	}

	.button-:active, #submit:active {
		box-shadow: 0 2px <?php echo $btnDark; ?>;
		top: 6px;
	}


	.post .post-meta,
	.post-half .post-meta,
	article.page .post-meta,
	article.post-normal .post-meta {
		color: <?php echo $dark_text ?>;
	}

	.post-date{
		color: <?php echo $dark_text ?>;
	}

	.copyright a{
		color: #c5c5c5;
	}

	.copyright a:hover{
		color: #ffffff;
	}

	#cboxClose{
		border: none;
	}

	#comments .post-comments-form input[type=text]:focus,
	#comments #post-comments-form input[type=text]:focus,
	#comments .post-comments-form textarea:focus,
	#comments #post-comments-form textarea:focus,
	{
	  border-color: <?php echo $link_color_light ?>;
	}



	.button.logout-link{
		color: <?php echo $link_color_dark ?>;
	}
	.button.logout-link:hover{
		color: <?php echo $link_color ?>;
	}


	@media (max-width: 767px){
		.cbp_tmtimeline > li .cbp_tmlabel:before {
			border-right-color: transparent;
		}
	}

	
	<?php if(is_admin_bar_showing()) :; ?>
	.fixed-header .main-header{
	<?php if(floatval($wp_version) >= 3.8) : ?>
		top: 32px;
	<?php else: ?>
		top: 28px;
	<?php endif ?>
	}
	<?php else:; ?>
	.fixed-header-fix{
		height: 67px;
	}
	<?php endif ?>

	<?php if(of_get_option('custom_css')) echo of_get_option('custom_css'); ?>

</style>