<?php

/**
 * Add fieldset to product detail page
 * @since 0.3
 */
add_action( 'woocommerce_before_add_to_cart_button', 'WooAOI_product', 15 );
function WooAOI_product () {
	global $post;
	$set=get_post_meta($post->ID,'_wooaoi_prod_prset',true);
	$opt['checkout']=true;
	if(isset($set) && $set!="") WooAOI_show_fieldset($set,$opt);

}

/**
 * Validate fieldset data before adding product to cart
 * @since 0.3
 */
add_filter( 'woocommerce_add_to_cart_validation', 'WooAOI_product_validation', 10, 3 );
function WooAOI_product_validation($valid,$product_id,$quantity) {
	global $woocommerce;
	$valid=1;
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
				
				if(isset($_POST[$name])) {
					$switch=WooAOI_validate($_POST[$name],$type);
				}
				
				$data=$switch['data'];
				$pass=$switch['options']['pass'];
				
				if(isset($switch['options']['error']) && $switch['options']['error']!="") {
					$woocommerce->add_error( $switch['options']['error']);
					$valid=0;
				}
				
				if($type == 'password-repeat' && $pass['password']!=$pass['password-repeat']) {
					$woocommerce->add_error( __("Passwords don't match.",'woo-aoi'));
					$valid=0;
				}
				
				if(isset($fields[$i]['req']) && ($data=="" || $data=="-"))
				{
					$woocommerce->add_error( sprintf(__('%s is a required Field','woo-aoi'),$label));
					$valid=0;
				}
				
			endfor; 
		}
	  }
	if($valid==0) $woocommerce->set_messages();
  } 
  return $valid;
}

/**
 * When added to cart, save product fieldset data
 * @since 0.3
 */
add_filter( 'woocommerce_add_cart_item_data', 'WooAOI_product_save_data', 10, 2 );
function WooAOI_product_save_data ($cart_item_meta, $product_id) {
	global $woocommerce;
	
	if(isset($_POST['fieldset']) && is_array($_POST['fieldset'])) {
		// process all active fieldsets for this order
		foreach ($_POST['fieldset'] as $set) {
			$cart_item_meta['fieldset'] = $set;
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
						
						
						if(isset($_POST[$name]) && $_POST[$name]!="") {
							$data=WooAOI_validate($_POST[$name],$type);
							$display=$data['data'];
							if(is_array($display)) $display=implode(' ',$display);
							$cart_item_meta[$name] = esc_attr($display);
						}
				endfor; 
			}
		}
		
	}
	
	if(isset($_POST['cost']) && is_array($_POST['cost'])) {
		$tcost=0;
		foreach ($_POST['cost'] as $key => $cost) {
			
			if(preg_match("/\[([^\]]+)\]/", $cost, $calc)) {
			  $price=str_replace($calc[0],'',$cost);
			} else {
			  $price=$cost;
			  $calc[1]='*';
			}
			
			switch($calc[1]) {
				case "/":
					$cost=$cart_item_meta[$key] / $price;
				break;
				case "+":
					$cost=$cart_item_meta[$key] + $price;
				break;
				case "-":
					$cost=$cart_item_meta[$key] - $price;
				break;
				default:
					$cost=$cart_item_meta[$key] * $price;
				
			}
			$tcost=$tcost+$cost;
		}
		$cart_item_meta['cost']=$tcost;
	}
	return $cart_item_meta;
}

/** 
 * Get fieldset data from session on page load 
 * @since 0.3
 */
add_filter( 'woocommerce_get_cart_item_from_session', 'WooAOI_product_get_data_session', 10, 2 );
function WooAOI_product_get_data_session($cart_item, $values) {
	$set=get_post_meta($cart_item['product_id'],'_wooaoi_prod_prset',true);
	$tcost=0;
	if(isset($set) && $set!="") {
		$fields=get_post_meta($set,'_aoi_fields',true); 
		
		if (isset($fields) && $fields!="") {
		// loop through all fields
			for ( $i = 0; $i < count( $fields ); $i++ ) :
				if ( ! isset( $fields[$i] ) )
					break;
					
					
				if ( ! empty( $values[$fields[$i]['name']] ) ) {
				
					$display=$values[$fields[$i]['name']];
					if(is_array($values[$fields[$i]['name']])) $display=implode(' ',$display);

					$cart_item[$fields[$i]['name']] = $display;
					
					if($fields[$i]['type']=='price') {
					
						$price=$fields[$i]['price_adjust'];
						$price=str_replace(',','.',$price);
						
						$calc=$fields[$i]['options'];
						$key=$fields[$i]['name'];
						  
						switch($calc) {
							case "/":
								$cost=$cart_item[$key] / $price;
								break;
							case "+":
								$cost=$cart_item[$key] + $price;
								break;
							case "-":
								$cost=$cart_item[$key] - $price;
							break;
							default:
								$cost=$cart_item[$key] * $price;
								
								break;
						  }
						$tcost=$tcost+$cost;
					}
				}
			endfor; 
		}
	}
	if($tcost!=0) $cart_item['data']->adjust_price( $tcost );

	return $cart_item;
}

/**
 * Display fieldset data on cart
 * @since 0.3
 */
add_filter( 'woocommerce_get_item_data','WooAOI_product_display_data', 10, 2 );
function WooAOI_product_display_data( $item_data, $cart_item ) {

	$set=get_post_meta($cart_item['product_id'],'_wooaoi_prod_prset',true);
	
	if(isset($set) && $set!="") {
		$fields=get_post_meta($set,'_aoi_fields',true); 
		
		if (isset($fields) && $fields!="") {
		// loop through all fields
			for ( $i = 0; $i < count( $fields ); $i++ ) :
				if ( ! isset( $fields[$i] ) )
					break;
				if ( ! empty( $cart_item[$fields[$i]['name']] ) ) {
				
					$minus=$price_adjust='';
					if($fields[$i]['type']=='price') {
						$price=$fields[$i]['price_adjust'];
						$calc=$fields[$i]['options'];
						
						if($price!=0) {
							if (strpos($price, '-') !== FALSE) {
								$price=str_replace('-','',$price);
								$minus='-';
							}
							$price=str_replace(',','.',$price);
							$price_adjust=' '.$calc.' '.$minus.woocommerce_price($price);
						}
					}
					$item_data[] = array(
						'name'    => esc_attr($fields[$i]['label']),
						'value'   => $cart_item[$fields[$i]['name']],
						'display' =>str_replace('.',',',$cart_item[$fields[$i]['name']]).''.$price_adjust
					);
				}
			endfor; 
		}
	}
	
	return $item_data;
}


/**
 * Adjust price after adding to cart
 * @since 0.3
 */
add_filter( 'woocommerce_add_cart_item', 'WooAOI_product_add_cart_item', 10, 1 );
function WooAOI_product_add_cart_item( $cart_item ) {
	if ( ! empty( $cart_item['cost'] ) ) $cart_item['data']->adjust_price( $cart_item['cost'] );
	return $cart_item;
}

/**
 * After ordering, add data to order line items
 * @since 0.3
 */
add_action( 'woocommerce_add_order_item_meta', 'WooAOI_product_add_order_item_meta', 10, 2 );
function WooAOI_product_add_order_item_meta( $item_id, $cart_item ) {
	$set=get_post_meta($cart_item['product_id'],'_wooaoi_prod_prset',true);
	
	if(isset($set) && $set!="") {
		$fields=get_post_meta($set,'_aoi_fields',true); 
		
		if (isset($fields) && $fields!="") {
		// loop through all fields
			for ( $i = 0; $i < count( $fields ); $i++ ) :
				if ( ! isset( $fields[$i] ) )
					break;
				if ( ! empty( $cart_item[$fields[$i]['name']] ) ) {
					woocommerce_add_order_item_meta( $item_id, esc_attr($fields[$i]['label']), $cart_item[$fields[$i]['name']] );
				}
			endfor; 
		}
	}
}

/** 
 * Change add to cart button on loop if product has special fields enabled
 * @since 0.3
 */
add_filter( 'add_to_cart_url', 'WooAOI_change_addtocart' );
function WooAOI_change_addtocart( $link ) {
	global $product;

	$set=get_post_meta($product->id,'_wooaoi_prod_prset',true);
	
    if( isset($set) && $set!="" ) {
		$link=get_permalink( $product->id );
        $product->product_type = 'variable';
    }

    return $link;
}