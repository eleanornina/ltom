<!--   
Package: Free Social Media Icons
Author: Thomas Weichselbaumer, ThemeZee.com
Source: http://themezee.com/free-social-media-icons/
License: GPL v3 (http://www.gnu.org/licenses/gpl.html)
-->
<div id="share">
<?php if(of_get_option('esell_rss')) : ?>
	<a href="<?php echo esc_url(of_get_option('esell_rss'));?>"><img src="<?php echo get_template_directory_uri(); ?>/images/rss.jpg" alt="Subcribe to my feed" width="48" height="48"/></a>
<?php else : ?>
<?php endif; ?>	 

<?php if(of_get_option('esell_gp')) : ?>
		<a href="<?php echo esc_url(of_get_option('esell_gp'));?>"><img src="<?php echo get_template_directory_uri(); ?>/images/googleplus.jpg" alt="Google+ Plus" width="48" height="48"/></a>
<?php else : ?>
<?php endif; ?>	 
		<?php if(of_get_option('esell_tw')) : ?>
<a href="<?php echo esc_url(of_get_option('esell_tw'));?>"><img src="<?php echo get_template_directory_uri(); ?>/images/twitter.jpg" alt="Follow on Twitter" width="48" height="48"/></a>
<?php else : ?>
<?php endif; ?>	 

<?php if(of_get_option('esell_fb')) : ?>
	<a href="<?php echo esc_url(of_get_option('esell_fb'));?>"><img src="<?php echo get_template_directory_uri(); ?>/images/facebook.jpg" alt="Like On Facebook" width="48" height="48"/></a>
<?php else : ?>
<?php endif; ?>	 

<?php if(of_get_option('esell_in')) : ?>
	<a href="<?php echo esc_url(of_get_option('esell_in'));?>"><img src="<?php echo get_template_directory_uri(); ?>/images/linkedin.jpg" alt="Linked Follow" width="48" height="48"/></a>
<?php else : ?>
<?php endif; ?>	 

<?php if(of_get_option('esell_youtube')) : ?>
	<a href="<?php echo esc_url(of_get_option('esell_youtube'));?>"><img src="<?php echo get_template_directory_uri(); ?>/images/youtube.jpg" alt="Subscribe on YouTube" width="48" height="48"/></a>
<?php else : ?>
<?php endif; ?>	
<?php if(of_get_option('esell_pinterest')) : ?>
	<a href="<?php echo esc_url(of_get_option('esell_pinterest'));?>"><img src="<?php echo get_template_directory_uri(); ?>/images/pinterest.jpg" alt="Pinterest" width="48" height="48"/></a>
<?php else : ?>
<?php endif; ?>	

<?php if(of_get_option('esell_stumbleupon')) : ?>
	<a href="<?php echo esc_url(of_get_option('esell_stumbleupon'));?>"><img src="<?php echo get_template_directory_uri(); ?>/images/stumbleupon.jpg" alt="Stumbleupon" width="48" height="48"/></a>
<?php else : ?>
<?php endif; ?>	
<?php if(of_get_option('esell_instagram')) : ?>
	<a href="<?php echo esc_url(of_get_option('esell_instagram'));?>"><img src="<?php echo get_template_directory_uri(); ?>/images/instagram.jpg" alt="Instagram" width="48" height="48"/></a>
<?php else : ?>
<?php endif; ?>	
<?php if(of_get_option('esell_email')) : ?>
	<a href="<?php echo esc_url(of_get_option('esell_email'));?>"><img src="<?php echo get_template_directory_uri(); ?>/images/email.jpg" alt="Email to us" width="48" height="48"/></a>
<?php else : ?>
<?php endif; ?>	
</div> 
	
