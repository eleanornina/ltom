jQuery(document).ready(function(){	
	
	// Tabs on settings page
	var active_tab = window.location.hash.replace('#top#','');
	if ( active_tab == '' )
	active_tab = 'createfields';
	jQuery('#'+active_tab).addClass('active');
	jQuery('#'+active_tab+'-tab').addClass('nav-tab-active');
	
	jQuery('.nav-tab-wrapper a').click(function() {
		jQuery('.nav-tab-wrapper a').removeClass('nav-tab-active');
		jQuery('.tab').removeClass('active');
	
		var id = jQuery(this).attr('id').replace('-tab','');
		jQuery('#'+id).addClass('active');
		jQuery(this).addClass('nav-tab-active');
	});
	
	
	/**
	 * adding new fields
	 * Credits to the Advanced Custom Fields plugin for this code
	 */

	// Update Order Numbers
	function update_order_numbers(div) {
		div.children('tbody').children('tr.aoi-row').each(function(i) {
			jQuery(this).children('td.aoi-order').html(i+1);
		});
	}
	
	// Make Sortable
	function make_sortable(div){
		var fixHelper = function(e, ui) {
			ui.children().each(function() {
				jQuery(this).width(jQuery(this).width());
			});
			return ui;
		};

		div.children('tbody').unbind('sortable').sortable({
			update: function(event, ui){
				update_order_numbers(div);
			},
			handle: 'td.aoi-order',
			helper: fixHelper
		});
	}

	var div = jQuery('.aoi-table'),
		row_count = div.children('tbody').children('tr.aoi-row').length;

	// Make the table sortable
	make_sortable(div);
	
	// Add button
	jQuery('#aoi-add-btn').live('click', function(){

		var div = jQuery('.aoi-table'),
			row_count = div.children('tbody').children('tr.aoi-row').length,
			new_field = div.children('tbody').children('tr.aoi-clone').clone(false); // Create and add the new field

		new_field.attr( 'class', 'aoi-row' );

		// Update names
		new_field.find('[name]').each(function(){
			var count = parseInt(row_count);
			var name = jQuery(this).attr('name').replace('[999]','[' + count + ']');
			jQuery(this).attr('name', name);
		});

		// Add row
		div.children('tbody').append(new_field); 
		update_order_numbers(div);

		// There is now 1 more row
		row_count ++;

		return false;	
	});

	// Remove button
	jQuery('.aoi-table .aoi-remove-btn').live('click', function(){
		var div = jQuery('.aoi-table'),
			tr = jQuery(this).closest('tr');

		tr.animate({'left' : '50px', 'opacity' : 0}, 250, function(){
			tr.remove();
			update_order_numbers(div);
		});

		return false;
	});
	
	jQuery('.aoi-table .wooaoi-view-options').live('click', function(){
		var parent=jQuery(this).closest('td');
		jQuery(parent).find('div').toggle();
		jQuery(this).toggle();
	});
	
	jQuery('.aoi-table .wooaoi-hide-options').live('click', function(){
		var parent=jQuery(this).closest('td');
		jQuery(parent).find('div').toggle();
		jQuery(parent).find('.wooaoi-view-options').toggle();
	});
	
	jQuery('.aoi-table .aoiset-select').live('change',function() {
		var parent_row=jQuery(this).closest('tr');
		var type=jQuery(this).val();
		
		var old_type='no';
		var div = jQuery('.aoi-table'),
			row_count = div.children('tbody').children('tr.aoi-row').length;
		
		var id=jQuery(parent_row).find('.aoi-order').html()-1;
		
		var data = {
			action: 'my_action',
			type:type,
			id:id
		};
		
		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
		jQuery.post(ajax_object.ajax_url, data, function(response) {
		
			jQuery(parent_row).find('.ajax_overwrite').html(response);
			
		});
			
			
		/*	
		if(type=='heading') {
			
			var new_field = div.children('tbody').children('tr.aoi-replace-text').clone(false); // Create and add the new field

			new_field.attr( 'class', 'aoi-row' );

			// Update names
			new_field.find('[name]').each(function(){
				var count = parseInt(row_count);
				var name = jQuery(this).attr('name').replace('[999]','[' + count + ']');
				jQuery(this).attr('name', name);
			});

			// Replace row
			//div.children('tbody').append(new_field); 
			jQuery(parent_row).replaceWith(new_field);
			
			update_order_numbers(div);
			
			jQuery(new_field).find('.aoiset-select').val(type);
			
			
	
			// There is now 1 more row
			row_count ++;
			var old_type='jump';

		} else if(type=='texts') {
		
			new_field = div.children('tbody').children('tr.aoi-replace-textarea').clone(false); // Create and add the new field

			new_field.attr( 'class', 'aoi-row' );

			// Update names
			new_field.find('[name]').each(function(){
				var count = parseInt(row_count);
				var name = jQuery(this).attr('name').replace('[999]','[' + count + ']');
				jQuery(this).attr('name', name);
			});

			// Replace row
			//div.children('tbody').append(new_field); 
			jQuery(parent_row).replaceWith(new_field);
			
			update_order_numbers(div);
			
			jQuery(new_field).find('.aoiset-select').val(type);
			
			var old_type='jump';
	
			// There is now 1 more row
			row_count ++;

		} else if(type=='status') {
			
			var labelfield=jQuery(parent_row).find('.aoiset-label');
			var labelname=jQuery(labelfield).attr('name');
			
			new_field = jQuery('.aoiset-statusselect').clone(false);
			
			new_field.attr('name', labelname);
			new_field.show();
			jQuery(parent_row).find('.aoiset-args').hide();
			jQuery(parent_row).find('.aoiset-descr').hide();
			jQuery(parent_row).find('.aoiset-req').hide();
			jQuery(labelfield).replaceWith(new_field);
		
		}/*else if(old_type=='jump') {
			var div = jQuery('.aoi-table'),			
			row_count = div.children('tbody').children('tr.aoi-row').length,
			new_field = div.children('tbody').children('tr.aoi-clone').clone(false); // Create and add the new field

			new_field.attr( 'class', 'aoi-row' );

			// Update names
			new_field.find('[name]').each(function(){
				var count = parseInt(row_count);
				var name = jQuery(this).attr('name').replace('[999]','[' + count + ']');
				jQuery(this).attr('name', name);
			});

			// Replace row
			//div.children('tbody').append(new_field); 
			jQuery(parent_row).replaceWith(new_field);
			
			update_order_numbers(div);
			
			jQuery(new_field).find('.aoiset-select').val(type);
	
			// There is now 1 more row
			row_count ++;
		}*/
		
	});
	
});