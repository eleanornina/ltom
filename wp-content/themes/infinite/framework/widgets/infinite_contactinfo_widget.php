<?php

class infinite_ContactInfo_Widget extends WP_Widget {
	
	function infinite_ContactInfo_Widget()
	{
		$widget_ops = array('classname' => 'infinite-contact-info', 'description' => '');

		$control_ops = array('id_base' => 'infinite-contact-info-widget');

		$this->WP_Widget('infinite-contact-info-widget', 'Infinite Contact Info', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$phone = $instance['phone'];
		$mobile_phone = $instance['mobile_phone'];
		$email = $instance['email'];
		$address = $instance['address'];

		echo $before_widget;

		if($title) {
			echo $before_title.$title.$after_title;
		}
		?>
		<ul>
			<li><span class="icon-phone contact-icon"></span><?php echo $phone ?></li>
			<li><span class="icon-mobile-phone contact-icon"></span><?php echo $mobile_phone ?></li>
			<li><span class="icon-envelope-alt contact-icon"></span><?php echo $email ?></li>
			<li><span class="icon-home contact-icon"></span><?php echo $address ?></li>
		</ul>
	<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['phone'] = $new_instance['phone'];
		$instance['mobile_phone'] = $new_instance['mobile_phone'];
		$instance['email'] = $new_instance['email'];
		$instance['address'] = $new_instance['address'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Contact Information');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo isset($instance['title']) ? $instance['title'] : ''; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('phone'); ?>">Phone:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" value="<?php echo isset($instance['phone']) ? $instance['phone'] : ''; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('mobile_phone'); ?>">Mobile Phone:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('mobile_phone'); ?>" name="<?php echo $this->get_field_name('mobile_phone'); ?>" value="<?php echo isset($instance['mobile_phone']) ? $instance['mobile_phone'] : ''; ?>" />
		</p>


		<p>
			<label for="<?php echo $this->get_field_id('email'); ?>">Email:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" value="<?php echo isset($instance['email']) ? $instance['email'] : ''; ?>" />
		</p>
		
		</p>

			<label for="<?php echo $this->get_field_id('address'); ?>">Address:</label>
			<textarea class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" ><?php echo isset($instance['address']) ? $instance['address'] : ''; ?></textarea>
		</p>

	<?php
	}
}
?>