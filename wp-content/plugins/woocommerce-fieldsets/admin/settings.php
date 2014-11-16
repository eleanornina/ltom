<?php 
if ( ! defined("ABSPATH" ) ) exit; // Exit if accessed directly

/**
* WooCommerce Fieldsets Page
* @since 0.1
*/
function WooAOI_page() {
	$version="1.0";
	
	// Check the user capabilities
	if ( !current_user_can("manage_woocommerce" ) ) {
		wp_die( __("You do not have sufficient permissions to access this page.", "woo-aoi" ) );
	}

	// Save settings
	if ( isset( $_POST['action'] ) && $_POST['action'] == 'update' ) {
	check_admin_referer("wooaoi_update");
	$options = get_option( 'wooaoi_set' );
	global $user_ID, $woocommerce;
	
	$checkout_fields['shipping'] = $woocommerce->countries->get_address_fields('', 'shipping_');
	$checkout_fields['billing'] = $woocommerce->countries->get_address_fields('', 'billing_' );
	$checkout_fields['account'] = array(
    'account_username' => array(
        'type' => 'text',
        'label' => __('Account username', 'woocommerce'),
        'placeholder' => _x('Username', 'placeholder', 'woocommerce')
        ),
    'account_password' => array(
        'type' => 'password',
        'label' => __('Account password', 'woocommerce'),
        'placeholder' => _x('Password', 'placeholder', 'woocommerce'),
        'class' => array('form-row-first')
        ),
    'account_password-2' => array(
        'type' => 'password',
        'label' => __('Account password', 'woocommerce'),
        'placeholder' => _x('Password', 'placeholder', 'woocommerce'),
        'class' => array('form-row-last'),
        'label_class' => array('hidden')
        )
    );
	$checkout_fields['order'] = array(
    'order_comments' => array(
        'type' => 'textarea',
        'class' => array('notes'),
        'label' => __('Order Notes', 'woocommerce'),
        'placeholder' => _x('Notes about your order, e.g. special notes for delivery.', 'placeholder', 'woocommerce')
        )
    );
	
		// create new fieldset for billing fields if not exists
		if(isset($_POST['wooaoi_set']['overwrite']['billing']) && $_POST['wooaoi_set']['overwrite']['billing']==1) {
			
			// check if the set already is created
			$billing_post=WooAOI_get_opt(array('overwrite','billing_c'));
			$_POST['wooaoi_set']['overwrite']['billing_c']=$billing_post;
			if($billing_post==0 || $billing_post=="") {
				$new_post = array(
					'post_title' => 'Checkout - Billing fields',
					'post_content' => '',
					'post_status' => 'publish',
					'post_date' => date('Y-m-d H:i:s'),
					'post_author' => $user_ID,
					'post_type' => 'woo_aoi_fieldset',
					'post_category' => array(0)
				);
				$post_id = wp_insert_post($new_post);
				
				$set_descr=sprintf(__("This fieldset overwrites the default WooCommerce %s checkout fields. Please use it at your own risks! You can always disable this fieldset by unchecking the setting under General settings.",'woo-aoi'),__('account','woo-aoi')).' '.__("Note: 
  1. You can't change the name of core fields
  2. You can't change the type of special core fields (country & state)
  3. Fields which change dynamically based on the chosen country of the user (address 1, address 2, city, state, postcode) cannot have custom position & validation rules",'woo-aoi');
				$billing_field=array();
	
				if(isset($checkout_fields['billing'])) {
					$fieldset=$checkout_fields['billing'];
					$key='billing';
					foreach ($fieldset as $key=>$field) {
						if(!isset($field['type']) || $field['type']=="") {$field['type']='text';}
						if(!isset($field['placeholder']) || $field['placeholder']=="") {$field['placeholder']='';}
						if(!isset($field['required']) || $field['required']=="") {$field['required']='';}
						if(!isset($field['label']) || $field['label']=="") {$field['label']='';}
						if(!isset($field['clear']) || $field['clear']=="") {$field['clear']='';}
						$billing_field[]=array('name'=>$key,'type'=>$field['type'],'label'=>$field['label'],'placeholder'=>$field['placeholder'],'descr'=>'','req'=>$field['required'],'class'=>$field['class'],'clear'=>$field['clear'],'woo'=>true);
					}
				}
			
				add_post_meta($post_id, '_aoi_fields', $billing_field,true) or update_post_meta($post_id, '_aoi_fields', $billing_field);
				add_post_meta($post_id, '_set_descr', $set_descr, true) or update_post_meta($post_id, '_set_descr', $set_descr);
			
				$_POST['wooaoi_set']['overwrite']['billing_c']=$post_id;	
			}
			
		} else {
		
			wp_delete_post(WooAOI_get_opt(array('overwrite','billing_c')));
			$_POST['wooaoi_set']['overwrite']['billing_c']=0;
			
		}

		if(isset($_POST['wooaoi_set']['overwrite']['shipping']) && $_POST['wooaoi_set']['overwrite']['shipping']==1) {
			
			// check if the set already is created
			$shipping_post=WooAOI_get_opt(array('overwrite','shipping_c'));
			$_POST['wooaoi_set']['overwrite']['shipping_c']=$shipping_post;
			if($shipping_post==0 || $shipping_post=="") {
				
				$new_post = array(
					'post_title' => 'Checkout - Shipping fields',
					'post_content' => '',
					'post_status' => 'publish',
					'post_date' => date('Y-m-d H:i:s'),
					'post_author' => $user_ID,
					'post_type' => 'woo_aoi_fieldset',
					'post_category' => array(0)
				);
				$post_id = wp_insert_post($new_post);
				
				$set_descr=sprintf(__("This fieldset overwrites the default WooCommerce %s checkout fields. Please use it at your own risks! You can always disable this fieldset by unchecking the setting under General settings.",'woo-aoi'),__('account','woo-aoi')).' '.__("Note: 
  1. You can't change the name of core fields
  2. You can't change the type of special core fields (country & state)
  3. Fields which change dynamically based on the chosen country of the user (address 1, address 2, city, state, postcode) cannot have custom position & validation rules",'woo-aoi');
				$shipping_field=array();
				
				
				if(isset($checkout_fields['shipping'])) {
					$fieldset=$checkout_fields['shipping'];
					$key='shipping';
					foreach ($fieldset as $key=>$field) {
						if(!isset($field['type']) || $field['type']=="") {$field['type']='text';}
						if(!isset($field['placeholder']) || $field['placeholder']=="") {$field['placeholder']='';}
						if(!isset($field['required']) || $field['required']=="") {$field['required']='';}
						if(!isset($field['label']) || $field['label']=="") {$field['label']='';}
						if(!isset($field['clear']) || $field['clear']=="") {$field['clear']='';}
						$shipping_field[]=array('name'=>$key,'type'=>$field['type'],'label'=>$field['label'],'placeholder'=>$field['placeholder'],'descr'=>'','req'=>$field['required'],'class'=>$field['class'],'clear'=>$field['clear'],'woo'=>true);
					}
				}
			
				add_post_meta($post_id, '_aoi_fields', $shipping_field,true) or update_post_meta($post_id, '_aoi_fields', $shipping_field);
				add_post_meta($post_id, '_set_descr', $set_descr, true) or update_post_meta($post_id, '_set_descr', $set_descr);
			
				$_POST['wooaoi_set']['overwrite']['shipping_c']=$post_id;	
			}
			
		} else {
		
			wp_delete_post(WooAOI_get_opt(array('overwrite','shipping_c')));
			$_POST['wooaoi_set']['overwrite']['shipping_c']=0;
			
		}
		
		if(isset($_POST['wooaoi_set']['overwrite']['account']) && $_POST['wooaoi_set']['overwrite']['account']==1) {
			
			// check if the set already is created
			$account_post=WooAOI_get_opt(array('overwrite','account_c'));
			$_POST['wooaoi_set']['overwrite']['account_c']=$account_post;
			if($account_post==0 || $account_post=="") {
				
				$new_post = array(
					'post_title' => 'Checkout - Account fields',
					'post_content' => '',
					'post_status' => 'publish',
					'post_date' => date('Y-m-d H:i:s'),
					'post_author' => $user_ID,
					'post_type' => 'woo_aoi_fieldset',
					'post_category' => array(0)
				);
				$post_id = wp_insert_post($new_post);
				
				$set_descr=sprintf(__("This fieldset overwrites the default WooCommerce %s checkout fields. Please use it at your own risks! You can always disable this fieldset by unchecking the setting under General settings.",'woo-aoi'),__('account','woo-aoi')).' '.__("Note: 
  1. You can't change the name and type of core fields
  2. All custom fields are only shown when a user is not logged in and account creation during checkout is enabled.",'woo-aoi');
				$account_field=array();
				
				
				if(isset($checkout_fields['account'])) {
					$fieldset=$checkout_fields['account'];
					$key='account';
					foreach ($fieldset as $key=>$field) {
						if(!isset($field['type']) || $field['type']=="") {$field['type']='text';}
						if(!isset($field['placeholder']) || $field['placeholder']=="") {$field['placeholder']='';}
						if(!isset($field['required']) || $field['required']=="") {$field['required']='';}
						if(!isset($field['label']) || $field['label']=="") {$field['label']='';}
						if(!isset($field['clear']) || $field['clear']=="") {$field['clear']='';}
						if(!isset($field['class']) || $field['class']=="") {$field['class']='';}
						$account_field[]=array('name'=>$key,'type'=>$field['type'],'label'=>$field['label'],'placeholder'=>$field['placeholder'],'descr'=>'','req'=>$field['required'],'class'=>$field['class'],'clear'=>$field['clear'],'woo'=>true);
					}
				}
			
				add_post_meta($post_id, '_aoi_fields', $account_field,true) or update_post_meta($post_id, '_aoi_fields', $account_field);
				add_post_meta($post_id, '_set_descr', $set_descr, true) or update_post_meta($post_id, '_set_descr', $set_descr);
			
				$_POST['wooaoi_set']['overwrite']['account_c']=$post_id;	
			}
			
		} else {
		
			wp_delete_post(WooAOI_get_opt(array('overwrite','account_c')));
			$_POST['wooaoi_set']['overwrite']['account_c']=0;
			
		}
		
		if(isset($_POST['wooaoi_set']['overwrite']['order']) && $_POST['wooaoi_set']['overwrite']['order']==1) {
			
			// check if the set already is created
			$order_post=WooAOI_get_opt(array('overwrite','order_c'));
			$_POST['wooaoi_set']['overwrite']['order_c']=$order_post;
			if($order_post==0 || $order_post=="") {
				
				$new_post = array(
					'post_title' => 'Checkout - Order note section',
					'post_content' => '',
					'post_status' => 'publish',
					'post_date' => date('Y-m-d H:i:s'),
					'post_author' => $user_ID,
					'post_type' => 'woo_aoi_fieldset',
					'post_category' => array(0)
				);
				$post_id = wp_insert_post($new_post);
				
				$set_descr=sprintf(__("This fieldset overwrites the default WooCommerce %s checkout fields. Please use it at your own risks! You can always disable this fieldset by unchecking the setting under General settings.",'woo-aoi'),__('order','woo-aoi')).' 
'.__('Note: Customer notes must be enabled to show this section.','woo-aoi');
				$order_field=array();
				
				if(isset($checkout_fields['order'])) {
					$fieldset=$checkout_fields['order'];
					$key='order';
					foreach ($fieldset as $key=>$field) {
						if(!isset($field['type']) || $field['type']=="") {$field['type']='text';}
						if(!isset($field['placeholder']) || $field['placeholder']=="") {$field['placeholder']='';}
						if(!isset($field['required']) || $field['required']=="") {$field['required']='';}
						if(!isset($field['label']) || $field['label']=="") {$field['label']='';}
						if(!isset($field['clear']) || $field['clear']=="") {$field['clear']='';}
						if(!isset($field['class']) || $field['class']=="") {$field['class']='';}
						$order_field[]=array('name'=>$key,'type'=>$field['type'],'label'=>$field['label'],'placeholder'=>$field['placeholder'],'descr'=>'','req'=>$field['required'],'class'=>$field['class'],'clear'=>$field['clear'],'woo'=>true);
					}
				}
			
				add_post_meta($post_id, '_aoi_fields', $order_field,true) or update_post_meta($post_id, '_aoi_fields', $order_field);
				add_post_meta($post_id, '_set_descr', $set_descr, true) or update_post_meta($post_id, '_set_descr', $set_descr);
			
				$_POST['wooaoi_set']['overwrite']['order_c']=$post_id;	
			}
			
		} else {
		
			wp_delete_post(WooAOI_get_opt(array('overwrite','order_c')));
			$_POST['wooaoi_set']['overwrite']['order_c']=0;
			
		}
		
		$value=$_POST['wooaoi_set'];
		
		if ( $options != $value ) {
			update_option( 'wooaoi_set', $value );
		} else {
			add_option( 'wooaoi_set', $value, '', 'no' );
		}
		
		
		
	}
	
?>
	<style>#poststuff h2.nav-tab-wrapper{padding-bottom:0px;}.tab{display:none;}.tab.active{display:block;}table td p {padding:0px !important;} table th {text-align:left !important;}</style>
	
	<div class="wrap">
	  <div id="icon-options-general" class="icon32"></div>
	  <h2><?php _e("WooCommerce Forms & Fields", "woo-aoi" ); ?></h2>

	  <?php if ( isset( $_POST['action'] ) && $_POST['action']=='update') { ?>
			<div id="message" class="updated fade"><p><strong><?php _e("Your settings have been saved.", "woo-aoi" ); ?></strong></p></div>
		<?php } ?>
		<div id="content">
			<div id="poststuff">
				<div style="float:left; width:72%; padding-right:3%;">
				  		
					<div id="tabs">
						<h2 class=nav-tab-wrapper>
							<a id=createfields-tab class=nav-tab href="#top#createfields"><?php _e( 'Create Fieldsets', 'woo-aoi' ); ?></a>
							<a id=checkout-tab class=nav-tab href="#top#checkout"><?php _e( 'Checkout', 'woo-aoi' ); ?></a>
							<a id=thankyou-tab class=nav-tab href="#top#thankyou"><?php _e( 'Thank you page', 'woo-aoi' ); ?></a>
							<a id=overview-tab class=nav-tab href="#top#overview"><?php _e( 'Order overview page', 'woo-aoi' ); ?></a>
							<a id=orderdetail-tab class=nav-tab href="#top#orderdetail"><?php _e( 'Order Detail page', 'woo-aoi' ); ?></a>
							<a id=general-tab class=nav-tab href="#top#general"><?php _e( 'General settings', 'woo-aoi' ); ?></a>
						</h2>
						<div id="createfields" class=tab>
						
						<?php  
							echo '<a style="float:right;margin:0 0 0 20px;" class="button-primary" href="post-new.php?post_type=woo_aoi_fieldset">'.__('Create fieldset','woo-aoi').'</a>';
							WooAOI_table();
						?>
						
						</div>
						<form method="post" action="" id="wooaoi_submit">
					<?php 
						$options = get_option( 'wooaoi_set' );
						
						$checkout_posts[]=WooAOI_get_opt(array('overwrite','billing_c'));
						$checkout_posts[]=WooAOI_get_opt(array('overwrite','shipping_c'));
						$checkout_posts[]=WooAOI_get_opt(array('overwrite','account_c'));
						$checkout_posts[]=WooAOI_get_opt(array('overwrite','order_c'));
												
					?>
					<input type=hidden name="wooaoi_set[version]" value="<?php echo $version;?>">
					<?php wp_nonce_field('wooaoi_update'); ?>
					<input type="hidden" name="action" value="update">
						<div id="checkout" class=tab>
							<div class="postbox">
								<h3><?php _e("WooCommerce checkout", "woo-aoi" ); ?></h3>
								<div class="inside">
									<table class="form-table">
									<tr>
										<th>
											<label for="wooaoi_set[ch_set]"><b><?php _e("Custom fieldset:", "woo-aoi" ); ?></b></label>
										</th>
										<td>
											<?php if(isset($options['ch_set'])) $ch_sets=$options['ch_set'];?>
											<select multiple id="wooaoi_set[ch_set]" name="wooaoi_set[ch_set][]">
												<?php 
												echo '<option value="" '.selected(!isset($ch_sets),true,0).'>'.__('No fieldset','woo-aoi').'</option>';
												echo '<option value="1" '.selected(in_array(1,$ch_sets),true,0).'>'.__('Product specific fieldsets','woo-aoi').'</option>';
											
												$fieldsets=WooAOI_get_sets();
												
												if(isset($fieldsets) && !empty($fieldsets)) {
												  echo '<optgroup style="margin:5px 0 0 0;" label="'.__('Custom fieldsets','woo-aoi').'">';
												  foreach ($fieldsets as $set) {
													if(!in_array($set['ID'],$checkout_posts)) {
													  echo '<option value="'.$set['ID'].'" '.selected(in_array($set['ID'],$ch_sets),true,0).'>'.$set['name'].'</option>';	
													}
												  }
												  echo '</optgroup>';
												}
												
												?>
											</select>
											<br><span class="description">
												<?php echo sprintf(__("Which fieldsets do you want to show on %s?", "woo-aoi" ),__('the order thank you page','woo-aoi'));?><br>
											</span>
										</td>
									</tr>
									<tr><td colspan=2><div style="-webkit-border-radius:3px;border-radius:3px;border:1px solid #CC0000;margin:5px 0 15px;padding:5px;background:#FFEBE8;"><strong>
										<?php _e("Some plugins may stop working after you overwrite the default checkout fields with your own. If you use below settings, please be aware of the risks. The developer of this plugin is never responsible for problems which are caused by this function, so make sure you've tested it on a development environment first!", "woo-aoi" );?>
									</strong></div></td></tr>
									<tr>
										<th>
											<label for="wooaoi_set[overwrite][billing]"><b><?php _e("Overwrite billing fields:", "woo-aoi" ); ?></b></label>
										</th>
										<td>
											<input type=checkbox id="wooaoi_set[overwrite][billing]" name="wooaoi_set[overwrite][billing]" value=1 <?php checked(WooAOI_get_opt(array('overwrite','billing')),1,1);?>>
											 <span class="description">
												<?php _e("Yes, I really want to overwrite the default WooCommerce billing fields.", "woo-aoi" );?><br>
											</span>
											<span class="description">
												
											</span>
										</td>
									</tr>
									<tr>
										<th>
											<label for="wooaoi_set[overwrite][shipping]"><b><?php _e("Overwrite shipping fields:", "woo-aoi" ); ?></b></label>
										</th>
										<td>
											<input type=checkbox id="wooaoi_set[overwrite][shipping]" name="wooaoi_set[overwrite][shipping]" value=1 <?php checked(WooAOI_get_opt(array('overwrite','shipping')),1,1);?>>
											 <span class="description">
												<?php _e("Yes, I really want to overwrite the default WooCommerce shipping fields.", "woo-aoi" );?><br>
											</span>
										</td>
									</tr>
									<tr>
										<th>
											<label for="wooaoi_set[overwrite][account]"><b><?php _e("Overwrite account fields:", "woo-aoi" ); ?></b></label>
										</th>
										<td>
											<input type=checkbox id="wooaoi_set[overwrite][account]" name="wooaoi_set[overwrite][account]" value=1 <?php checked(WooAOI_get_opt(array('overwrite','account')),1,1);?>>
											 <span class="description">
												<?php _e("Yes, I really want to overwrite the default WooCommerce account fields.", "woo-aoi" );?><br>
											</span>
										</td>
									</tr>
									<tr>
										<th>
											<label for="wooaoi_set[overwrite][order]"><b><?php _e("Overwrite order note section:", "woo-aoi" ); ?></b></label>
										</th>
										<td>
											<input type=checkbox id="wooaoi_set[overwrite][order]" name="wooaoi_set[overwrite][order]" value=1 <?php checked(WooAOI_get_opt(array('overwrite','order')),1,1);?>>
											 <span class="description">
												<?php _e("Yes, I really want to overwrite the default WooCommerce order note section.", "woo-aoi" );?><br>
											</span>
										</td>
									</tr>
									<tr>
										<td colspan=2>
											<?php submit_button( __( 'Save settings', 'woo-aoi' ) ); ?>
										</td>
									</tr>
									</table>
								</div>
							</div>
						  
						</div>
						<div id="orderdetail" class=tab>
						  <div class="postbox">
								<h3><?php _e("Order detail page", "woo-aoi" ); ?></h3>
								
								<div class="inside">
									<table class="form-table">
									<tr>
										<th>
											<label for="wooaoi_set[od_descr][active]"><b><?php _e("Show description:", "woo-aoi" ); ?></b></label>
										</th>
										<td>
											<input type="checkbox" id="wooaoi_set[od_descr][active]" name="wooaoi_set[od_descr][active]" value="1" <?php checked(WooAOI_get_opt(array('od_descr','active')),1);?>/>
											&nbsp;<span class="description">
												<?php echo sprintf(__("Show description on %s.", "woo-aoi" ),__('the order detail page','woo-aoi'));?>
											</span>
										</td>
									</tr>
									<tr>
										<th>
											<label for="wooaoi_set[od_descr][title]"><b><?php _e("Description title:", "woo-aoi" ); ?></b></label>
										</th>
										<td>
										<input type="text" id="wooaoi_set[od_descr][title]" name="wooaoi_set[od_descr][title]" class=regular-text value="<?php echo sanitize_text_field(WooAOI_get_opt(array('od_descr','title'),__('Additional information','woo-aoi')));?>"/>
										</td>
									</tr>
									<tr>
										<th>
											<label for="wooaoi_set[od_descr][txt]"><b><?php _e("Description text","woo-aoi");?></b></label>
										</th>
										<td>
											<?php 
											$content=stripslashes(wp_kses_post($options['od_descr']['txt']));
											if(!isset($content) || empty($content)) {
												$content='<p>'.__('To complete your order we need additional information.','woo-aoi').'</p>';
												$content.='<p>'.sprintf(__('Please fill in details below.','woo-aoi').'</a>').'</p>';
											}
											$editor_id='wooaoi_set[od_descr][txt]';
											$settings=array(
												'textarea_name'=>'wooaoi_set[od_descr][txt]',
												'textarea_rows'=>16,
												'teeny'=>true
											);
											wp_editor($content,$editor_id,$settings);
											?>
											<span class="description">
												<?php echo sprintf(__("Which text do you want to show on %s?", "woo-aoi" ),__('the order detail page','woo-aoi'));?><br>
											</span>
										</td>
									</tr>
									<tr>
										<th>
											<label for="wooaoi_set[od_set]"><b><?php _e("Show fieldset:", "woo-aoi" ); ?></b></label>
										</th>
										<td> <?php if(isset($options['od_set'])) $od_sets=$options['od_set']; ?>
											<select multiple id="wooaoi_set[od_set]" name="wooaoi_set[od_set][]">
												<?php 
												echo '<option value="" '.selected(!isset($od_sets),true,0).'>'.__('No fieldset','woo-aoi').'</option>';
												echo '<option value="1" '.selected(in_array(1,$od_sets),true,0).'>'.__('Product specific fieldsets','woo-aoi').'</option>';
												
												$fieldsets=WooAOI_get_sets();
												
												if(isset($fieldsets) && !empty($fieldsets)) {
												  echo '<optgroup style="margin:5px 0 0 0;" label="'.__('Custom fieldsets','woo-aoi').'">';
												  foreach ($fieldsets as $set) {
												    if(!in_array($set['ID'],$checkout_posts)) {
													  echo '<option value="'.$set['ID'].'" '.selected(in_array($set['ID'],$od_sets),true,0).'>'.$set['name'].'</option>';	
													}
												  }
												  echo '</optgroup>';
												}
												
												?>
											</select>
											<br><span class="description">
												<?php echo sprintf(__("Which fieldsets do you want to show on %s?", "woo-aoi" ),__('the order detail page','woo-aoi'));?><br>
											</span>
										</td>
									</tr>
									
									<tr>
										<td colspan=2>
											<?php submit_button( __( 'Save settings', 'woo-aoi' ) ); ?>
										</td>
									</tr>
									</table>
								</div>
							</div>
						  
						</div>
						<div id="thankyou" class=tab>
							<div class="postbox">
								<h3><?php _e("Thank you page", "woo-aoi" ); ?></h3>
								<div class="inside">
									<table class="form-table">
									<tr>
										<th>
											<label for="wooaoi_set[ty_descr][active]"><b><?php _e("Show description:", "woo-aoi" ); ?></b></label>
										</th>
										<td>
											<input type="checkbox" id="wooaoi_set[ty_descr][active]" name="wooaoi_set[ty_descr][active]" value="1" <?php checked(WooAOI_get_opt(array('ty_descr','active')),1);?>/>
											&nbsp;<span class="description">
												<?php echo sprintf(__("Show description on %s.", "woo-aoi" ),__('the order thank you page','woo-aoi'));?>
											</span>
										</td>
									</tr>
									<tr>
										<th>
											<label for="wooaoi_set[ty_descr][title]"><b><?php _e("Description title:", "woo-aoi" ); ?></b></label>
										</th>
										<td>
											<input type="text" id="wooaoi_set[ty_descr][title]" name="wooaoi_set[ty_descr][title]" class=regular-text value="<?php echo sanitize_text_field(WooAOI_get_opt(array('ty_descr','title'),__('Add additional information','woo-aoi')));?>"/>
										</td>
									</tr>
									<tr>
										<th>
											<label for="wooaoi_set[ty_descr][txt]"><b><?php _e("Description text","woo-aoi");?></b></label>
										</th>
										<td>
											<?php 
											$content=stripslashes(wp_kses_post($options['ty_descr']['txt']));
											if(!isset($content) || empty($content)) {
												$content='<p>'.__('To complete your order we need additional information.','woo-aoi').'</p>';
												$content.='<p>'.sprintf(__('Please go to the {{link}}order detail page{{/link}} to add the information to complete your order.','woo-aoi').'</a>').'</p>';
											}
											$editor_id='wooaoi_set[ty_descr][txt]';
											$settings=array(
												'textarea_name'=>'wooaoi_set[ty_descr][txt]',
												'textarea_rows'=>16,
												'teeny'=>true
											);
											wp_editor($content,$editor_id,$settings);
											?>
											<span class="description">
												<?php echo sprintf(__("Which text do you want to show on %s?", "woo-aoi" ),__('the order thank you page','woo-aoi'));?><br>
												<?php echo sprintf(__("Use %s and %s to insert %s inside your description.", "woo-aoi" ),'<code>{{link}}</code>','<code>{{/link}}</code>',__('a link to the order detail page'));?>
											</span>
										</td>
									</tr>
									<tr>
										<th>
											<label for="wooaoi_set[ty_set]"><b><?php _e("Show fieldset:", "woo-aoi" ); ?></b></label>
										</th>
										<td>
											<?php if(isset($options['ty_set'])) $ty_sets=$options['ty_set'];?>
											<select multiple id="wooaoi_set[ty_set]" name="wooaoi_set[ty_set][]">
												<?php 
												echo '<option value="" '.selected(!isset($ty_sets),true,0).'>'.__('No fieldset','woo-aoi').'</option>';
												echo '<option value="1" '.selected(in_array(1,$ty_sets),true,0).'>'.__('Product specific fieldsets','woo-aoi').'</option>';
												
												$fieldsets=WooAOI_get_sets();
												
												if(isset($fieldsets) && !empty($fieldsets)) {
												  echo '<optgroup style="margin:5px 0 0 0;" label="'.__('Custom fieldsets','woo-aoi').'">';
												  foreach ($fieldsets as $set) {
													if(!in_array($set['ID'],$checkout_posts)) {
													  echo '<option value="'.$set['ID'].'" '.selected(in_array($set['ID'],$ty_sets),true,0).'>'.$set['name'].'</option>';	
													}
												  }
												  echo '</optgroup>';
												}
												
												?>
											</select>
											<br><span class="description">
												<?php echo sprintf(__("Which fieldsets do you want to show on %s?", "woo-aoi" ),__('the order thank you page','woo-aoi'));?><br>
											</span>
										</td>
									</tr>
									<tr>
										<td colspan=2>
											<?php submit_button( __( 'Save settings', 'woo-aoi' ) ); ?>
										</td>
									</tr>
									</table>
								</div>
							</div>
						  
						</div>
						<div id="overview" class=tab>
						  <div class="postbox">
								<h3><?php _e("Order overview page", "woo-aoi" ); ?></h3>
								
								<div class="inside">
									<table class="form-table">
									<tr>
										<th>
											<label for="wooaoi_set[ov_descr][active]"><b><?php _e("Show description:", "woo-aoi" ); ?></b></label>
										</th>
										<td>
											<input type="checkbox" id="wooaoi_set[ov_descr][active]" name="wooaoi_set[ov_descr][active]" value="1" <?php checked(WooAOI_get_opt(array('ov_descr','active')),1);?>/>
											&nbsp;<span class="description">
												<?php echo sprintf(__("Show description on %s.", "woo-aoi" ),__('the order overview page','woo-aoi'));?>
											</span>
										</td>
									</tr>
									<tr>
										<th>
											<label for="wooaoi_set[ov_descr][title]"><b><?php _e("Description title:", "woo-aoi" ); ?></b></label>
										</th>
										<td>
											<input type="text" id="wooaoi_set[ov_descr][title]" name="wooaoi_set[ov_descr][title]" class=regular-text value="<?php echo sanitize_text_field(WooAOI_get_opt(array('ov_descr','title'),__('Additional information','woo-aoi')));?>"/>
										</td>
									</tr>
									<tr>
										<th>
											<label for="wooaoi_set[ov_descr][txt]"><b><?php _e("Description text","woo-aoi");?></b></label>
										</th>
										<td>
											<?php 
											if(isset($options['ov_descr']['txt'])) {
												$content=stripslashes(wp_kses_post($options['ov_descr']['txt']));
											}
												
											if(!isset($content) || empty($content)) {
												$content='<p>'.__('We want to know who you are. Please provide us more information.','woo-aoi').'</p>';
											}
											$editor_id='wooaoi_set[ov_descr][txt]';
											$settings=array(
												'textarea_name'=>'wooaoi_set[ov_descr][txt]',
												'textarea_rows'=>16,
												'teeny'=>true
											);
											wp_editor($content,$editor_id,$settings);
											?>
											<span class="description">
												<?php echo sprintf(__("Which text do you want to show on %s?", "woo-aoi" ),__('the order overview page','woo-aoi'));?><br>
											</span>
										</td>
									</tr>
									<tr>
										<th>
											<label for="wooaoi_set[ov_set]"><b><?php _e("Show fieldset:", "woo-aoi" ); ?></b></label>
										</th>
										<td>
											<?php if(isset($options['ov_set'])) $ov_sets=$options['ov_set'];?>
											<select multiple id="wooaoi_set[ov_set]" name="wooaoi_set[ov_set][]">
												<?php 
												echo '<option value="" '.selected(!isset($ov_sets),true,0).'>'.__('No fieldset','woo-aoi').'</option>';
												
												$fieldsets=WooAOI_get_sets();
												if(isset($fieldsets) && !empty($fieldsets)) {
												  echo '<optgroup style="margin:5px 0 0 0;" label="'.__('Custom fieldsets','woo-aoi').'">';
												  foreach ($fieldsets as $set) {
													if(!in_array($set['ID'],$checkout_posts)) {
													  echo '<option value="'.$set['ID'].'" '.selected(in_array($set['ID'],$ov_sets),true,0).'>'.$set['name'].'</option>';	
													}
												  }
												  echo '</optgroup>';
												}
												
												?>
											</select>
											<br><span class="description">
												<?php echo sprintf(__("Which fieldsets do you want to show on %s?", "woo-aoi" ),__('the order overview page','woo-aoi'));?><br>
												<?php _e("Note: Because the order overview page is not connected to a specific order, the data will be saved to the user profile.", "woo-aoi" );?><br>
											</span>
										</td>
									</tr>
									
									<tr>
										<td colspan=2>
											<?php submit_button( __( 'Save settings', 'woo-aoi' ) ); ?>
										</td>
									</tr>
									</table>
								</div>
							</div>
						  
						</div>
						<div id="general" class=tab>
						  <div class="postbox">
								<h3><?php _e("General settings", "woo-aoi" ); ?></h3>
								
								<div class="inside">
									<table class="form-table">
									<tr>
										<th>
											<label for="wooaoi_set[descr][pos]"><b><?php _e("Description position:", "woo-aoi" ); ?></b></label>
										</th>
										<td>
											<select id="wooaoi_set[descr][pos]" name="wooaoi_set[descr][pos]">
												<?php 
												echo '<option value="0" '.selected(WooAOI_get_opt(array('descr','pos')),0,0).'>'.__('Before field','woo-aoi').'</option>';
												echo '<option value="1" '.selected(WooAOI_get_opt(array('descr','pos')),1,0).'>'.__('After field','woo-aoi').'</option>';
												?>
											</select>
											<br><span class="description">
												<?php _e("Where do you want to show the field description?", "woo-aoi" );?><br>
											</span>
										</td>
									</tr>
									
									<tr>
										<th>
											<label for="wooaoi_set[overwrite][emails]"><b><?php _e("Add to email:", "woo-aoi" ); ?></b></label>
										</th>
										<td>
											<input type=checkbox id="wooaoi_set[overwrite][emails]" name="wooaoi_set[overwrite][emails]" value=1 <?php checked(WooAOI_get_opt(array('overwrite','emails')),1,1);?>>
											 <span class="description">
												<?php _e("Add custom fields to customer emails.", "woo-aoi" );?><br>
											</span>
										</td>
									</tr>
									<tr>
										<th>
											<label for="wooaoi_set[overwrite][orderdetail]"><b><?php _e("Add to order page:", "woo-aoi" ); ?></b></label>
										</th>
										<td>
											<input type=checkbox id="wooaoi_set[overwrite][orderdetail]" name="wooaoi_set[overwrite][orderdetail]" value=1 <?php checked(WooAOI_get_opt(array('overwrite','orderdetail')),1,1);?>>
											 <span class="description">
												<?php _e("Add custom fields to customer order detail page.", "woo-aoi" );?><br>
											</span>
										</td>
									</tr>														
									<tr>
										<td colspan=2>
											<?php submit_button( __( 'Save settings', 'woo-aoi' ) ); ?>
										</td>
									</tr>
									</table>
								</div>
							</div>
						  
						</div>
						</form>
					</div>
				</div>
				<?php // right column with Plugin information ?>
				<div style="float:right; width:25%;">
					<div class="postbox">
						<h3><?php _e("Need Support?", "woo-aoi" ); ?></h3>
						<div class="inside parc-preview">
							<p><?php _e("If you are having problems with this plugin, please contact us via our ", "woo-aoi" ); ?> <a target=_blank href="<?php echo PLUGIN_URL;?>">website</a>.</p>
							<p><?php _e("We will try to support you as soon as possible, mostly within 24 hours.", "woo-aoi" ); ?></p>
							<p><?php _e("On our website you will also find some basic support information for this plugin.", "woo-aoi" ); ?></p>
						</div>
					</div>
					<div class="postbox">
						<h3><?php _e("Show Your Love", "woo-aoi" ); ?></h3>
						<div class="inside parc-preview">
							<p><?php echo sprintf(__("This plugin is developed by %s, a Dutch graphic design and webdevelopment company.", "woo-aoi" ),'Geev vormgeeving'); ?></p>
							<p><?php _e("If you are happy with this plugin please show your love by liking us on Facebook", "woo-aoi" ); ?></p>
							<iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fgeevvormgeeving&amp;width=220&amp;height=62&amp;show_faces=false&amp;colorscheme=light&amp;stream=false&amp;border_color&amp;header=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; height:62px;" allowTransparency="true"></iframe>
							<p><?php _e("Or", "woo-aoi" ); ?></p>
							<ul style="list-style:square;padding-left:20px;margin-top:-10px;">
								<li><a href="<?php echo PLUGIN_URL;?>" target=_blank title="WooCommerce Forms & Fields"><?php _e("Blog about it & link to the plugin page", "woo-aoi" ); ?></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>
<?php }