<?php 
//Front page for you website set it from dashboard
//eSell WordPress Theme 

get_header(); ?>
<div id="page">
		<div id="frontpage" class="clearfix">
		<div class="esellallpages">		
	<?php echo ' <h1 class="align-left intro"><a href="'; echo esc_url(of_get_option('esell_slidlink1')); echo '">'; ?>

	<?php if ( of_get_option('esell_slidtext1') <> "" ) { echo stripslashes(of_get_option('esell_slidtext1')); } else {_e( 'You Main Headline here', 'esell' );} echo '</a></h1>'; ?>

	<a href="http://www.eleanornina.com/littletouchofmagic/create-package/"><div class="cta_createpackage">
		Get Started
	</div>
	</a>

	<!--<?php echo '<h3>'; if ( of_get_option('esell_slidedesc') <> "" ) { echo stripslashes(of_get_option('esell_slidedesc')); } else {_e( 'Set you description here from theme options > home page link to any page and upload image here. This is only for demonstration purpose you can set your own description here. ', 'esell' );} echo '</h3>';?>-->
	<!--<?php if ( of_get_option('esell_slidimg1') ) { ?><img src="<?php echo of_get_option( 'esell_slidimg1' ); ?>"/><?php }else {echo'<img class="aligncenter" src="' . get_template_directory_uri() . '/images/esell-small.png" />';} ?>-->
	 </div>
	 
	 <!--<?php if (class_exists('woocommerce')) {echo do_shortcode('[recent_products per_page="8" columns="4" orderby="date" order="desc"]'); } ?>--> 
<div class="info_container">	  
<div class="info">
<?php esell_columnimage(); ?><h2><?php if ( of_get_option('esell_columnh1') <> "" ) { echo stripslashes(of_get_option('esell_columnh1')); } else {_e( 'Column Title here', 'esell' );} ?></h2>
<p><?php if ( of_get_option('esell_columndesc1') <> "" ) { echo stripslashes(of_get_option('esell_columndesc1')); } else {_e( 'Put description or feature detail here from theme option > home page and customize fonts', 'esell' );} ?></p>
<!--<?php esell_columnimage2(); ?><h2><?php if ( of_get_option('esell_columnh2') <> "" ) { echo stripslashes(of_get_option('esell_columnh2')); }else {_e( 'Column Title here', 'esell' );} ?></h2>
<p><?php if ( of_get_option('esell_columndesc2') <> "" ) { echo stripslashes(of_get_option('esell_columndesc2')); }else {_e( 'Put description or feature detail here from theme option > home page and customize fonts', 'esell' );} ?></p>-->
</div>	

 <div class="info">
<?php esell_columnimage3(); ?><h2><?php if ( of_get_option('esell_columnh3') <> "" ) { echo stripslashes(of_get_option('esell_columnh3')); }else {_e( 'Column Title here', 'esell' );} ?></h2>
<p><?php if ( of_get_option('esell_columndesc3') <> "" ) { echo stripslashes(of_get_option('esell_columndesc3')); } else {_e( 'Put description or feature detail here from theme option > home page and customize fonts', 'esell' );}?></p>
<!--<?php esell_columnimage4(); ?><h2><?php if ( of_get_option('esell_columnh4') <> "" ) { echo stripslashes(of_get_option('esell_columnh4')); } else {_e( 'Column Title here', 'esell' );}?></h2>
<p><?php if ( of_get_option('esell_columndesc4') <> "" ) { echo stripslashes(of_get_option('esell_columndesc4')); } else {_e( 'Put description or feature detail here from theme option > home page and customize fonts', 'esell' );}?></p>-->
</div>	

<div class="info info3">
<?php esell_columnimage5(); ?><h2><?php if ( of_get_option('esell_columnh5') <> "" ) { echo stripslashes(of_get_option('esell_columnh5')); } else {_e( 'Column Title here', 'esell' );}?></h2>
<p><?php if ( of_get_option('esell_columndesc5') <> "" ) { echo stripslashes(of_get_option('esell_columndesc5')); }else {_e( 'Put description or feature detail here from theme option > home page and customize fonts', 'esell' );} ?></p>
<!--<?php esell_columnimage6(); ?><h2><?php if ( of_get_option('esell_columnh6') <> "" ) { echo stripslashes(of_get_option('esell_columnh6')); }else {_e( 'Column Title here', 'esell' );} ?></h2>
<p><?php if ( of_get_option('esell_columndesc6') <> "" ) { echo stripslashes(of_get_option('esell_columndesc6')); }else {_e( 'Put description or feature detail here from theme option > home page and customize fonts', 'esell' );} ?></p>-->
 
</div>	
</div>


<div id="content">
<div class="container">

<?php
query_posts('cat=1');
while (have_posts()) : the_post();
the_content();
endwhile;
?>
</div>
</div>

<?php if ( of_get_option('esell_frontposts' ) =='on') { ?>
<?php
$page_num = $paged;
if ($pagenum='') $pagenum =1;
query_posts('showposts=5&paged='.$page_num); ?>
   	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
              <?php get_template_part('/includes/post'); ?>
            <?php endwhile; ?>
			<?php endif; ?>
				<?php } ?>
<?php get_footer(); ?>