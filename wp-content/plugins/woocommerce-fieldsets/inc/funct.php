<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/** 
* WordPress Administration Menu - Shows WooCommerce submenu item for plugin
* @since 0.1
*/
function WooAOI_admin_menu() {
	$page = add_submenu_page('woocommerce', __( 'Fieldsets', 'woo-aoi' ), __( 'Fieldsets', 'woo-aoi' ), 'manage_woocommerce', 'woo_aoi', 'WooAOI_page' );
	$subpage = add_submenu_page('woo_aoi', 'Edit fieldset', 'Edit fieldset', 'manage_woocommerce', 'woo_aoi_set', 'WooAOI_page_set');
}

/**
* Add meta boxes to order detail page
* @since 0.1
*/
function WooAOI_add_metabox() {
	add_meta_box( 'woo-aoi-product-box', __( 'Fieldset', 'woo-aoi' ), 'WooAOI_product_box', 'product', 'side', 'default' );
}

/**
 * Metabox content for product page
 * @since 0.1
 */
function WooAOI_product_box($post) {
	wp_nonce_field( 'wooaoi_product', 'wooaoi_product' );
	$checkout_posts[]=WooAOI_get_opt(array('overwrite','billing_c'));
	$checkout_posts[]=WooAOI_get_opt(array('overwrite','shipping_c'));
	$checkout_posts[]=WooAOI_get_opt(array('overwrite','account_c'));
	$checkout_posts[]=WooAOI_get_opt(array('overwrite','order_c'));
	?>
		<p>
											<label for="wooaoi_prod"><b><?php _e("Order detail / Checkout fieldset:", "woo-aoi" ); ?></b></label>
											<select name="wooaoi_prod" name="wooaoi_prod">
												<?php 
												echo '<option value="" '.selected(get_post_meta($post->ID,'_wooaoi_prod',true),'',0).'>'.__('No fieldset','woo-aoi').'</option>';
												
												$fieldsets=WooAOI_get_sets();
												
												if(isset($fieldsets) && !empty($fieldsets)) {
												  echo '<optgroup style="margin:5px 0 0 0;" label="'.__('Custom fieldsets','woo-aoi').'">';
												  foreach ($fieldsets as $set) {
													if(!in_array($set['ID'],$checkout_posts)) {
													  echo '<option value="'.$set['ID'].'" '.selected(get_post_meta($post->ID,'_wooaoi_prod',true),$set['ID'],0).'>'.$set['name'].'</option>';	
													}
												  }
												  echo '</optgroup>';
												}
												
												?>
											</select>
											<br><span class="description">
												<?php _e("Which fieldset do you want to show on the checkout page and order detail page?", "woo-aoi" );?><br>
											</span>
	</p><p>
											<label for="wooaoi_prod_prset"><b><?php _e("Product detail fieldset:", "woo-aoi" ); ?></b></label>
											<select name="wooaoi_prod_prset" name="wooaoi_prod_prset">
												<?php 
												echo '<option value="" '.selected(get_post_meta($post->ID,'_wooaoi_prod_prset',true),'',0).'>'.__('No fieldset','woo-aoi').'</option>';
												
												$fieldsets=WooAOI_get_sets();
												
												if(isset($fieldsets) && !empty($fieldsets)) {
												  echo '<optgroup style="margin:5px 0 0 0;" label="'.__('Custom fieldsets','woo-aoi').'">';
												  foreach ($fieldsets as $set) {
													if(!in_array($set['ID'],$checkout_posts)) {
													  echo '<option value="'.$set['ID'].'" '.selected(get_post_meta($post->ID,'_wooaoi_prod_prset',true),$set['ID'],0).'>'.$set['name'].'</option>';	
													}
												  }
												  echo '</optgroup>';
												}
												
												?>
											</select>
											<br><span class="description">
												<?php _e("Which fieldset do you want to show on the product detail page (before checkout)?", "woo-aoi" );?><br>
											</span>
	</p><?php
}

function WooAOI_save_metabox( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	update_post_meta( $post_id, '_wooaoi_prod', $_POST['wooaoi_prod'] );
	update_post_meta( $post_id, '_wooaoi_prod_prset', $_POST['wooaoi_prod_prset'] );
}

/**
* Order detail export box with button
* @since 0.1
*/
function WooAOI_order_box($post) {
	$order=new WC_Order($post->ID);
	$j=1;
	echo '<div class=woo-aoi-box>';
	echo 'test';
	echo '</div>';
}
/**
 * Templating
 * @since 0.1
 */
function WooAOI_replace($matches) {
  global $replace_values;
  return $replace_values[$matches[1]];
}

/**
 * Show descr on thank you page
 * @since 0.1
 */
function WooAOI_thankyou($order_id) {
	/*if(isset($order_id->id) && $order_id->id>0) {
		$order = new WC_Order( $order_id->id );
		$order_id=$order->id;
	} else {
		$order = new WC_Order( $order_id );
	}*/
	$order=new WC_Order($order_id);
	$option=get_option('wooaoi_set');
	if(isset($option['ty_descr']['title']) && $option['ty_descr']['title']!="") echo '<h2>'.$option['ty_descr']['title'].'</h2>';
	$woo_descr =stripslashes(wp_kses_post($option['ty_descr']['txt']));
	
	$count = 0;
	do {

		if ( version_compare( WOOCOMMERCE_VERSION, "2.0.99" ) <= 0 ) { 
			$viewOrderUrl=esc_url( add_query_arg('order', $order->id, get_permalink( woocommerce_get_page_id( 'view_order' ) ) ) );
		} else { 
			$viewOrderUrl=$order->get_view_order_url();
		}
		$woo_descr = preg_replace("/\{{link\}}(.*?)\{{\/link\}}/usi", '<a href="'.$viewOrderUrl.'">$1</a>', $woo_descr, -1, $count );
	
	} while ( $count > 0 );
	echo isset($woo_descr) ? '<div class="woo-aoi-descr">'.apply_filters('the_content', $woo_descr).'</div>' : ''; 
}

/**
 * Check if an option exists and if it is empty or not
 * @since 0.1
 * 0.2 Added support for special / foreign characters
 */
function WooAOI_get_opt($option,$default=false) {
	
	$return=false;
	if(get_option('wooaoi_set')!="") $options=get_option('wooaoi_set'); else return false;
	
	foreach($option as $opt) {
		if(array_key_exists($opt,$options)) {
			$return=$options=$options[$opt];
		} else {
			$return=false;
		}
	}
	
	if($return==false || empty($return)) $return=$default;
	$return= stripslashes(esc_attr($return));
	$return= str_replace('€', '&euro;', $return);
	return $return;
}

/**
 * Get fieldset data
 * @since 0.1
 */
function WooAOI_get_data($option,$default=false) {
	
	$return=false;
	if(get_option('wooaoi_sets')!="") $options=get_option('wooaoi_sets'); else return false;
	
	foreach($option as $opt) {
		if(array_key_exists($opt,$options)) {
			$return=$options=$options[$opt];
		} else {
			$return=false;
		}
	}
	
	if($return==false || empty($return)) $return=$default;
	$return=htmlentities(stripslashes($return));
	return $return;
}

/**
 * Show descr on order detail page
 * @since 0.1
 */
function WooAOI_orderdetail($order_id) {
	
	if (isset($order_id) && (int)$order_id>0) {
		$s='od';
	} else {
		$s='ov';
	}

	$option=get_option('wooaoi_set');
	if(isset($option[$s.'_descr']['title']) && $option[$s.'_descr']['title']!="") echo '<h2>'.$option[$s.'_descr']['title'].'</h2>';
	
	if($option[$s.'_descr']['txt'] && $option[$s.'_descr']['txt']!="") {
		$woo_descr =stripslashes(wp_kses_post($option[$s.'_descr']['txt']));
		echo isset($woo_descr) ? '<div class="woo-aoi-descr">'.apply_filters('the_content', $woo_descr).'</div>' : ''; 
	}
}

/**
 * Show fields after checkout 
 * @since 0.1
 */
function WooAOI_orderdetail_fields($order_id) {
	$option=get_option('wooaoi_set');
	
	if (wzn_getPage()) {
		$s='ty';
	} elseif(isset($order_id) && $order_id>0) {
		$s='od';
	} else {
		$s='ov';
	}

	$opt['page']=$s;
	$fieldsets=$option[$s.'_set'];
  if(isset($fieldsets)) {
	foreach ($fieldsets as $fieldset) {
	
	if($fieldset=='') {
		return false;
	} elseif($fieldset==1) {
		$sets=array();
		$order=new WC_Order($order_id);
		foreach ( $order->get_items() as $item ) {
			$product=get_product($item['product_id']);
			$set=get_post_meta($product->id,'_wooaoi_prod',true);
			if(isset($set) && $set!="") {
				$sets[]=$set;
			}
		}
		
		$sets=array_unique($sets);
		foreach($sets as $set) {
			WooAOI_show_fieldset($set,$opt,false,$order_id);
		}
		
		
	} else {
		WooAOI_show_fieldset($fieldset,$opt,false,$order_id);
	}
	
	}
  }
}

/** 
 * Show complete fieldset
 * @since 0.1
 */
function WooAOI_show_fieldset($id,$opt=false,$woo=false,$order_id=false) {

	$fields=get_post_meta($id,'_aoi_fields',true); 
	$checkout=$user_id=$end_form=false;
	global $aoi_error;
	$output=false;
	if(isset($opt['user_id'])) $user_id=$opt['user_id'];
	if(isset($opt['checkout'])) $checkout=true;
	if (isset($fields) && $fields!="") {
	
		// start form 
	  if($user_id==false && $checkout==false) {
		$end_form=true;
		$tag='p';
		echo '<form class="wooaoi-form clearfix" action="" method="post" id="wooaoi_'.$id.'">';
		
		if(isset($order_id) && $order_id>0) {
			$setstatus=get_post_meta( $id, '_set_status', true );
			
			if(isset($opt['page']) && $opt['page']=='od') {
				$order=new WC_Order($order_id);
				
				if(is_array($setstatus) && !in_array($order->status,$setstatus)) {
					return false;
				}
			}
			
			$user_id=false;
			echo '<input type="hidden" name="order_id" value="'.(int)$order_id.'">';
		} elseif(is_user_logged_in()) {
			$user_id=get_current_user_id();
			$order_id=false;
			echo '<input type="hidden" name="user_id" value="'.(int)$user_id.'">';
		}
		
		echo '<input type="hidden" name="fieldset[]" value="'.(int)$id.'">';
		wp_nonce_field('wooaoi_fr','wooaoi');
		
	  } elseif($checkout==true) {
	    $tag='p';
		echo '<input type="hidden" name="fieldset[]" value="'.(int)$id.'">';
		$order_id=false; $output='checkout';
	  } else {
		echo '<table class=form-table>';
		$tag='tr';
		$order_id=false; $output='hidden';
	  }
		
		// check if form is submitted, success or errors
		if (isset($_POST['wooaoi']) && wp_verify_nonce($_POST['wooaoi'],'wooaoi_fr') && $_POST['fieldset'][0]==$id) {
			if(empty($aoi_error->errors)) {
				echo '<div class="wooaoi-message wooaoi-success">'.__('Data sent successfully','woo-aoi').'</div>';
			} else {
				echo '<div class="wooaoi-message wooaoi-errors">'.__("We've found some errors while sending data, please check your data",'woo-aoi').'</div>';
			}
		}
		
		// loop through all fields
		for ( $i = 0; $i < count( $fields ); $i++ ) :
       		if ( ! isset( $fields[$i] ) )
				break;
		  
		  
		// Check if field required isset, if not: set false
		if(!isset($fields[$i]['req']) || empty($fields[$i]['req'])) $fields[$i]['req']=false;
		
		if(!isset($fields[$i]['woo']) || $fields[$i]['woo']!=1) {
		
		// get fieldset id and submit it
		switch ($fields[$i]['type']) {
			case 'textarea':
				WooAOI_textarea($fields[$i],$order_id,$user_id,$output,$tag);
				break;
			case 'select':
			case 'multi-select':
			case 'state':
			case 'country':
				WooAOI_select($fields[$i],$order_id,$user_id,$output,$tag);
				break;
			case 'radio':
				WooAOI_radio($fields[$i],$order_id,$user_id,$output,$tag);
				break;
			case 'checkbox':
				WooAOI_checkbox($fields[$i],$order_id,$user_id,$output,$tag);
				break;
			case 'date':
				WooAOI_datepicker($fields[$i],$order_id,$user_id,$output,$tag);
				break;
			case 'color':
				WooAOI_colorpicker($fields[$i],$order_id,$user_id,$output,$tag);
				break;
			case 'password-repeat':
				WooAOI_passwordR($fields[$i],$order_id,$user_id,$output,$tag);
				break;
			case 'heading':
				WooAOI_heading($fields[$i],$output,$tag);
				break;
			case 'texts':
				WooAOI_texts($fields[$i],$output,$tag);
				break;
			case 'submit':
				WooAOI_submit($fields[$i],$output,$tag);
				break;
			case 'redirect':
				WooAOI_redirect($fields[$i],$output,$tag);
				break;
			case 'status':
				WooAOI_status($fields[$i],$output,$tag);
				break;	
			case 'price':
				WooAOI_price($fields[$i],$order_id,$user_id,$output,$tag);
				break;
			default:
				WooAOI_text($fields[$i],$order_id,$user_id,$output,$tag);
		}
		
		}
	endfor; 
		// end form
		if($end_form==true) {
			echo '</form>';
		} else { echo '</table>';}
	}
}

/** 
 * Process submitted data and add it to order
 * @since 0.1
 */
function WooAOI_process_data() {
	if (isset($_POST['wooaoi']) && wp_verify_nonce($_POST['wooaoi'],'wooaoi_fr')) {
		
		// loop through all posted data, check if key starts with aoi_ en submit it to the order / user
		global $aoi_error;
		
		$aoi_error=new WP_Error();
		
		$fieldsets=$_POST['fieldset'];
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
							
						  if (isset($_POST[$name])) {
							
							if(isset($_POST['order_id'])) $order_id=$_POST['order_id'];

							$switch=WooAOI_validate($_POST[$name],$type);
				
							$data=$switch['data'];
							$pass=$switch['options']['pass'];
				
							if(isset($switch['options']['error']) && $switch['options']['error']!="") {
								$aoi_error->add($name, $switch['options']['error']);
							}
							
							if($type == 'password-repeat' && $pass['password']!=$pass['password-repeat']) {
								$aoi_error->add($name, __("Passwords don't match.",'woo-aoi'));
							}
							
							if(isset($fields[$i]['req']) && ($data=="" || $data=="-")) 
							{
								$aoi_error->add($name, __("Please enter required data.",'woo-aoi'));
							}
						  } 
						  
							if(isset($data) && $data!="") {
								if(isset($order_id)) {
									update_post_meta( $order_id, $label, $data);
								} elseif (isset($_POST['user_id'])) {
									$user_id=$_POST['user_id'];
									update_user_meta( $user_id, $label, $data);
								}
							}
						  
					endfor; 
				}
			}
			
			// Handling special actions after succesfull post (only if no errors)
			if(empty($aoi_error->errors)) {
				
				// Order status change
				if(isset($_POST['status']) && $_POST['status']!="" && isset($order_id) && $order_id!="") {
					$order = new WC_Order($order_id);
					$order->update_status(esc_attr($_POST['status']));
				}
				
				if(isset($_POST['redirect']) && $_POST['redirect']!="") {
					// Redirect
					wp_redirect(esc_attr($_POST['redirect'])); exit;
				}
			}
			
		}
	}
}

/**
 * Register scripts
 * @since 0.1
 */
function WooAOI_scripts($hook_suffix) {
	if(isset($_REQUEST['post_type'])) {
		$type=$_REQUEST['post_type'];
	} else {
		$type=get_post_type();
	}
	
	if ( $hook_suffix == 'woocommerce_page_woo_aoi' || (( $hook_suffix=='post.php' || $hook_suffix=='post-new.php') && $type=='woo_aoi_fieldset') ) {
		//wp_enqueue_script( 'script_wooaoi', PLUGIN_PATH.'/assets/scripts.js', array( 'jquery' ), '0.1' );
		
		
		wp_enqueue_script( 'ajax-script', PLUGIN_PATH.'/assets/scripts.js', array('jquery'));

		// in javascript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
		wp_localize_script( 'ajax-script', 'ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );
		
		if(!wp_script_is('jquery-ui-sortable', 'queue')){
            wp_enqueue_script('jquery-ui-sortable');
        }
		if(!wp_script_is('jquery-ui-tabs','queue')) {
			wp_enqueue_script("jquery-ui-tabs"); 
		}
	}
}

/**
 * Ajax handler for fieldset settings refresh
 * @since 0.3
 */
add_action('wp_ajax_my_action', 'my_action_callback');
function my_action_callback() {
	//global $wpdb;
	
	$fields=new WooFields;

	$type = $_POST['type'];
	$id = $_POST['id'];

	echo $fields->get_options($type,$id);

	die();
}

/**
* Prepare WP List table for fieldsets
* @since 0.1
*/
function WooAOI_table(){
  $WooAOI_Table = new WooAOI_List_Table();
  $WooAOI_Table->prepare_items(); 
  $WooAOI_Table->display(); 
}

/**
 * Get active fieldsets
 * @since 0.1
 */
function WooAOI_get_sets() {
	
	$sets = new WP_Query( array( 'post_type' => 'woo_aoi_fieldset', 'posts_per_page' => -1 ) );
	$sets=$sets->posts;
	
	$return=array();
	foreach ($sets as $set) {
		$return[]=array('ID'=>$set->ID,'slug'=>$set->post_name,'name'=>$set->post_title);
	}
	
	return $return;
}

/**
 * functions to create custom post type for fieldsets
 * @since 0.1
 */
add_action( 'init', 'WooAOI_create_CPT' );

function WooAOI_create_CPT() {
	register_post_type( 'woo_aoi_fieldset', 
		array(
			'labels' => array(
				'name' => __( 'WooCommerce Forms & Fields' ,'woo-aoi'),
				'singular_name' => __( 'WooCommerce Forms & Fields','woo-aoi' ),
				'add_new'=>__('Add new fieldset','woo-aoi'),
				'add_new_item'=>__('Add new fieldset','woo-aoi'),
				'edit'=>__('Edit fieldset','woo-aoi'),
				'edit_item'=>__('Edit fieldset','woo-aoi'),
				'new_item'=>__('New fieldset','woo-aoi'),
			),
			'public' => false,
			'show_ui'=>true,
			'publicly_queryable' => false,
			'exclude_from_search' => true,
			'supports'=>array('title'),
			'can_export'=>false,
			'show_in_nav_menus'=>false,
			'show_in_menu'=>false,
			'show_in_admin_bar'=>false,
			'register_meta_box_cb' => 'WooAOI_call_metabox',
		)
	);
}

function WooAOI_call_metabox($post) {
	add_meta_box(
            'wooaoi_box_descr',
            __( 'Fieldset settings', 'woo-aoi' ),
            'WooAOI_metabox_descr'
    );
	add_meta_box(
            'wooaoi_box_fields',
            __( 'Fields within this set', 'woo-aoi' ),
            'WooAOI_metabox_fields'
    );
	add_meta_box(
            'wooaoi_box_status',
            __( 'Fieldset status', 'woo-aoi' ),
            'WooAOI_metabox_status',
			'woo_aoi_fieldset',
			'side'
    );
	
}

function WooAOI_metabox_descr( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'wooaoi_nonce' );

  // The actual fields for data entry
  // Use get_post_meta to retrieve an existing value from the database and use the value for the form
  $value = get_post_meta( $post->ID, '_set_descr', true );
  ?>
  <table class="form-table">
	<tbody>
	  <tr>
		<th>
		  <label for="set_descr"><b>
			<?php _e("Description for this set", 'woo-aoi' ); ?>
		  </b></label>
		</th>
		<td>
			<textarea style="width:100%;height:100px;" id="set_descr" name="set_descr" ><?php echo esc_attr($value);?></textarea>
		</td>
	  </tr>
	</tbody>
  </table>
  <?php 
}

/** 
 * Show fieldset status in side column
 * @since 0.3
 */
function WooAOI_metabox_status( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'wooaoi_nonce' );

  // The actual fields for data entry
  // Use get_post_meta to retrieve an existing value from the database and use the value for the form
  $value = get_post_meta( $post->ID, '_set_descr', true );
  ?>
  <p>
		  <label for="set_status"><b>
			<?php _e("Show set on order status:", 'woo-aoi' ); ?>
		  </b></label><br>
		<?php $statusset = get_post_meta( $post->ID, '_set_status', true );
		if(empty($statusset) || !is_array($statusset)) { $checked='checked';} else {$checked=''; }
			// retrieve all active WooCommerce order statuses

            // WC 2.2 support
            if (function_exists('wc_get_order_statuses')) {

                $statuses = wc_get_order_statuses();
                ksort($statuses);
                $i=0;
                foreach( $statuses as $status => $status_name ) {

      				$status = str_replace('wc-', '', $status);
    				$values[ $status ] = $status_name;

      			?>
      				<input type=checkbox name="set_status[<?php echo $i;?>]"  value="<?php echo $status;?>" <?php if(isset($statusset[$i]) && $statusset[$i]==$status) { echo 'checked';} echo $checked;?> > <?php _e($status_name,'woocommerce');?><br>
      			<?php $i++;
      			}

            } else {

      			$statuses = get_terms( 'shop_order_status', array( 'hide_empty' => false ) );
      			$values = array();
      			$i=0;

      			foreach( $statuses as $status ) {
      				$values[ $status->slug ] = $status->name;
      			?>
      				<input type=checkbox name="set_status[<?php echo $i;?>]"  value="<?php echo $status->slug;?>" <?php if(isset($statusset[$i]) && $statusset[$i]==$status->slug) { echo 'checked';} echo $checked;?> > <?php _e($status->name,'woocommerce');?><br>
      			<?php $i++;
      			}

            }
			?>
		<br><span class="description"><?php _e('Only available on order detail page','woo-aoi');?></span></p>
  <?php 
}

function WooAOI_metabox_fields( $post ) {
  
  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'wooaoi_nonce' );

  ?>
  <style type="text/css">
.aoi-replace-text,.aoi-replace-textarea,.aoi-clone,.aoiset-statusselect {
display:none;
}
.widefat input[type="text"],.widefat textarea,.widefat select {
width:100%;
}
.aoi_replace {
width: 20%;
}
.aoi-order {
cursor:move;
}
.aoi-table > tbody > tr > td {
	background: #fff;
    border-right: 1px solid #ededed;
    border-bottom: 1px solid #ededed;
    padding: 8px;
    position: relative;
}

.aoi-table > tbody > tr:last-child td { border-bottom: 0 none; }
.aoi-table > tbody > tr td:last-child { border-right: 0 none; }
.aoi-table > thead > tr > th { border-right: 1px solid #e1e1e1; }
.aoi-table > thead > tr > th:last-child { border-right: 0 none; }

.aoi-table tr td.aoi-order,
.aoi-table tr th.aoi-order {
	width: 16px;
	text-align: center;
	vertical-align: middle;
	color: #aaa;
	text-shadow: #fff 0 1px 0;
}

.aoi-table .aoi-remove {
	width: 16px;
	vertical-align: middle;
}
.aoi-table input[type="text"] {
width: 100%;
}

.aoi-add-field {margin-top:10px !important}
.aoi-table .wooaoi-options {background:#f6f6f6;display:block;clear:both;padding:10px;}
.aoi-table .wooaoi-options:after {content:' ';display:block;clear:both}
.aoi-table .wooaoi-options p {display:inline-block;float:left;margin-top:0px !important;height:22px}
.aoi-table .wooaoi-options p label {width:25%;min-width:100px;display:inline-block}
.aoi-table .wooaoi-options p input[type=text], .wooaoi-options p select {width:60%;margin:0px}
.aoi-table .wooaoi-options p input.small-text {max-width:60px}
.wooaoi-options .w50 {width:50%}
.wooaoi-options .w25 {width:25%}
.aoi-table .wooaoi-options p.w25 label{width:auto}
.wooaoi-options .w100 {width:100%}
.wooaoi-hide-options,.wooaoi-view-options {cursor:pointer;color:#ad74a2;font-weight:bold;width:100%;display:block;text-align:right;height:26px;}
.wooaoi-hide-options{background:#fff;margin:-10px 0 10px -10px;padding:0 10px;border-bottom:1px solid #ccc;}
</style>
 
 <?php 
 	$options = get_option( 'wooaoi_set' );
	if(isset($_GET['post']) && $_GET['post']==WooAOI_get_opt(array('overwrite','billing_c'))) { $checkout_set=1; $colspan=3;} 
	elseif(isset($_GET['post']) && $_GET['post']==WooAOI_get_opt(array('overwrite','shipping_c'))) { $checkout_set=1; $colspan=3;} 
	elseif(isset($_GET['post']) && $_GET['post']==WooAOI_get_opt(array('overwrite','order_c'))) { $checkout_set=1; $colspan=3;} 
	elseif(isset($_GET['post']) && $_GET['post']==WooAOI_get_opt(array('overwrite','account_c'))) { $checkout_set=2; $colspan=3;} 
	else {$checkout_set=0; $colspan=4;}
	
	$fields_class=new WooFields;
 
	if($checkout_set==1) {
		$fields_class->get_checkout_fields();
		$fields_class->remove_fields('WooFieldsActions');
	}
	
	$fields_output=$fields_class->get_fields();
	$fields=get_post_meta($post->ID,'_aoi_fields',true);
	
  ?>
  <table class="widefat aoi-table" border="0">
	<thead>
	  <tr>
		<th style="width:5%;" class="aoi-order" title="<?php esc_attr_e( 'Change order' , 'woo-aoi' ); ?>"></th>
		<!--<th width="15%"><?php _e('Name' , 'woo-aoi' ); ?></th>-->
		<th width="15%"><?php _e('Field type' , 'woo-aoi' ); ?></th>
		<th width="15%"><?php _e('Label' , 'woo-aoi' ); ?></th>
		<th><?php _e('Field settings' , 'woo-aoi' ); ?></th>
		<!--<th><?php _e('Placeholder / Options' , 'woo-aoi' ); ?></th>
		<th width="12%"><?php _e('Position' , 'woo-aoi' ); ?></th>
		<?php if($checkout_set==0) { echo '<th>'.__('Description' , 'woo-aoi' ).'</th>';} ?>
		<th width="60px"><?php _e('Required' , 'woo-aoi' ); ?></th>
		<th width="60px"><?php _e('Clear row', 'woo-aoi' ); ?></th>-->
        <th width="2%" scope="col" title="<?php esc_attr_e( 'Remove field', 'woo-aoi' ); ?>"></th>		
	  </tr>
	</thead>
	<tbody>

	<?php
	if (isset($fields) && $fields!="") {
	
		for ( $i = 0; $i < count( $fields ); $i++ ) :
       		if ( ! isset( $fields[$i] ) )
				break;
				
				$readonly='';
				if(isset($fields[$i]['woo']) && $fields[$i]['woo']==1) {$readonly='readonly';}
?>	  <tr valign="top" class="aoi-row">
		<td class="aoi-order" title="<?php esc_attr_e( 'Change order', 'woo-aoi' ); ?>"><?php echo $i + 1; ?></td>
			
		<!--<td>
			
			<input type="text" class="aoiset-name" name="aoi_field[<?php echo $i; ?>][name]" maxlength=50 <?php echo $readonly;?> value="<?php echo esc_attr( $fields[$i]['name'] ); ?>" />
		</td>-->
        <td><input type=hidden name="aoi_field[<?php echo $i; ?>][woo]" value="<?php if(isset($fields[$i]['woo']) && $fields[$i]['woo']==1) { echo 1;} else { echo 0; }?>">
			<select class=aoiset-select name="aoi_field[<?php echo $i;?>][type]">
				<?php 
				foreach ($fields_output as $group) {
					echo '<optgroup label="'.$group['name'].'">';

					foreach ($group['fields'] as $key=>$myfields) {
						echo '<option '.selected($fields[$i]['type'],$key).' value="'.$key.'">'.$myfields['name'].'</option>';
					}
				}
			  
/*			  if($fields[$i]['type']=='state' && $fields[$i]['woo']==1) {
				echo '<option '.selected($fields[$i]['type'],'state').' value="state">'.__('Checkout field - State','woo-aoi').'</option>';
			  } elseif($fields[$i]['type']=='country' && $fields[$i]['woo']==1) {
				echo '<option '.selected($fields[$i]['type'],'country').' value="country">'.__('Checkout field - Country','woo-aoi').'</option>';
			  } else {
				echo '
			  <optgroup label="'.__('Form fields','woo-aoi').'">
				<option '.selected($fields[$i]['type'],'text').' value="text">'.__('Text field','woo-aoi').'</option>
				<option '.selected($fields[$i]['type'],'textarea').' value="textarea">'.__('Textarea','woo-aoi').'</option>
				<option '.selected($fields[$i]['type'],'select').' value="select">'.__('Select','woo-aoi').'</option>';
			if($checkout_set!=1) {
				echo '<option '.selected($fields[$i]['type'],'password').' value="password">'.__('Password','woo-aoi').'</option>';
			}
			if($checkout_set==0) {
				echo '<option '.selected($fields[$i]['type'],'multi-select').' value="multi-select">'.__('Multi-select','woo-aoi').'</option>
				<option '.selected($fields[$i]['type'],'radio').' value="radio">'.__('Radio','woo-aoi').'</option>
				<option '.selected($fields[$i]['type'],'checkbox').' value="checkbox">'.__('Checkbox','woo-aoi').'</option>
				<option '.selected($fields[$i]['type'],'submit').' value="submit">'.__('Submit Button','woo-aoi').'</option>';
			} 
			echo '</optgroup>
			  <optgroup label="'.__('Special Fields','woo-aoi').'">';
			if($checkout_set==0) {
			echo'<option '.selected($fields[$i]['type'],'password-repeat').' value="password-repeat">'.__('Password repeat','woo-aoi').'</option>
				<option '.selected($fields[$i]['type'],'date').' value="date">'.__('Datepicker','woo-aoi').'</option>
				<option '.selected($fields[$i]['type'],'color').' value="color">'.__('Colorpicker','woo-aoi').'</option>
				<option '.selected($fields[$i]['type'],'email').' value="email">'.__('Email address','woo-aoi').'</option>
				<option '.selected($fields[$i]['type'],'price').' value="price">'.__('Price adjust','woo-aoi').'</option>';
			} else  {
				echo '<option '.selected($fields[$i]['type'],'country').' value="country">'.__('Checkout field - Country','woo-aoi').'</option>
				<option '.selected($fields[$i]['type'],'state').' value="state">'.__('Checkout field - State','woo-aoi').'</option>';
			}
			echo '</optgroup>';
			 if($checkout_set==0) { 
			  echo '<optgroup label="'.__('Texts','woo-aoi').'">
				<option '.selected($fields[$i]['type'],'heading').' value="heading">'.__('Heading','woo-aoi').'</option>
				<option '.selected($fields[$i]['type'],'texts').' value="texts">'.__('Text','woo-aoi').'</option>
			  </optgroup>
			  <optgroup label="'.__('Actions','woo-aoi').'">
				<option '.selected($fields[$i]['type'],'redirect').' value="redirect">'.__('Redirect URL','woo-aoi').'</option>
				<option '.selected($fields[$i]['type'],'status').' value="status">'.__('Change order status','woo-aoi').'</option>
			  </optgroup>'; }
			 } */?>
			</select>
		</td>
		<?php /*if($fields[$i]['type']=='heading') { ?>
		<td colspan="<?php echo $colspan;?>">
			<input class="aoiset-label" type="text" name="aoi_field[<?php echo $i; ?>][label]" value="<?php echo esc_attr( $fields[$i]['label'] ); ?>" />
		</td>
        <td colspan=2>
			<select class="aoiset-args" required name="aoi_field[<?php echo $i;?>][args]">
			  <?php 
				echo '<option '.selected($fields[$i]['args'],'').' value="">'.__('Select heading','woo-aoi').'</option>
				<option '.selected($fields[$i]['args'],'h1').' value="h1">'.__('H1','woo-aoi').'</option>
				<option '.selected($fields[$i]['args'],'h2').' value="h2">'.__('H2','woo-aoi').'</option>
				<option '.selected($fields[$i]['args'],'h3').' value="h3">'.__('H3','woo-aoi').'</option>
				<option '.selected($fields[$i]['args'],'h4').' value="h4">'.__('H4','woo-aoi').'</option>
				<option '.selected($fields[$i]['args'],'h5').' value="h5">'.__('H5','woo-aoi').'</option>
				<option '.selected($fields[$i]['args'],'h6').' value="h6">'.__('H6','woo-aoi').'</option>';
			  ?>
			</select>
		</td>
		<?php } elseif($fields[$i]['type']=='texts') {?>
		<td colspan="<?php echo $colspan;?>">
			<textarea class="aoiset-label" name="aoi_field[<?php echo $i; ?>][label]" title="<?php esc_attr_e( 'Text content', 'woo-aoi' ); ?>" /><?php echo esc_attr( $fields[$i]['label'] ); ?></textarea>
		</td>
		<td colspan=2>
			<select class="aoiset-args" name="aoi_field[<?php echo $i;?>][args]">
			  <?php 
				echo '<option '.selected($fields[$i]['args'],'').' value="">'.__('Select code','woo-aoi').'</option>
				<option '.selected($fields[$i]['args'],'p').' value="p">'.__('Paragraph','woo-aoi').'</option>
				<option '.selected($fields[$i]['args'],'div').' value="div">'.__('DIV','woo-aoi').'</option>
				<option '.selected($fields[$i]['args'],'address').' value="address">'.__('Address','woo-aoi').'</option>
				<option '.selected($fields[$i]['args'],'q').' value="q">'.__('Quote','woo-aoi').'</option>
				<option '.selected($fields[$i]['args'],'code').' value="code">'.__('Code','woo-aoi').'</option>
				<option '.selected($fields[$i]['args'],'pre').' value="pre">'.__('Predefined','woo-aoi').'</option>
				<option '.selected($fields[$i]['args'],'small').' value="small">'.__('Small','woo-aoi').'</option>';
			  ?>
			</select>
		</td>
		<?php } else { */?>
		<td>
			<input class="aoiset-label" type="text" name="aoi_field[<?php echo $i; ?>][label]" value="<?php echo esc_attr( $fields[$i]['label'] ); ?>" />
		</td>
		<td class=ajax_overwrite>
		
		
		<?php echo $fields_class->get_options($fields[$i]['type'],$i,$fields[$i],$checkout_set);?>
		
		
		
		
		</td>
		<?php /*
        <td>
			<input class="aoiset-args" type="text" name="aoi_field[<?php echo $i; ?>][args]" value="<?php echo esc_attr( $fields[$i]['args'] ); ?>" />
		</td>
		<td>
			<select class="aoiset-class" name="aoi_field[<?php echo $i; ?>][class][]">
				<?php 
				echo '<option value="form-row-wide" '.selected(in_array('form-row-wide',$fields[$i]['class']),1,false).' >'.__('Full width','woo-aoi').'</option>
				<option value="form-row-first" '.selected(in_array('form-row-first',$fields[$i]['class']),1,false).'>'.__('Left','woo-aoi').'</option>
				<option value="form-row-last" '.selected(in_array('form-row-last',$fields[$i]['class']),1,false).'>'.__('Right','woo-aoi').'</option>';
				?>
			</select>
			<?php if(is_array($fields[$i]['class']) && in_array('address-field',$fields[$i]['class'])) { echo '<input type=hidden name="aoi_field['.$i.'][class][]" value="address-field">'; } ?>
			<?php if(is_array($fields[$i]['class']) && in_array('update_totals_on_change',$fields[$i]['class'])) { echo '<input type=hidden name="aoi_field['.$i.'][class][]" value="update_totals_on_change">'; } ?>
		</td>
		<?php if($checkout_set==0) { ?>
		<td class=ajax_overwrite>
			<input class="aoiset-descr" type="text" name="aoi_field[<?php echo $i; ?>][descr]" value="<?php echo esc_attr( $fields[$i]['descr'] ); ?>" />
		</td><?php }?>
		<td align=center>
			<input class="aoiset-req" name="aoi_field[<?php echo $i; ?>][req]" type="checkbox" value="true" <?php if (  isset($fields[$i]['req']) && true == ($fields[$i]['req'])) echo "checked='checked'"; ?> />
		</td>
		<td align=center>
			<input class="aoiset-clear" name="aoi_field[<?php echo $i; ?>][clear]" type="checkbox" value="true" <?php if (  isset($fields[$i]['clear']) && true == ($fields[$i]['clear'])) echo "checked='checked'"; ?> />
		</td>
		<?php } */?>
		<td class="aoi-remove">
			<?php if($checkout_set==2 && $readonly=="readonly") { echo '-'; } else { ?>
			<a class="aoi-remove-btn" href="javascript:;" title="<?php esc_attr_e( 'Remove Field' , 'woo-aoi' ); ?>">&times;</a>
			<?php } ?>
		</td> 
	  </tr>

<?php 
	endfor; } 
	$i = 999; 
?>
	  <tr valign="top" class="aoi-clone" >
		<td class="aoi-order" title="<?php esc_attr_e( 'Change order' , 'woo-aoi' ); ?>"><?php echo $i; ?></td>
		<td>		<input type=hidden name="aoi_field[<?php echo $i; ?>][woo]" value="">
			<select class=aoiset-select name="aoi_field[<?php echo $i;?>][type]">
			<?php foreach ($fields_output as $group) {
					echo '<optgroup label="'.$group['name'].'">';

					foreach ($group['fields'] as $key=>$myfields) {
						echo '<option value="'.$key.'">'.$myfields['name'].'</option>';
					}
				}
			?>
			</select>
		</td>
        <td><input class="aoiset-label" type="text" name="aoi_field[<?php echo $i; ?>][label]" title="<?php esc_attr_e( 'Label of the New Field', 'woo-aoi' ); ?>" value="" /></td>
        <td class=ajax_overwrite><?php echo $fields_class->get_options('text',$i);?></td>
		<td class="aoi-remove"><a class="aoi-remove-btn" href="javascript:;" title="<?php esc_attr_e( 'Remove Field' , 'woo-aoi' ); ?>">&times;</a></td>
	  </tr>
	</tbody>
  </table>
  <a href="javascript:;" id="aoi-add-btn" class="button-secondary aoi-add-field"><?php _e( '+ Add new field' , 'woo-aoi' ); ?></a>

<?php 
}
/**
 * Check if value already exists inside array
 * @since 0.1
 */
function WooAOI_check_in_array($array, $key, $val) {
    foreach ($array as $item)
        if (isset($item[$key]) && $item[$key] == $val)
            return true;
    return false;
}

/**
 * Save fieldset data
 * @since 0.1
 */
function WooAOI_metabox_save( $post_id ) {
  // First we need to check if the current user is authorised to do this action. 
  if ( isset($_REQUEST['post_type']) && 'woo_aoi_fieldset' == $_REQUEST['post_type'] ) {
    if ( ! current_user_can( 'edit_page', $post_id ) )
        return;
  } else {
        return;
  }

  // Secondly we need to check if the user intended to change this value.
  if ( ! isset( $_POST['wooaoi_nonce'] ) || ! wp_verify_nonce( $_POST['wooaoi_nonce'], plugin_basename( __FILE__ ) ) )
      return;

  // Thirdly we can save the value to the database

   //if saving in a custom table, get post_ID
  $post_ID = $_POST['post_ID'];
  $insert=array();
  //sanitize user input
  $descr = esc_textarea( $_POST['set_descr'] );
  $statusses = $_POST['set_status'];
  
  // looping through all fields
  if(isset($_POST['aoi_field']) && is_array($_POST['aoi_field'])) {
  $i=0;
    foreach ($_POST['aoi_field'] as $id=>$field) {
	
	  if($id!=999) {
	  
	  $type=$field['type'];

	  if($type=='texts' || $type=='heading') {
		$field['name']=$type.'_'.$id;
	  } else {
		if(isset($field['name']) && $field['name']!="") {
			$field['name']=WooAOI_slug($field['name']);
		} elseif (isset($field['label']) && $field['label']!="") {
			$field['name']=WooAOI_slug($field['label']);
		} else {
			$field['name']='aoi_'.$post_ID.'_'.$id;
		}
	  }
		
		if(!isset($field['clear']) || $field['clear']=="") $field['clear']=false;
		if(!isset($field['descr']) || $field['descr']=="") $field['descr']='';
		if(!isset($field['label']) || $field['label']=="") $field['label']='';
	
	    // Check if label already exists inside fieldset, if exists add a random number to it to make it unique again
	  	if( WooAOI_check_in_array($insert,'name',$field['name'])) $field['name']=$field['name'].'_'.rand(0,999);
	
		$insert[$i]=$field;
		$i++;
	  }
	}
  }

  add_post_meta($post_ID, '_aoi_fields', $insert,true) or update_post_meta($post_ID, '_aoi_fields', $insert);
  add_post_meta($post_ID, '_set_descr', $descr, true) or update_post_meta($post_ID, '_set_descr', $descr);
  add_post_meta($post_ID, '_set_status', $statusses, true) or update_post_meta($post_ID, '_set_status', $statusses);
  
	
}

function WooAOI_slug($string) {
    //lower case everything
    $string = strtolower($string);
    //make alphaunermic
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean multiple dashes or whitespaces
    $string = preg_replace("/[\s]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s]/", "_", $string);
	
    return trim($string,'_');
}

/**
 * Count number of fields in set
 * @since 0.1
 */
function WooAOI_count_fields($id) {
	return count(get_post_meta($id,'_aoi_fields',true));
}

/**
* Geev updater active
* @since 0.1
*/
if(!function_exists('geev_active')) {
	function geev_active($plugin) {
		if(is_plugin_active('geev-updater/geev-updater.php')) {
			return geev_license_active($plugin);
		} else {
			return false;
		}
	}
}

/**
 * Validate all fields
 * @since 0.3
 */
function WooAOI_validate($name,$type) {
	$data=$name;
	$pass=$error=false;
	switch ($type) {
		case 'text':
		case 'date':
		case 'color':
		case 'textarea':
		case 'radio':
			if(isset($name) && !empty($name)) {
				$data=$name;
			} else {$data='';}
			break;
		case 'password':
		case 'password-repeat':
			if(isset($name) && !empty($name)) {
				$data=md5($name);
			} else {$data='';}
				$pass[$type]=$data;
			break;
		case 'email':
			if(is_email($name)) {
				$data=$name;
			} elseif($name!="") {
				$error=__("Invalid email address.",'woo-aoi');
			}
			break; 
		case 'checkbox':
		case 'select':
		case 'multi-select':
		case 'country':
		case 'state':
			if(isset($name)) {
				$data=implode('|',$name);
				if($data=="") $data='-';
			} else {$data='-';}
			break;
		case 'price':
			$num=str_replace(',','.',$name);
			if(is_numeric($num) && $num>0) { $data=$num; } else {$data=0; $error=__("Please enter a valid (positive) number.",'woo-aoi');}
			break;
		case 'submit':
			$label=$name='Submitted_on';
			$data=date('Ymd H:m');
			break;
	}
	$options=array('pass'=>$pass,'error'=>$error);
	return array('data'=>$data,'options'=>$options);
}

/**
 * Check if current page is thank you page or view-order page
 * @since 3.1
 */
function wzn_getPage() {

	$viewOrder=false;
	if ( version_compare( WOOCOMMERCE_VERSION, "2.0.99" ) <= 0 ) { 
		if(is_page( woocommerce_get_page_id( 'thanks' ))) {
			$viewOrder=true;
		}
	} else {
		$currentUrl = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		
		/*if (false !== strpos($currentUrl,get_option('woocommerce_myaccount_view_order_endpoint','view-order'))) {
			$viewOrder=true;
		} */
	
		if (false !== strpos($currentUrl,get_option('woocommerce_checkout_order_received_endpoint','order-received'))) {
			$viewOrder=true;
		} 
	}
	return $viewOrder;
}