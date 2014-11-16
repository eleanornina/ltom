<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**************************************************************************
 *                  Basic Fields
 **************************************************************************/

/**
 * Textfield
 * @since 0.1
 */
function WooAOI_text($d,$order_id=false,$user_id=false,$output=false,$tag='p') {
	
	global $aoi_error;
	
	$req=WooAOI_req($d['req']);
	
	if($d['type']!='password') {
		$value=WooAOI_get_fieldvalue($d['label'],$order_id,$user_id);
	}
	if(!isset($d['class'])) $d['class']='form-row-wide';
	if(!isset($d['placeholder'])) $d['placeholder']='';
	echo '<'.$tag.' class="form-row '.WooAOI_class($d['class']).' wooaoi-row '.$req['class'].'">';

	echo WooAOI_tag($tag);
	
	if(isset($d['label']) && $d['label']!="") {
		echo '<label for="'.$d['name'].'">'.$d['label'].$req['astr'].'</label>'; 
	}
	
	echo WooAOI_tag($tag,1);
	
	WooAOI_descr($d['descr']);
	
	echo '<input name="'.$d['name'].'" type="'.$d['type'].'" id="'.$d['name'].'" class="input-text regular-text" placeholder="'. esc_attr($d['placeholder']).'" '.$req['class'].' value="';

	//displays value if exists
	if(isset($value) && $value!="") {
		echo $value;
	}
	
	echo '">';
	
	WooAOI_show_error($aoi_error,$d['name']);
	
	WooAOI_descr($d['descr'],1);
	
	echo WooAOI_tag($tag,2).'</'.$tag.'>';
	WooAOI_clear($d['clear'],$tag);
}

/**
 * Textarea
 * @since 0.1
 */
function WooAOI_textarea($d,$order_id=false,$user_id=false,$output=false,$tag='p') {
	global $aoi_error;
	
	$req=WooAOI_req($d['req']);
	
	$value=WooAOI_get_fieldvalue($d['label'],$order_id,$user_id);
	if(!isset($d['class'])) $d['class']='form-row-wide';
	if(!isset($d['placeholder'])) $d['placeholder']='';
	echo '<'.$tag.' class="form-row '.WooAOI_class($d['class']).' wooaoi-row '.$req['class'].'">';
	
	echo WooAOI_tag($tag);
	
	if(isset($d['label']) && $d['label']!="") {
		echo '<label for="'.$d['name'].'">'.$d['label'].$req['astr'].'</label>'; 
	}
	
	echo WooAOI_tag($tag,1);
	
	WooAOI_descr($d['descr']);
	echo '<textarea name="'.$d['name'].'" id="'.$d['name'].'" cols="30" rows="5" placeholder="'. esc_attr($d['placeholder']).'" '.$req['class'].' >';

	//displays value if exists
	if(isset($value) && $value!="") {
		echo esc_attr($value);
	}
		
	echo '</textarea>';
	
	WooAOI_show_error($aoi_error,$d['name']);
	
	WooAOI_descr($d['descr'],1);
	
	echo WooAOI_tag($tag,2).'</'.$tag.'>';
	WooAOI_clear($d['clear'],$tag);
}

/**
 * Selectbox
 * @since 0.1
 */
function WooAOI_select($d,$order_id=false,$user_id=false,$output=false,$tag='p') {
	global $aoi_error;
	
	$req=WooAOI_req($d['req']);
	
	$value=WooAOI_get_fieldvalue($d['label'],$order_id,$user_id);
    $value=explode('|',esc_attr($value));
	
	if($d['type']=='multi-select') {
		$multiple='multiple';
	} else {
		$multiple='';
	}
	if(!isset($d['class'])) $d['class']='form-row-wide';
	echo '<'.$tag.' class="form-row '.WooAOI_class($d['class']).' wooaoi-row '.$req['class'].'">';
	echo WooAOI_tag($tag);
	if(isset($d['label']) && $d['label']!="") {
		echo '<label for="'.$d['name'].'">'.$d['label'].$req['astr'].'</label>'; 
	}
	echo WooAOI_tag($tag,1);
	WooAOI_descr($d['descr']);
	
	$options=explode('|',esc_attr($d['options']));
	
	preg_match("/\[([^\]]+)\]/", $options[0], $selection); 
	
	echo '<select name="'.$d['name'].'[]" id="'.$d['name'].'" '.$req['class'].' '.$multiple.'>';
	
	if(isset($selection) && $selection[1]!="") { echo '<option value="">'.$selection[1].'</option>'; array_shift($options); }
	foreach ($options as $option) {
		echo '<option value="'.$option.'" '.selected(in_array($option,$value),1,0).'>'.$option.'</option>';
	}
	echo '</select>';
	
	WooAOI_show_error($aoi_error,$d['name']);
	
	WooAOI_descr($d['descr'],1);
	
	echo WooAOI_tag($tag,2).'</'.$tag.'>';
	WooAOI_clear($d['clear'],$tag);
}

/**
 * Radio buttons group
 * @since 0.1
 */
function WooAOI_radio($d,$order_id=false,$user_id=false,$output=false,$tag='p') {
	global $aoi_error;
	
	$req=WooAOI_req($d['req']);
	
	$value=WooAOI_get_fieldvalue($d['label'],$order_id,$user_id);
if(!isset($d['class'])) $d['class']='form-row-wide';
	echo '<'.$tag.' class="form-row '.WooAOI_class($d['class']).' wooaoi-row '.$req['class'].'">';
	echo WooAOI_tag($tag);
	if(isset($d['label']) && $d['label']!="") {
		echo '<label for="'.$d['name'].'">'.$d['label'].$req['astr'].'</label>'; 
	}
	echo WooAOI_tag($tag,1);
	WooAOI_descr($d['descr']);
	$options=explode('|',$d['options']);
	echo '<span class="wooaoi-radio-group">';
	$i=0;
	if(isset($options) && is_array($options)) {
	  foreach ($options as $option) {
		$option= esc_attr($option);
		echo '<span class="wooaoi-radio"><label style="display:inline;" for="'.$d['name'].'['.$i. ']"><input type="radio" class="input-radio" name="'.$d['name'].'" id="'.$d['name'].'['.$i. ']" '.$req['class'].' value="'.esc_attr($option).'" '.checked($value,$option,0).'>'.$option.' </label></span>';
		$i++;
	  }
	}
	
	echo '</span>';
	
	WooAOI_show_error($aoi_error,$d['name']);
	
	WooAOI_descr($d['descr'],1);
	echo WooAOI_tag($tag,2).'</'.$tag.'>';
	WooAOI_clear($d['clear'],$tag);
}

/**
 * Checkbox buttons group
 * @since 0.1
 */
function WooAOI_checkbox($d,$order_id=false,$user_id=false,$output=false,$tag='p') {
	global $aoi_error;
	
	$req=WooAOI_req($d['req']);
	
	$value=WooAOI_get_fieldvalue($d['label'],$order_id,$user_id);
	$value=explode('|',esc_attr($value));
	if(!isset($d['class'])) $d['class']='form-row-wide';
	echo '<'.$tag.' class="form-row '.WooAOI_class($d['class']).' wooaoi-row '.$req['class'].'">';
	echo WooAOI_tag($tag);
	if(isset($d['label']) && $d['label']!="") {
		echo '<label for="'.$d['name'].'">'.$d['label'].$req['astr'].'</label>'; 
	}
	echo WooAOI_tag($tag,1);
	WooAOI_descr($d['descr']);
	$options=explode('|',$d['options']);
	echo '<span class="wooaoi-checkbox-group">';
	
	if(isset($options) && is_array($options)) {
	  
	  // Disable required when more than one option, this is not possible with html5
	  if(count($options)>1) $req['class']='';
	  
	  $i=0;
	  foreach ($options as $option) {
		$option= esc_attr($option);
		echo '<span class="wooaoi-checkbox"><label class="checkbox" for="'.$d['name'].'['.$i. ']"><input type="checkbox" class="input-checkbox" name="'.$d['name'].'['.$i. ']" id="'.$d['name'].'['.$i. ']" '.$req['class'].' value="'.esc_attr($option).'" '.checked(in_array($option,$value),1,0).'>'.$option.'</label></span>';
		$i++;
	  }
	}
	
	echo '</span>';
	
	WooAOI_show_error($aoi_error,$d['name']);
	
	WooAOI_descr($d['descr'],1);
	echo '</'.WooAOI_tag($tag,1).'>
		</'.$tag.'>';
	WooAOI_clear($d['clear'],$tag);
}

/**
 * Submit button
 * @since 0.1
 */
function WooAOI_submit($d,$output=false,$tag='p') {
  if($output!='hidden' && $output!='checkout') {
	if(!isset($d['class'])) $d['class']='form-row-wide';
	echo '
	<'.$tag.' class="form-row '.WooAOI_class($d['class']).' wooaoi-row wooaoi-submit">';
		echo WooAOI_tag($tag,3).'
		<input type="submit" name="'.$d['name'].'" id="'.$d['name'].'" class="button button-primary" value="'.esc_attr($d['label']).'" >';
	if(isset($d['descr']) && $d['descr']!="") {	
	  echo '<span class=wooaoi-descr>
				'.$d['descr'].'
			</span>';
	}
	echo WooAOI_tag($tag,2);
	echo '</'.$tag.'>';
	WooAOI_clear($d['clear'],$tag);
  }
}


/**************************************************************************
 *                  Special
 **************************************************************************/

/** 
 * Datepicker
 * @since 0.1
 */
function WooAOI_datepicker($d,$order_id=false,$user_id=false,$output=false,$tag='p') {
	global $aoi_error;

	if(!wp_script_is('jquery-ui-datepicker', 'queue')){
	
		if(isset($d['options']) && $d['options']!="" && $d['options']!=" ") {
			$format=esc_attr($d['options']);
		} else {
			$format='dd-mm-yy';
		}
		wp_enqueue_script('jquery-ui-datepicker');
   		wp_enqueue_script( 'script_wooaoi-fe', PLUGIN_PATH.'assets/scripts-fe.php?f='.$format, array( 'jquery' ), '0.1' );
		wp_enqueue_style('jquery-style', PLUGIN_PATH.'assets/jquery-ui-1.10.3.custom.min.css');
	}

	$value=WooAOI_get_fieldvalue($d['label'],$order_id,$user_id);
	
	$req=WooAOI_req($d['req']);
	if(!isset($d['class'])) $d['class']='form-row-wide';
	if(!isset($d['placeholder'])) $d['placeholder']='';
	echo '
	<'.$tag.' class="form-row '.WooAOI_class($d['class']).' wooaoi-row '.$req['class'].'">';
	echo WooAOI_tag($tag);
	if(isset($d['label']) && $d['label']!="") {
		echo '<label for="'.$d['name'].'">'.$d['label'].$req['astr'].'</label>'; 
	}
	echo WooAOI_tag($tag,1);
	WooAOI_descr($d['descr']);
		echo '<input name="'.$d['name'].'" type="text" id="'.$d['name'].'" placeholder="'. esc_attr($d['placeholder']).'" class="wooaoi-date input-text medium-text" '.$req['class'].' value="';

	//displays value if exists
	if(isset($value) && $value!="") {
		echo $value;
	}
		
	echo '">';
	
	WooAOI_show_error($aoi_error,$d['name']);
	
	WooAOI_descr($d['descr'],1);
	echo WooAOI_tag($tag,2).'</'.$tag.'>';
	WooAOI_clear($d['clear'],$tag);
}

/** 
 * Colorpicker
 * @since 0.1
 */
function WooAOI_colorpicker($d,$order_id=false,$user_id=false,$output=false,$tag='p') {
	global $aoi_error;

	if(!wp_script_is('wp-color-picker', 'queue')){
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),   false,  1);
		wp_enqueue_script('wp-color-picker', admin_url( 'js/color-picker.min.js' ), array( 'iris' ), false, 1 );
		$colorpicker_l10n = array( 'clear' => __( 'Clear' ),'defaultString' => __( 'Default' ), 'pick' => __( 'Select Color' ) );
		wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', $colorpicker_l10n ); 
		wp_enqueue_script( 'script_wooaoi-c', PLUGIN_PATH.'assets/scripts-fe.php?c=1', array( 'jquery' ), '0.1' );
	}
	
	$req=WooAOI_req($d['req']);
	$value=WooAOI_get_fieldvalue($d['label'],$order_id,$user_id);
	if(!isset($d['class'])) $d['class']='form-row-wide';
	if(!isset($d['placeholder'])) $d['placeholder']='';
	echo '<'.$tag.' class="form-row '.WooAOI_class($d['class']).' wooaoi-row '.$req['class'].'">';
	echo WooAOI_tag($tag);
	if(isset($d['label']) && $d['label']!="") {
		echo '<label for="'.$d['name'].'">'.$d['label'].$req['astr'].'</label>'; 
	}
		
	echo WooAOI_tag($tag,1);
	WooAOI_descr($d['descr']);
	
	if(isset($d['options']) && $d['options']!="" && $d['options']!=" ") {$default=esc_attr($d['options']);} else {$default='#ffffff';}
	if($value=="") $value=$default;
	
	echo '<input name="'.$d['name'].'" type="text" id="'.$d['name'].'" class="wooaoi-color wp-color-picker placeholder="'. esc_attr($d['placeholder']).'" input-text medium-text" '.$req['class'].' data-default-color="'.$default.'" value="';

	//displays value if exists
	if(isset($value) && $value!="") {
		echo $value;
	}
		
	echo '">';
	
	WooAOI_show_error($aoi_error,$d['name'],$tag='p');
	
	WooAOI_descr($d['descr'],1);
	echo WooAOI_tag($tag,2).'</'.$tag.'>';
	WooAOI_clear($d['clear'],$tag);
}

/**
 * Password repeat field
 * @since 0.1
 */
function WooAOI_passwordR($d,$order_id=false,$user_id=false,$output=false,$tag='p') {
  global $aoi_error;
  if($output!='hidden') {
	$pass=__("Passwords don't match","woo-aoi");
	wp_enqueue_script( 'script_wooaoi-fe', PLUGIN_PATH.'assets/scripts-fe.php?p='.$pass, array( 'jquery' ), '0.1' );
	
	$req=WooAOI_req($d['req']);
	if(!isset($d['class'])) $d['class']='form-row-wide';
	if(!isset($d['placeholder'])) $d['placeholder']='';
	echo '
	<'.$tag.' class="form-row '.WooAOI_class($d['class']).' wooaoi-row '.$req['class'].'">';
	echo WooAOI_tag($tag);
	if(isset($d['label']) && $d['label']!="") {
		echo '<label for="'.$d['name'].'">'.$d['label'].$req['astr'].'</label>'; 
	}
	echo WooAOI_tag($tag,1);
	WooAOI_descr($d['descr']);
	echo '<input name="'.$d['name'].'" type="password" id="'.$d['name'].'" class="input-text regular-text" placeholder="'. esc_attr($d['placeholder']).'" '.$req['class'].' onfocus="validatePass(document.getElementById(\'p1\'), this);" oninput="validatePass(document.getElementById(\'p1\'), this);">';
	
	WooAOI_show_error($aoi_error,$d['name']);
	
	WooAOI_descr($d['descr'],1);
	echo WooAOI_tag($tag,2).'</'.$tag.'>';
	WooAOI_clear($d['clear'],$tag);
  }
}


/**
 * Numeric field for price adjust on product detail page
 * @since 0.1
 */
function WooAOI_price($d,$order_id=false,$user_id=false,$output=false,$tag='p') {
	
	global $aoi_error;
	
	$req=WooAOI_req($d['req']);
	
	$calc='*';
	if(isset($d['options']) && $d['options']!="") $calc=$d['options'];
	
	$value=0;
	$minus=$price_adjust='';

	$price=esc_attr($d['price_adjust']);
	
	if($price!=0) {
	
		if (strpos($price, '-') !== FALSE) {
			$price=str_replace('-','',$price);
			
			$minus='-';
		}
		$price=str_replace(',','.',$price);
		$price_adjust=__($calc,'woo-aoi').' '.$minus.woocommerce_price($price);
	}
	
	if(!isset($d['class'])) $d['class']='form-row-wide';
	if(!isset($d['placeholder'])) $d['placeholder']='';
	echo '<'.$tag.' class="form-row '.WooAOI_class($d['class']).' wooaoi-row '.$req['class'].'">';

	echo WooAOI_tag($tag);
	
	if(isset($d['label']) && $d['label']!="") {
		echo '<label for="'.$d['name'].'">'.$d['label'].$req['astr'].'</label>'; 
	}
	
	echo WooAOI_tag($tag,1);
	
	WooAOI_descr($d['descr']);
	echo '<input name="cost['.$d['name'].']" type="hidden" id="cost['.$d['name'].']" value="'.$price.'">';
	echo '<input name="'.$d['name'].'" type="number" id="'.$d['name'].'" min=0 style="width:100px;" class="input-text medium-text price-adjust"  placeholder="'. esc_attr($value).'" '.$req['class'].' value="';

	//displays value if exists
	if(isset($value) && $value!="") {
		echo $value;
	}
	
	echo '"> '.$price_adjust;
	
	WooAOI_show_error($aoi_error,$d['name']);
	
	WooAOI_descr($d['descr'],1);
	
	echo WooAOI_tag($tag,2).'</'.$tag.'>';
	WooAOI_clear($d['clear'],$tag);
}


/**************************************************************************
 *                  Texts & Headings
 **************************************************************************/

 /**
 * Headings inside fieldset
 * @since 0.1
 */
function WooAOI_heading($d,$output=false,$tag='p') {
  if($output!='hidden') {
	$h=esc_attr($d['options']);
	echo '<'.$h.'>'.esc_attr($d['label']).'</'.$h.'>';
	WooAOI_clear($d['clear'],$tag);
  }
  
}

/**
 * Texts inside fieldset
 * @since 0.1
 */
function WooAOI_texts($d,$output=false,$tag='p') {
  if($output!='hidden') {
	if(isset($d['options'])) {
		$p=esc_attr($d['options']);
		if(!isset($d['class'])) $d['class']='form-row-wide';
			echo '<'.$p.' class="form-row '.WooAOI_class($d['class']).' wooaoi-row wooaoi-texts">'.nl2br(esc_attr($d['textarea'])).'</'.$p.'>';
			WooAOI_clear($d['clear'],$tag);
	}
  }
}

/**************************************************************************
 *                  Actions (hidden fields)
 **************************************************************************/

/**
 * Redirects 
 * handling redirects after succesfull submit
 * @since 0.1
 */
function WooAOI_redirect($d,$output=false,$tag='p') {
  if($output!='hidden' && $output!='checkout') {
	echo '<input name="redirect" type="hidden" id="redirect" value="'.esc_attr($d['options']).'">';
  }
}

/**
 * Order status change 
 * Change order status or this order after succesfull submit
 * @since 0.1
 */
function WooAOI_status($d,$output=false,$tag='p') {
  if($output!='hidden' && $output!='checkout') {
	echo '<input name="status" type="hidden" id="status" value="'.esc_attr($d['options']).'">';
  }
}


/**************************************************************************
 *                  Helpers
 **************************************************************************/

/** 
 * Get field value
 * @since 0.1
 */
function WooAOI_get_fieldvalue($key,$order_id=0,$user_id=0) {
	if($order_id!=0) {
		return esc_attr(get_post_meta($order_id,$key,true));
	} elseif ($user_id!=0) {
		return esc_attr(get_user_meta($user_id,$key,true));
	}
	return false;
}

/**
 * Show field description
 * @since 0.2
 */
function WooAOI_descr($descr,$pos=''){
	if(isset($descr) && $descr!="") {
	  if(WooAOI_get_opt(array('descr','pos'))==$pos) {
		echo ' <span class="description wooaoi-descr">'.$descr.'</span>';
	  }
	}
}

/** 
 * Show error if errors exists
 * @since 0.2
 */
function WooAOI_show_error($aoi_error,$name) { //$d['name']
	if(isset($aoi_error) && is_wp_error($aoi_error) && $aoi_error->get_error_message($name)) {
		echo '<span class=wooaoi-error>'.$aoi_error->get_error_message($name).'</span>';
	}
}

/** 
 * Show asterisk if field is required
 * @since 0.2
 */
function WooAOI_req($required) {
	$req['class']=$req['astr']='';
	if(isset($required) && $required==true) {
		$req['class']='required';
		$req['astr']=' <span>*</span>';
	}
	return $req;
}

/**
 * Outputs correct display tag
 * @since 0.3
 */
function WooAOI_tag($tag,$type=0) {
	if($tag=='tr') { 
		if($type==0) return '<th>';
		elseif($type==1) return '</th><td>';
		elseif($type==2) return '</td>';
		elseif($type==2) return '<td colspan=2>';
	} else { 
		return false; 
	}
}

/**
 * Outputs classes
 * @since 0.3
 */
function WooAOI_class($class) {
	if(is_array($class)) $class=implode(' ',$class);
	return $class;
}

/**
 * Clear row after 
 * @since 0.3
 */
function WooAOI_clear($clear,$tag) {
	if(isset($clear) && $clear==true && $tag=='p') {
		echo '<div class=clear></div>';
	}
	return false;
}