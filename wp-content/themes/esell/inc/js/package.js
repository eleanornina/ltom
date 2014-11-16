jQuery(document).ready(function () {
	jQuery('li.product').hide();
	jQuery('.letter').hide();
    jQuery('.characters').hide();
	jQuery('div.trinkets').hide();
	jQuery('div.stationary').hide();
    
    jQuery('.show-characters').click(function() {
		jQuery('li.product').hide();
	    jQuery('div.trinkets').fadeOut();
		jQuery('div.stationary').fadeOut();
	    jQuery('.letter').fadeOut();
	    jQuery('.characters').fadeIn();
	    jQuery('.remove-santa').hide();
	    jQuery('.remove-ccfairy').hide();
	    jQuery('li.product-cat-stationary a.promaxmore').hide();
	    jQuery('li.product-cat-stationary a.button').hide();

    	jQuery('div.characters a.santa').click(function() {
    		jQuery('.remove-santa').show();

    		jQuery('.show-stationary').click(function() {
			    jQuery('div.trinkets').fadeOut();
				jQuery('div.stationary').fadeIn();
			    jQuery('.characters').fadeOut();
			    jQuery('.letter').fadeOut();
			    jQuery('li.product-cat-trinkets').hide();
			    jQuery('li.product-cat-santa-stationary').show().removeClass('first').appendTo(jQuery(".stationary ul"));
			    jQuery('li.product-cat-ccfairy-stationary').hide();
			    jQuery('li.product-cat-stationary a.button').hide();
			    jQuery('li.product-cat-stationary a.promaxmore').hide();
    		})
    	})

    	jQuery('div.characters a.ccfairy').click(function() {
    		jQuery('.remove-ccfairy').show();

    		jQuery('.show-stationary').click(function() {
			    jQuery('div.trinkets').fadeOut();
				jQuery('div.stationary').fadeIn();
			    jQuery('.characters').fadeOut();
			    jQuery('.letter').fadeOut();
			    jQuery('li.product-cat-trinkets').hide();
			    jQuery('li.product-cat-santa-stationary').hide();
			    jQuery('li.product-cat-ccfairy-stationary').show().removeClass('first').appendTo(jQuery(".stationary ul"));
			    jQuery('li.product-cat-stationary a.button').hide();
			    jQuery('li.product-cat-stationary a.promaxmore').hide();
    		})
    	})
	    	

	    jQuery('div.characters a.add_to_cart_button').click(function() {
	    	var charChoice = jQuery(this).text();
	    	jQuery('p.char').html(charChoice + " was added to the package! Go on to Step 2.");
	    	jQuery('a.added_to_cart.wc-forward').hide();
	    })
    })

  //   jQuery('.show-letter').click(function() {
		// jQuery('li.product').hide();
	 //    jQuery('li.trinkets').fadeOut();
		// jQuery('div.stationary').fadeOut();
	 //    jQuery('.characters').fadeOut();
	 //    jQuery('.letter').fadeIn();
  //   })
    
    jQuery('.show-stationary').click(function() {
	    jQuery('div.trinkets').fadeOut();
		jQuery('div.stationary').fadeIn();
	    jQuery('.characters').fadeOut();
	    jQuery('.letter').fadeOut();
	    jQuery('li.product-cat-trinkets').hide();
	    jQuery('li.product-cat-stationary a.button').hide();
	    jQuery('li.product-cat-stationary a.promaxmore').hide();
    })
                  
    jQuery('.show-trinkets').click(function() {
	    jQuery('div.trinkets').fadeIn();
		jQuery('div.stationary').fadeOut();
	    jQuery('.characters').fadeOut();
	    jQuery('.letter').fadeOut();
	    jQuery('li.product-cat-stationary').hide();
	    jQuery('li.product-cat-trinkets').show().removeClass('first').appendTo(jQuery(".trinkets ul"));
	    jQuery('li.product-cat-trinkets a.promaxmore').hide();
	    jQuery('li.product-cat-trinkets a.button').hide();
    })

    var addTrinket = jQuery('<a href="http://www.eleanornina.com/littletouchofmagic/create-package/" class="addTrinket button">Add a Trinket to Your Order</a>');
    jQuery(addTrinket).insertAfter('div.product_meta');
});