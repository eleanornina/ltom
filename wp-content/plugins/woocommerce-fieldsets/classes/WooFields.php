<?php
class WooFields {

	var $basefields=array('WooFieldsStandard','WooFieldsSpecial','WooFieldsTexts','WooFieldsActions');
	var $defaults=array('name'=>true,'label'=>true,'options'=>true,'placeholder'=>true,'descr'=>true,'class'=>true,'price_adjust'=>false,'req'=>true,'clear'=>true,'multiple'=>false,'textarea'=>false);

	function __construct() {
        //$this->get_fields();
    }

	static function multi_in_array($needle, $fields) {
		foreach ($fields as $field) {
			foreach ($field['fields'] as $key => $values)	{
				if($key==$needle) {
					$output[$key]=$values;
				}
			}
		}
		return $output;
	}

	function get_fields() {
		global $field_group;

		$extensions=$this->basefields;

		foreach ($extensions as $extension) {

            //$extension::set_fields();
            call_user_func(array($extension, "set_fields"));

		}

		if(in_array('WooFieldsCheckout',$extensions)) {

			unset($field_group[0]['fields']['radio']);
			unset($field_group[0]['fields']['multi-select']);
			unset($field_group[0]['fields']['checkbox']);
			unset($field_group[0]['fields']['submit']);
		}

		return $field_group;
    }

	function get_checkout_fields() {
		$this->basefields[]='WooFieldsCheckout';

		if(($key = array_search('WooFieldsSpecial', $this->basefields)) !== false) {
			unset($this->basefields[$key]);
		}

		if(($key = array_search('WooFieldsTexts', $this->basefields)) !== false) {
			unset($this->basefields[$key]);
		}
	}

	function remove_fields($setname) {
		$this->basefields=array_diff($this->basefields,array($setname));
	}

	function get_options($input,$id,$values=array(),$checkout=0) {
		$fields=$this->get_fields();

		$output=$this->multi_in_array($input,$fields);

		$args=$this->defaults;

		if($checkout!=0) {
			$args['name']=array('readonly');
			$args['price']=false;
		}

		$args = array_intersect_key($output[$input]['args']+$args , $args);

		$return='<span class=wooaoi-view-options>+ View settings</span><div class=wooaoi-options style="display:none"><span class=wooaoi-hide-options>- Hide settings</span>';

			foreach ($args as $key => $value) {
				$readonly=0;
				$input='';
				if($value) {
					if(!empty($values[$key])) $input=$values[$key];

					if(is_array($value) && isset($value[0])) {
						if($value[0]=='readonly') $readonly=1;
					}

					$return.=$this->create_option($key,$value,$id,$input,$readonly);
				}
			}

		$return.='</div>';

		return $return;

	}

	function create_option($key,$options,$id,$value,$readonly=0) {
		switch ($key) {
			case 'name':
				if($readonly==1) $readonly='readonly';
				return '<p class="w50"><label for=aoi_field['.$id.']['.$key.']>'.__('Field name','woo-aoi').'</label><input '.$readonly.' type="text" id=aoi_field['.$id.']['.$key.'] maxlength="50" name="aoi_field['.$id.']['.$key.']" class="aoiset-name" value="'.esc_attr($value).'"></p>';
				break;
			case 'placeholder':
				return '<p class="w50"><label for=aoi_field['.$id.']['.$key.']>'.__('Placeholder','woo-aoi').'</label><input type="text" id=aoi_field['.$id.']['.$key.'] name="aoi_field['.$id.']['.$key.']" class="aoiset-args" value="'.esc_attr($value).'"></p>';
				break;
			case 'options':
				if(is_array($options)) {
					$return= '<p class="w50"><label for=aoi_field['.$id.']['.$key.']>'.__('Options','woo-aoi').'</label>';

					$return.='<select id=aoi_field['.$id.']['.$key.'] name="aoi_field['.$id.']['.$key.']" class="aoiset-args" >';
					foreach ($options as $slug=>$option) {
						$return.='<option '.selected($slug,$value,false).' value='.$slug.'>'.$option.'</option>';
					}
					$return.='</select></p>';
					return $return;

				} else {
					return '<p class="w50"><label for=aoi_field['.$id.']['.$key.']>'.__('Options','woo-aoi').'</label><input type="text" id=aoi_field['.$id.']['.$key.'] name="aoi_field['.$id.']['.$key.']" class="aoiset-args" value="'.esc_attr($value).'"></p>';
				}
				break;
			case 'req':
				return '<p class="w25"><label for=aoi_field['.$id.']['.$key.']><input type="checkbox" id=aoi_field['.$id.']['.$key.'] value="1" name="aoi_field['.$id.']['.$key.']" class="aoiset-req" '.checked( esc_attr($value), true, false ).'> '.__('Required field','woo-aoi').'</label></p>';
				break;
			case 'descr':
				return '<p class="w50"><label for=aoi_field['.$id.']['.$key.']>'.__('Description','woo-aoi').'</label><input type="text" id=aoi_field['.$id.']['.$key.'] name="aoi_field['.$id.']['.$key.']" class="aoiset-descr" value="'.esc_attr($value).'"></p>';
				break;
			case 'price_adjust':
				return '<p class="w50"><label for=aoi_field['.$id.']['.$key.']>'.__('Price','woo-aoi').'</label><input type="text" id=aoi_field['.$id.']['.$key.'] maxlength="50" name="aoi_field['.$id.']['.$key.']" class="small-text aoiset-price" value="'.esc_attr($value).'"></p>';
				break;
			case 'clear':
				return '<p class="w25"><label for=aoi_field['.$id.']['.$key.']><input type="checkbox" value="1" id=aoi_field['.$id.']['.$key.'] name="aoi_field['.$id.']['.$key.']" class="aoiset-clear" '.checked(esc_attr($value),true,0).'> '.__('Clear row','woo-aoi').'</label></p>';
				break;
			case 'class':
				if(!is_array($value)) $value=array();
				$return='<p class="w50"><label for=aoi_field['.$id.']['.$key.']>'.__('Position','woo-aoi').'</label><select name="aoi_field['.$id.']['.$key.'][]" id="aoi_field['.$id.']['.$key.']" class="aoiset-class"><option '.selected(in_array('form-row-wide',$value),1,false).' value="form-row-wide">'.__('Full width','woo-aoi').'</option><option '.selected(in_array('form-row-first',$value),1,false).' value="form-row-first">'.__('Left','woo-aoi').'</option><option '.selected(in_array('form-row-last',$value),1,false).' value="form-row-last">'.__('Right','woo-aoi').'</option></select>';

				if(is_array($value) && in_array('address-field',$value)) { $return.= '<input type=hidden name="aoi_field['.$id.'][class][]" value="address-field">'; }
				if(is_array($value) && in_array('update_totals_on_change',$value)) { $return.= '<input type=hidden name="aoi_field['.$id.'][class][]" value="update_totals_on_change">'; }
				$return.='</p>';

				return $return;
				break;
			case 'multiple':
				return '<p class="w25"><label for=aoi_field['.$id.']['.$key.']><input type="checkbox" id=aoi_field['.$id.']['.$key.'] value="1" name="aoi_field['.$id.']['.$key.']" class="aoiset-multiple" '.checked(esc_attr($value),true,0).'> '.__('Multiple select','woo-aoi').'</label></p>';
				break;
			case 'textarea':
				return '<p class="w100"><label for=aoi_field['.$id.']['.$key.']>'.__('Text','woo-aoi').'</label><textarea id=aoi_field['.$id.']['.$key.'] name="aoi_field['.$id.']['.$key.']" class="aoiset-textarea">'.esc_attr($value).'</textarea></p>';
				break;
		}
	}

}


class WooFieldsStandard extends WooFields {

	public function set_fields() {
		global $field_group;

		$args=array(
			'options'=>false,
		);

		$field['text']=array('type'=>'text','name'=>__('Text','woo-aoi'),'args'=>$args);
		$field['textarea']=array('type'=>'textarea','name'=>__('Textarea','woo-aoi'),'args'=>$args);
		$field['password']=array('type'=>'password','name'=>__('Password','woo-aoi'),'args'=>$args);

		$args=array(
			'placeholder'=>false,
		);
		$field['select']=array('type'=>'select','name'=>__('Select','woo-aoi'),'args'=>$args);
		$field['radio']=array('type'=>'radio','name'=>__('Radio buttons','woo-aoi'),'args'=>$args);
		$field['checkbox']=array('type'=>'checkbox','name'=>__('Checkbox','woo-aoi'),'args'=>$args);

		$args[]=array('multiple'=>true);
		$field['multi-select']=array('type'=>'select','name'=>__('Multi-Select','woo-aoi'),'args'=>$args);

		$args=array(
			'placeholder'=>false,
			'options'=>false,
			'price_adjust'=>false,
			'req'=>false
		);
		$field['submit']=array('type'=>'submit','name'=>__('Submit button','woo-aoi'),'args'=>$args);

		$field_group[]=array('name'=>__('Basic Form Fields','woo-aoi'),'fields'=>$field);

		return $field_group;
	}

}


class WooFieldsSpecial extends WooFields {

	public function set_fields() {
		global $field_group;

		$args=array(
			'options'=>false,
		);
		$field['password-repeat']=array('type'=>'password','name'=>__('Password repeat','woo-aoi'),'args'=>$args);
		$field['email']=array('type'=>'email','name'=>__('E-mail address','woo-aoi'),'args'=>$args);


		$args=array();
		$field['date']=array('type'=>'date','name'=>__('Date picker','woo-aoi'),'args'=>$args);
		$field['color']=array('type'=>'text','name'=>__('Color picker','woo-aoi'),'args'=>$args);
		$args['options']=array('*'=>__('*','woo-aoi'),'/'=>__('/','woo-aoi'),'+'=>__('+','woo-aoi'),'-'=>__('-','woo-aoi'));
		$args['price_adjust']=true;
		$field['price']=array('type'=>'text','name'=>__('Price adjust','woo-aoi'),'args'=>$args);

		$field_group[]=array('name'=>__('Special Fields','woo-aoi'),'fields'=>$field);

		return $field_group;
	}

}

class WooFieldsTexts extends WooFields {

	public function set_fields() {
		global $field_group;

		$args=array(
			'name'=>false,
			'placeholder'=>false,
			'req'=>false,
			'descr'=>false,
			'price_adjust'=>false,
			'class'=>false,
			'options'=>array('h1'=>__('H1','woo-aoi'),'h2'=>__('H2','woo-aoi'),'h3'=>__('H3','woo-aoi'),'h4'=>__('H4','woo-aoi'),'h5'=>__('H5','woo-aoi'),'h6'=>__('H6','woo-aoi')),
		);
		$field['heading']=array('type'=>'heading','name'=>__('Heading','woo-aoi'),'args'=>$args);

		$args['label']=false;
		$args['textarea']=true;
		$args['class']=true;
		$args['options']=array('p'=>__('Paragraph','woo-aoi'),'div'=>__('DIV','woo-aoi'),'address'=>__('Address','woo-aoi'),'q'=>__('Quote','woo-aoi'),'code'=>__('Code','woo-aoi'),'pre'=>__('Predefined','woo-aoi'),'small'=>__('Small','woo-aoi'));

		$field['texts']=array('type'=>'texts','name'=>__('Text','woo-aoi'),'args'=>$args);

		$field_group[]=array('name'=>__('Texts','woo-aoi'),'fields'=>$field);

		return $field_group;
	}

}

class WooFieldsActions extends WooFields {

	public function set_fields() {
		global $field_group;

        // WC 2.2 support
        if (function_exists('wc_get_order_statuses')) {

            $statuses = wc_get_order_statuses();
            ksort($statuses);

            foreach( $statuses as $status => $status_name ) {

      		    $status = str_replace('wc-', '', $status);
    		    $set_status[$status]=__($status_name,"woocommerce");
    		}

        } else {

    		$statuses = get_terms("shop_order_status", array("hide_empty" => false ) );
    		foreach( $statuses as $status ) {
    		    $set_status[$status->slug]=__($status->name,"woocommerce");
    		}

        }

		$args=array(
			'label'=>false,
			'placeholder'=>false,
			'req'=>false,
			'descr'=>false,
			'class'=>false,
			'clear'=>false,
			'price_adjust'=>false,
			'options'=>true
		);
		$field['redirect']=array('type'=>'hidden','name'=>__('Redirect URL','woo-aoi'),'args'=>$args);

		$args['options']=$set_status;
		$field['status']=array('type'=>'hidden','name'=>__('Change order status','woo-aoi'),'args'=>$args);

		$field_group[]=array('name'=>__('Actions','woo-aoi'),'fields'=>$field);

		return $field_group;
	}

}

class WooFieldsCheckout extends WooFields {

	public function set_fields() {
		global $field_group;

		$args=array(
			'placeholder'=>false,
			'descr'=>false,
			'price_adjust'=>false,
			'options'=>false
		);
		$field['state']=array('type'=>'select','name'=>__('State','woo-aoi'),'args'=>$args);
		$field['country']=array('type'=>'select','name'=>__('Country','woo-aoi'),'args'=>$args);

		$field_group[]=array('name'=>__('Special Checkout fields','woo-aoi'),'fields'=>$field);

		return $field_group;
	}

}
?>