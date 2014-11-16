<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'show_user_profile', 'WooAOI_show_profilefields' ,99);
add_action( 'edit_user_profile', 'WooAOI_show_profilefields' ,99);

function WooAOI_show_profilefields( $user ) { ?>

	<h3><?php _e('WooCommerce Fieldsets - Additional information','woo-aoi');?></h3>
	
	<?php $option=get_option('wooaoi_set');
	$opt['user_id']=$user->data->ID;
	
	$fieldsets=$option['ov_set'];
	if(isset($fieldsets)) {
		foreach ($fieldsets as $fieldset) {
			WooAOI_show_fieldset($fieldset,$opt);
		}
	}
	
	$billing_post=WooAOI_get_opt(array('overwrite','billing_c'));
	if(isset($billing_post) && $billing_post!="") WooAOI_show_fieldset($billing_post,$opt,1);
	
	$shipping_post=WooAOI_get_opt(array('overwrite','shipping_c'));
	if(isset($shipping_post) && $shipping_post!="") WooAOI_show_fieldset($shipping_post,$opt,1);
	
	$account_post=WooAOI_get_opt(array('overwrite','account_c'));
	if(isset($account_post) && $account_post!="") WooAOI_show_fieldset($account_post,$opt,1);
	
	?>
<?php }


add_action( 'personal_options_update', 'WooAOI_process_userdata' );
add_action( 'edit_user_profile_update', 'WooAOI_process_userdata' );

/** 
 * Process submitted user data
 * @since 0.1
 */
function WooAOI_process_userdata($user_id) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
		
		// loop through all posted data, check if key starts with aoi_ en submit it to the order
		$option=get_option('wooaoi_set');
		
		$sets=$option['ov_set'];

		if(isset($sets)) {
		
			foreach ($sets as $set) {
			
			// process all active fieldsets for this order
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
								
							switch ($type) {
								
								case 'password':
								case 'password-repeat':
									if(isset($_POST[$name]) && !empty($_POST[$name])) {
										$data=md5($_POST[$name]);
									} else {$data='';}
									$pass[$type]=$data;
									break;
								case 'email':
									if(is_email($_POST[$name])) {
										$data=$_POST[$name];
									} elseif($_POST[$name]!="") {
										
									}
									break; 
								case 'checkbox':
								case 'select':
								case 'multi-select':
									if(isset($_POST[$name])) {
										$data=implode('|',$_POST[$name]);
									} else {$data='';}
									break;
								default:
									if(isset($_POST[$name]) && !empty($_POST[$name])) {
										$data=$_POST[$name];
									} else {$data='';}
							}
							
							if(isset($data) && $data!="") {
								update_user_meta( $user_id, $label, $data);
							}
					endfor; 
				}
			}

		}
}