<?php 
/** 
 * Get checkout fieldset and make it an overwrite for the default checkout
 * @since 0.3
 */
function WooAOI_checkout_fieldset($id) {
	
	$fields=get_post_meta($id,'_aoi_fields',true); 
	
	$fieldset=array();
	if (isset($fields) && $fields!="") {
		foreach($fields as $field) {
			if(!isset($field['req']) || $field['req']=="") {$field['req']=0;}
			if(!isset($field['clear']) || $field['clear']=="") {$field['clear']=0;}
			if(!isset($field['class']) || $field['class']=="") {$field['class']='';}
			if(!isset($field['args']) || $field['args']=="") {$field['args']='';}
			if(!isset($field['label']) || $field['label']=="") {$field['label']='';}
			if(!isset($field['woo']) || $field['woo']=="") {$field['woo']='';}
			if(!isset($field['name']) || $field['name']=="") {$field['name']='';}
			if(!isset($field['options']) || $field['options']=="") {$field['options']='';}
			if(!isset($field['placeholder']) || $field['placeholder']=="") {$field['placeholder']='';}
			
			$fieldset[$field['name']]=array('type'=>$field['type'],'label'=>$field['label'],'placeholder'=>$field['placeholder'],'required'=>$field['req'],'class'=>$field['class'],'clear'=>$field['clear'],'woo'=>$field['woo'],'options'=>$field['options']);

			if($field['type']=='select') {
				
				$options=explode('|',esc_attr($field['options']));
	
				preg_match("/\[([^\]]+)\]/", $options[0], $selection); 
	
				if(isset($selection[1]) && $selection[1]!="") { $sel_option['']=$selection[1]; array_shift($options); }
						
				foreach ($options as $option) {
					$sel_option[$option]=$option;
				}
				$fieldset[$field['name']]['options'] = $sel_option;
				$fieldset[$field['name']]['placeholder']='';
			}
		}
		return $fieldset;
	}
	return false;
}

/**
 * Default WooCommerce checkout fields overwrite
 * @since 0.3
 */
function WooAOI_checkout_fields($fields) {
	$fields_new['billing'] = $fields['billing'];
	$fields_new['shipping'] = $fields['shipping'];

	// Create new fieldset for account fields
	$account_post=WooAOI_get_opt(array('overwrite','account_c'));
	if(isset($account_post) && $account_post!="") {
		$fields_new['account']=WooAOI_checkout_fieldset($account_post);
	} else {
		$fields_new['account']=$fields['account'];
	}
	
	// Create new fieldset for account fields
	$order_post=WooAOI_get_opt(array('overwrite','order_c'));
	if(isset($order_post) && $order_post!="") {
		$fields_new['order']=WooAOI_checkout_fieldset($order_post);
	} else {
		$fields_new['order']=$fields['order'];
	}
	return $fields_new;
}

/**
 * Create a new fieldset for Billing fields
 * @since 0.3
 */
function WooAOI_checkout_billing($fields) {
	$billing_post=WooAOI_get_opt(array('overwrite','billing_c'));
	$fields_new=WooAOI_checkout_fieldset($billing_post);
	return $fields_new;
}

/**
 * Create a new fieldset for shipping fields
 * @since 0.3
 */
function WooAOI_checkout_shipping($fields) {
	$shipping_post=WooAOI_get_opt(array('overwrite','shipping_c'));
	$fields_new=WooAOI_checkout_fieldset($shipping_post);
	return $fields_new;
}

/**
 * Process the checkout when custom fields are added
 * @since 0.3
 */
function WooAOI_checkout_process() {
	global $woocommerce;
	
	$billing_post=WooAOI_get_opt(array('overwrite','billing_c'));
	$billing_fields=WooAOI_checkout_fieldset($billing_post);
	if(isset($billing_fields) && $billing_fields!="") {
	  foreach ($billing_fields as $key => $field) {
		if($field['woo']!=1 && $field['required']==true && !$_POST[$key]) {
			if($field['type']=='select' && $_POST[$key]!=0) {
				return true;
			}
			$woocommerce->add_error( sprintf(__('Please enter something into %s.','woo-aoi'),$field['label'] ));
		}
	  }
	}
	
	if($_POST['shiptobilling']!=1) {
	
	$shipping_post=WooAOI_get_opt(array('overwrite','shipping_c'));
	$shipping_fields=WooAOI_checkout_fieldset($shipping_post);
	if(isset($shipping_fields) && $shipping_fields!="") {
	  foreach ($shipping_fields as $key => $field) {
		if($field['woo']!=1 && $field['required']==true && !$_POST[$key]) {
			if($field['type']=='select' && $_POST[$key]!=0) {
				return true;
			}
			$woocommerce->add_error( sprintf(__('Please enter something into %s.','woo-aoi'),$field['label'] ));
		}
	  }
	}
	
	}
	
	$account_post=WooAOI_get_opt(array('overwrite','account_c'));
	$account_fields=WooAOI_checkout_fieldset($account_post);
	if(isset($account_fields) && $account_fields!="") {
	  foreach ($account_fields as $key => $field) {
		if($field['woo']!=1 && $field['required']==true && !$_POST[$key]) {
			if($field['type']=='select' && $_POST[$key]!=0) {
				return true;
			}
			$woocommerce->add_error( sprintf(__('Please enter something into %s.','woo-aoi'),$field['label'] ));
		}
	  }
	}
	
	$order_post=WooAOI_get_opt(array('overwrite','order_c'));
	$order_fields=WooAOI_checkout_fieldset($order_post);
	if(isset($order_fields) && $order_fields!="") {
	  foreach ($order_fields as $key => $field) {
		if($field['woo']!=1 && $field['required']==true && !$_POST[$key]) {
			if($field['type']=='select' && $_POST[$key]!=0) {
				return true;
			}
			$woocommerce->add_error( sprintf(__('Please enter something into %s.','woo-aoi'),$field['label'] ));
		}
	  }
	}
}

/** 
 * Save all custom checkout fields
 * @since 0.3
 */
function WooAOI_checkout_save($order_id) {
	$billing_post=WooAOI_get_opt(array('overwrite','billing_c'));
	$billing_fields=WooAOI_checkout_fieldset($billing_post);
	if(isset($billing_fields) && $billing_fields!="") {
	  foreach ($billing_fields as $key => $field) {
		if ($_POST[$key] && $field['woo']!=1) {
			update_post_meta( $order_id, $field['label'], esc_attr($_POST[$key]));
			if(is_user_logged_in()) {
				$user_id=get_current_user_id();
				update_post_meta( $order_id, $field['label'], esc_attr($_POST[$key]));
			}
		}
	  }
	}
	
	$shipping_post=WooAOI_get_opt(array('overwrite','shipping_c'));
	$shipping_fields=WooAOI_checkout_fieldset($shipping_post);
	if(isset($shipping_fields) && $shipping_fields!="") {
	  foreach ($shipping_fields as $key => $field) {
		if ($_POST[$key] && $field['woo']!=1) {
			update_post_meta( $order_id, $field['label'], esc_attr($_POST[$key]));
			if(is_user_logged_in()) {
				$user_id=get_current_user_id();
				update_post_meta( $order_id, $field['label'], esc_attr($_POST[$key]));
			}
		}
	  }
	}
	
	$account_post=WooAOI_get_opt(array('overwrite','account_c'));
	$account_fields=WooAOI_checkout_fieldset($account_post);
	if(isset($account_fields) && $account_fields!="") {
	  foreach ($account_fields as $key => $field) {
		if ($_POST[$key] && $field['woo']!=1) {
			update_post_meta( $order_id, $field['label'], esc_attr($_POST[$key]));
			if(is_user_logged_in()) {
				$user_id=get_current_user_id();
				update_post_meta( $order_id, $field['label'], esc_attr($_POST[$key]));
			}
		}
	  }
	}
	
	$order_post=WooAOI_get_opt(array('overwrite','order_c'));
	$order_fields=WooAOI_checkout_fieldset($order_post);
	if(isset($order_fields) && $order_fields!="") {
	  foreach ($order_fields as $key => $field) {
		if ($_POST[$key] && $field['woo']!=1) {
			update_post_meta( $order_id, $field['label'], esc_attr($_POST[$key]));
			if(is_user_logged_in()) {
				$user_id=get_current_user_id();
				update_post_meta( $order_id, $field['label'], esc_attr($_POST[$key]));
			}
		}
	  }
	}
}

/** 
 * Show custom checkout billing fields on admin order detail page
 * @since 0.3
 */
function WooAOI_checkout_billing_show($order) {
	$billing_post=WooAOI_get_opt(array('overwrite','billing_c'));
	$fields=WooAOI_checkout_fieldset($billing_post);
	if(isset($fields) && $fields!="") {
	  echo '<p>';
	   foreach ($fields as $key => $field) {
		if($field['woo']!=1) {
		
		  if(get_post_meta($order->id,$field['label'])!="") {
			echo '<strong>'.$field['label'].':</strong> ' . get_post_meta($order->id,$field['label'],true) . '<br>';
		  }
		}
	  }
	  echo '</p>';
	}
}

/** 
 * Show custom checkout shipping fields on admin order detail page
 * @since 0.3
 */
function WooAOI_checkout_shipping_show($order) {
	$shipping_post=WooAOI_get_opt(array('overwrite','shipping_c'));
	$fields=WooAOI_checkout_fieldset($shipping_post);
	if(isset($fields) && $fields!="") {
	  echo '<p>';
	  foreach ($fields as $key => $field) {
		if($field['woo']!=1) {
		  if(get_post_meta($order->id,$field['label'])!="") {
			echo '<strong>'.$field['label'].':</strong> ' . get_post_meta($order->id,$field['label'],true) . '<br>';
		  }
		}
	  }
	  echo '</p>';
	}
}

/** 
 * Show custom checkout account fields on admin order detail page
 * @since 0.3
 */
function WooAOI_checkout_account_show($order) {
	$account_post=WooAOI_get_opt(array('overwrite','account_c'));
	$fields=WooAOI_checkout_fieldset($account_post);
	if(isset($fields) && $fields!="") {
	  echo '<p>';
	  foreach ($fields as $key => $field) {
		if($field['woo']!=1) {
		  if(get_post_meta($order->id,$field['label'])!="") {
			echo '<strong>'.$field['label'].':</strong> ' . get_post_meta($order->id,$field['label'],true) . '<br>';
		  }
		}
	  }
	  echo '</p>';
	}
}

/** 
 * Show custom checkout account fields on admin order detail page
 * @since 0.3
 */
function WooAOI_checkout_order_show($order) {
	$order_post=WooAOI_get_opt(array('overwrite','order_c'));
	$fields=WooAOI_checkout_fieldset($order_post);
	if(isset($fields) && $fields!="") {
	  echo '<p>';
	  foreach ($fields as $key => $field) {
		if($field['woo']!=1) {
		  if(get_post_meta($order->id,$field['label'])!="") {
			echo '<strong>'.$field['label'].':</strong> ' . get_post_meta($order->id,$field['label'],true) . '<br>';
		  }
		}
	  }
	  echo '</p>';
	}
}

/** 
 * Add custom checkout fields to customer emails
 * @since 0.3
 */
function WooAOI_checkout_email($order, $is_admin_email=false) {
	$billing_post=WooAOI_get_opt(array('overwrite','billing_c'));
	$billing_fields=WooAOI_checkout_fieldset($billing_post);
	
	if(isset($billing_fields) && $billing_fields!="") {
	  foreach ($billing_fields as $key => $field) {
		if($field['woo']!=1) {
		  if(get_post_meta($order->id,$field['label'])!="") {
			$email_fields[]= '<strong>'.$field['label'].':</strong> ' . get_post_meta($order->id,$field['label'],true) . '<br>';
		  }
		}
	  }
	}
	
	$shipping_post=WooAOI_get_opt(array('overwrite','shipping_c'));
	$shipping_fields=WooAOI_checkout_fieldset($shipping_post);
	if(isset($shipping_fields) && $shipping_fields!="") {
	  foreach ($shipping_fields as $key => $field) {
		if($field['woo']!=1) {
		  if(get_post_meta($order->id,$field['label'])!="") {
			$email_fields[]= '<strong>'.$field['label'].':</strong> ' . get_post_meta($order->id,$field['label'],true) . '<br>';
		  }
		}
	  }
	}
	
	$account_post=WooAOI_get_opt(array('overwrite','account_c'));
	$account_fields=WooAOI_checkout_fieldset($account_post);
	if(isset($account_fields) && $account_fields!="") {
	  foreach ($account_fields as $key => $field) {
		if($field['woo']!=1) {
		  if(get_post_meta($order->id,$field['label'])!="") {
			$email_fields[]= '<strong>'.$field['label'].':</strong> ' . get_post_meta($order->id,$field['label'],true) . '<br>';
		  }
		}
	  }
	}
	
	$order_post=WooAOI_get_opt(array('overwrite','order_c'));
	$order_fields=WooAOI_checkout_fieldset($order_post);
	if(isset($order_fields) && $order_fields!="") {
	  foreach ($order_fields as $key => $field) {
		if($field['woo']!=1) {
		  if(get_post_meta($order->id,$field['label'])!="") {
			$email_fields[]= '<strong>'.$field['label'].':</strong> ' . get_post_meta($order->id,$field['label'],true) . '<br>';
		  }
		}
	  }
	}
	if(get_post_meta($order->id,'fieldset')!="") {

   	  $fieldsets=get_post_meta($order->id,'fieldset',true);
	  $fieldsets=explode(',',$fieldsets);
	
	  foreach ($fieldsets as $field_id) {
		$custom_fields=WooAOI_checkout_fieldset($field_id);
		if(isset($custom_fields) && $custom_fields!="") {
		  foreach ($custom_fields as $key => $field) {
			if($field['woo']!=1 && $field['type']!="submit" && $field['type']!='redirect' && $field['type']!='status') {
			 if(get_post_meta($order->id,$field['label'])!="") {
				if($field['type']=='color') {
					$email_fields[]= '<strong>'.$field['label'].':</strong> <span style="display:inline-block;width:14px;height:14px;border:1px solid #333;background:' . get_post_meta($order->id,$field['label'],true)  . ';" class=wooaoi-colorblock>&nbsp;</span> '.get_post_meta($order->id,$field['label'],true) .'<br>';
				} else {
					$email_fields[]= '<strong>'.$field['label'].':</strong> ' . get_post_meta($order->id,$field['label'],true)  . '<br>';
				}
			  }
			}
		  }
		}
	  }
	}
	

	if(isset($email_fields) && !empty($email_fields)) {
		echo '<div id="woaoi_fields"><h3>'.__('Additional info','woo-aoi').'</h3><p>';
		foreach ($email_fields as $field) {
			echo $field;
		}
		echo '</p>';
	}
}

/** 
 * Add custom checkout fields to order details page
 * @since 0.3
 */
function WooAOI_checkout_orderdetails($order) {

	$billing_post=WooAOI_get_opt(array('overwrite','billing_c'));
	$billing_fields=WooAOI_checkout_fieldset($billing_post);
	
	if(isset($billing_fields) && $billing_fields!="") {
	  foreach ($billing_fields as $key => $field) {
		
		if($field['woo']!=1) {
		  if(get_post_meta($order->id,$field['label'])!="") {
			$detail_fields[]= '<dt>'.$field['label'].':</dt><dd>' . get_post_meta($order->id,$field['label'],true) . '</dd>';
		  }
		}
	  }
	}
	
	$shipping_post=WooAOI_get_opt(array('overwrite','shipping_c'));
	$shipping_fields=WooAOI_checkout_fieldset($shipping_post);
	if(isset($shipping_fields) && $shipping_fields!="") {
	  foreach ($shipping_fields as $key => $field) {
		if($field['woo']!=1) {
		  if(get_post_meta($order->id,$field['label'])!="") {
			$detail_fields[]= '<dt>'.$field['label'].':</dt><dd>' . get_post_meta($order->id,$field['label'],true) . '</dd>';
		  }
		}
	  }
	}
	
	$account_post=WooAOI_get_opt(array('overwrite','account_c'));
	$account_fields=WooAOI_checkout_fieldset($account_post);
	if(isset($account_fields) && $account_fields!="") {
	  foreach ($account_fields as $key => $field) {
		if($field['woo']!=1) {
		  if(get_post_meta($order->id,$field['label'])!="") {
			$detail_fields[]= '<dt>'.$field['label'].':</dt><dd>' . get_post_meta($order->id,$field['label'],true) . '</dd>';
		  }
		}
	  }
	}
	
	$order_post=WooAOI_get_opt(array('overwrite','order_c'));
	$order_fields=WooAOI_checkout_fieldset($order_post);
	if(isset($order_fields) && $order_fields!="") {
	  foreach ($order_fields as $key => $field) {
		if($field['woo']!=1) {
		  if(get_post_meta($order->id,$field['label'])!="") {
			$detail_fields[]= '<dt>'.$field['label'].':</dt><dd>' . get_post_meta($order->id,$field['label'],true) . '</dd>';
		  }
		}
	  }
	}
	if(get_post_meta($order->id,'fieldset')) {
	  $fieldsets=get_post_meta($order->id,'fieldset',true);
	  $fieldsets=explode(',',$fieldsets);
	
	  foreach ($fieldsets as $field_id) {
		$custom_fields=WooAOI_checkout_fieldset($field_id);
		if(isset($custom_fields) && $custom_fields!="") {
		  foreach ($custom_fields as $key => $field) {
			if($field['woo']!=1 && $field['type']!="submit" && $field['type']!='redirect' && $field['type']!='status') {
			  if(get_post_meta($order->id,$field['label'])!="") {
				if($field['type']=='color') {
					$detail_fields[]= '<dt>'.$field['label'].':</dt><dd> <span style="display:inline-block;width:14px;height:14px;border:1px solid #333;background:' . get_post_meta($order->id,$field['label'],true) . ';" class=wooaoi-colorblock>&nbsp;</span> '.get_post_meta($order->id,$field['label'],true).'</dd>';
				} else {
					$detail_fields[]= '<dt>'.$field['label'].':</dt><dd>' . get_post_meta($order->id,$field['label'],true) . '</dd>';
				}
				
			  }
			}
		  }
		}
	  }
	}
	
	if(isset($detail_fields) && !empty($detail_fields)) {
		echo '<div id="woaoi_fields"><header><h2>'.__('Additional info','woo-aoi').'</h2></header><dl class="customer_details aoi-data">';
		foreach ($detail_fields as $field) {
			echo $field;
		}
		echo '</dl>';
		echo '</div>';
	}

}

/**
 * Show fields on checkout 
 * @since 0.3 
 */
function WooAOI_checkout($checkout) {
	global $woocommerce;
	$option=get_option('wooaoi_set');
	$opt['checkout']=true;
	$fieldsets=$option['ch_set'];
	
  if(isset($fieldsets)) {
	foreach ($fieldsets as $fieldset) {
	
    if($fieldset=='') {
		return false;
	} elseif($fieldset==1) {
		
		$sets=array();
		$cart_items=$woocommerce->cart->cart_contents;
		
		foreach ($cart_items as $item) {
			$product=get_product($item['product_id']);
			$set=get_post_meta($product->id,'_wooaoi_prod',true);
			if(isset($set) && $set!="") {
				$sets[]=$set;
			}
		}
		
		$sets=array_unique($sets);
		foreach($sets as $set) {
			WooAOI_show_fieldset($set,$opt);
		}
		
	} else {
		
		WooAOI_show_fieldset($fieldset,$opt);
	}
	
	}
  }
}

/**
 * Process custom checkout data
 * @since 0.3
 */
function WooAOI_checkout_data_process() {
	global $woocommerce;
	
  if(isset($_POST['fieldset']) && is_array($_POST['fieldset'])) {
	foreach ($_POST['fieldset'] as $set) {
		$fields=get_post_meta($set,'_aoi_fields',true); 

		if (isset($fields) && $fields!="") {
		// loop through all fields
			for ( $i = 0; $i < count( $fields ); $i++ ) :
				if ( ! isset( $fields[$i] ) )
					break;
				
				$data='';
				$name=$fields[$i]['name'];
				$label=$fields[$i]['label'];
				$type=$fields[$i]['type'];

				$switch=WooAOI_validate($_POST[$name],$type);
				
				$data=$switch['data'];
				$pass=$switch['options']['pass'];
				
				if(isset($switch['options']['error']) && $switch['options']['error']!="") {
					$woocommerce->add_error( $switch['options']['error']);
				}
				
				if($type == 'password-repeat' && $pass['password']!=$pass['password-repeat']) {
					$woocommerce->add_error( __("Passwords don't match.",'woo-aoi'));
				}
				
				if(isset($fields[$i]['req']) && ($data=="" || $data=="-"))
				{
					$woocommerce->add_error( sprintf(__('%s is a required Field','woo-aoi'),$label));
				}
				
			endfor; 
		}
	}
		
  }
}

/**
 * Save custom checkout data
 * @since 0.3
 */
function WooAOI_checkout_data_save($order_id) {
	if(isset($_POST['fieldset']) && is_array($_POST['fieldset'])) {
		// process all active fieldsets for this order
		foreach ($_POST['fieldset'] as $set) {
			$fields=get_post_meta($set,'_aoi_fields',true); 

			if (isset($fields) && $fields!="") {
			// loop through all fields
				for ( $i = 0; $i < count( $fields ); $i++ ) :
					if ( ! isset( $fields[$i] ) )
						break;
						$data='';
						$name=$fields[$i]['name'];
						$label=$fields[$i]['label'];
						$type=$fields[$i]['type'];

						$switch=WooAOI_validate($_POST[$name],$type);
						
						$data=$switch['data'];
						$pass=$switch['options']['pass'];
						
						if(isset($data) && $data!="") {
							update_post_meta( $order_id, $label, esc_attr($data));
							
							if(is_user_logged_in()) {
								$user_id=get_current_user_id();
								update_user_meta( $user_id, $label, esc_attr($data));
							}
						}
				endfor; 
			}
		}
		
		$fieldset=implode(',',$_POST['fieldset']);
		update_post_meta( $order_id, 'fieldset', esc_attr($fieldset));
	}
		
}