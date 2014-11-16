<div id="sidebar">
<?php if (of_get_option('esell_sharebut' ) =='1' ) {load_template(get_template_directory() . '/includes/social.php'); } ?>
<?php if (of_get_option('esell_activate_ltposts' ) =='1' ) {load_template(get_template_directory() . '/includes/ltposts.php'); } ?>
<?php if (!dynamic_sidebar('Sidebar') ) : ?>
<?php endif; ?>	</div>	<!-- end div #sidebar -->
