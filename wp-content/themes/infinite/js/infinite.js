jQuery(window).load(function(){

	$ = jQuery;

	var mob = false;

	eventsForTransitions('fromTop');
	eventsForTransitions('fromBottom');
	eventsForTransitions('fromLeft');
	eventsForTransitions('fromRight');
	eventsForTransitions('fadeIn');
	eventsForTransitions('scaleUp', jQuery('.avatar img'));

})

jQuery(function(){

	var $container = jQuery('#full-grid');

	$container.imagesLoaded( function() {
		$container.masonry();
	});


	jQuery(".textwidget, iframe, .video:not(.no-fitvids)").fitVids();


	jQuery('#related-posts').flexslider({
		animation: 'slide',
		itemWidth: 210,
		itemMargin: 5,
		minItems: 1,
		maxItems: 5
	});

	jQuery('.flexslider:not(.ignore)').flexslider({
		animation: "fade",
		smoothHeight: true,
		selector: ".slides > li",
		start: function(slider){}
	});

	jQuery('a.gallery').colorbox({rel:'gallery', maxWidth: '95%'});


	var $grid = jQuery('#portfolio-grid-container'),
	$sizer = $grid.find('.portfolio-grid-alt-item');

	$grid.shuffle({
		itemSelector: '.portfolio-grid-alt-item',
		sizer: $sizer
	});


	jQuery('#portfolio_filter a').click(function(){
		jQuery('#portfolio_filter a').removeClass('active');
		var selector = jQuery(this).addClass('active').attr('data-filter');
	  // Filters elements with a data-title attribute with less than 10 characters
	  $('#portfolio-grid-container').shuffle('shuffle', function($el, shuffle) {
	  	return $el.hasClass(selector);
	  });

	  return false;
	});




	jQuery(window).scroll(function () {
		if (jQuery(this).scrollTop() > 100) {
			jQuery('#back-to-top').fadeIn();

			if(jQuery('.fixed-header .main-header').length > 0){
				jQuery('.main-header').addClass('scrolled');
			}

		} else {
			jQuery('#back-to-top').fadeOut();

			if(jQuery('.fixed-header .main-header').length > 0){
				jQuery('.main-header').removeClass('scrolled');
			}

		}
	});


	jQuery('#back-to-top a').click(function () {
		jQuery('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});

	jQuery( '#dl-menu' ).dlmenu({
		animationClasses : { classin : 'dl-animate-in-4', classout : 'dl-animate-out-4' }
	});

	jQuery(window).resize(function() {
		setHeaderPosition();
	});

	setHeaderPosition();

	if ( !("placeholder" in document.createElement("input")) ) {
		jQuery("input[placeholder], textarea[placeholder]").each(function() {
			var val = jQuery(this).attr("placeholder");
			if ( this.value == "" ) {
				this.value = val;
			}
			jQuery(this).focus(function() {
				if ( this.value == val ) {
					this.value = "";
				}
			}).blur(function() {
				if ( jQuery.trim(this.value) == "" ) {
					this.value = val;
				}
			})
		});

	    // Clear default placeholder values on form submit
	    jQuery('form').submit(function() {
	    	jQuery(this).find("input[placeholder], textarea[placeholder]").each(function() {
	    		if ( this.value == jQuery(this).attr("placeholder") ) {
	    			this.value = "";
	    		}
	    	});
	    });
	}

	jQuery('#menu-item-search a').click(function(e){
		e.preventDefault();
		e.stopPropagation();
		var t = $(this);
		if(t.next().css('display') == 'block'){
			t.next().fadeOut(100);
			return;
		}
		t.next().fadeIn(400).find('input[name=s]').focus();
		$doc = $(document);
		$doc.bind("click", function(e){
			t.next().fadeOut(100);
			$doc.unbind("click");
		});
	})

	jQuery('#menu-item-search form').click(function(e){
		e.preventDefault();
		e.stopPropagation();
	});

	if(jQuery('.post-content').children(':last').find('.bg-section').length > 0) jQuery('.post-content').parent().css('padding', '1em 0 0');

})

function setHeaderPosition(){
	if(jQuery(window).width() <= 768){
		jQuery('.main-header').css('top', 'auto');
		jQuery('.fixed-header-fix').css('height', 'auto');
	}else{
		var hgt = jQuery('.main-header').removeAttr('style').height();
		jQuery('.fixed-header-fix').removeAttr('style').css('height',hgt);
	}
}

function isScrolledIntoView(elem)
{
	var docViewTop = jQuery(window).scrollTop();
	var docViewBottom = docViewTop + jQuery(window).height();

	var elemTop = elem.offset().top;
	var elemBottom = elemTop + elem.height();

	return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}


function eventsForTransitions(cls, objs){
	var allMods = jQuery(".csstransforms *[data-animate="+cls+"]"),
	win = jQuery(window);

	if(typeof objs != 'undefined')
		jQuery.merge(allMods, objs);

	allMods.each(function(i, el) {
		var el = jQuery(el);
	  //if (el.visible(true)) {
	  	if(isScrolledIntoView(el)){
	  		el.addClass("animated "+cls); 
	  	} 
	  });

	win.scroll(function(event) {

		allMods.each(function(i, el) {
			var el = jQuery(el);
			if (el.visible(true)) {
				el.addClass(cls);
			} 
		});

	});
}

(function($) {

  /**
   * Copyright 2012, Digital Fusion
   * Licensed under the MIT license.
   * http://teamdf.com/jquery-plugins/license/
   *
   * @author Sam Sehnert
   * @desc A small plugin that checks whether elements are within
   *     the user visible viewport of a web browser.
   *     only accounts for vertical position, not horizontal.
   */

   $.fn.visible = function(partial) {

   	var $t            = $(this),
   	$w            = $(window),
   	viewTop       = $w.scrollTop(),
   	viewBottom    = viewTop + $w.height(),
   	_top          = $t.offset().top,
   	_bottom       = _top + $t.height(),
   	compareTop    = partial === true ? _bottom : _top,
   	compareBottom = partial === true ? _top : _bottom;

   	return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

   };

})(jQuery);




/**
 * jquery.dlmenu.js v1.0.1
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */
 ;( function( $, window, undefined ) {

 	'use strict';

	// global
	var Modernizr = window.Modernizr, $body = $( 'body' );

	$.DLMenu = function( options, element ) {
		this.$el = $( element );
		this._init( options );
	};

	// the options
	$.DLMenu.defaults = {
		// classes for the animation effects
		animationClasses : { classin : 'dl-animate-in-1', classout : 'dl-animate-out-1' },
		// callback: click a link that has a sub menu
		// el is the link element (li); name is the level name
		onLevelClick : function( el, name ) { return false; },
		// callback: click a link that does not have a sub menu
		// el is the link element (li); ev is the event obj
		onLinkClick : function( el, ev ) { return false; }
	};

	$.DLMenu.prototype = {
		_init : function( options ) {

			// options
			this.options = $.extend( true, {}, $.DLMenu.defaults, options );
			// cache some elements and initialize some variables
			this._config();
			
			var animEndEventNames = {
				'WebkitAnimation' : 'webkitAnimationEnd',
				'OAnimation' : 'oAnimationEnd',
				'msAnimation' : 'MSAnimationEnd',
				'animation' : 'animationend'
			},
			transEndEventNames = {
				'WebkitTransition' : 'webkitTransitionEnd',
				'MozTransition' : 'transitionend',
				'OTransition' : 'oTransitionEnd',
				'msTransition' : 'MSTransitionEnd',
				'transition' : 'transitionend'
			};
			// animation end event name
			this.animEndEventName = animEndEventNames[ Modernizr.prefixed( 'animation' ) ] + '.dlmenu';
			// transition end event name
			this.transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ] + '.dlmenu',
			// support for css animations and css transitions
			this.supportAnimations = Modernizr.cssanimations,
			this.supportTransitions = Modernizr.csstransitions;

			this._initEvents();

		},
		_config : function() {
			this.open = false;
			this.$trigger = this.$el.children( '.dl-trigger' );
			this.$menu = this.$el.children( 'ul.dl-menu' );
			this.$menuitems = this.$menu.find( 'li:not(.dl-back)' );
			this.$el.find( 'ul.dl-submenu' ).prepend( '<li class="dl-back"><a href="#">back</a></li>' );
			this.$back = this.$menu.find( 'li.dl-back' );
		},
		_initEvents : function() {

			var self = this;

			this.$trigger.on( 'click.dlmenu', function() {
				
				if( self.open ) {
					self._closeMenu();
				} 
				else {
					self._openMenu();
				}
				return false;

			} );

			this.$menuitems.on( 'click.dlmenu', function( event ) {
				
				event.stopPropagation();

				var $item = $(this),
				$submenu = $item.children( 'ul.dl-submenu' );

				if( $submenu.length > 0 ) {

					var $flyin = $submenu.clone().css( 'opacity', 0 ).insertAfter( self.$menu ),
					onAnimationEndFn = function() {
						self.$menu.off( self.animEndEventName ).removeClass( self.options.animationClasses.classout ).addClass( 'dl-subview' );
						$item.addClass( 'dl-subviewopen' ).parents( '.dl-subviewopen:first' ).removeClass( 'dl-subviewopen' ).addClass( 'dl-subview' );
						$flyin.remove();
					};

					setTimeout( function() {
						$flyin.addClass( self.options.animationClasses.classin );
						self.$menu.addClass( self.options.animationClasses.classout );
						if( self.supportAnimations ) {
							self.$menu.on( self.animEndEventName, onAnimationEndFn );
						}
						else {
							onAnimationEndFn.call();
						}

						self.options.onLevelClick( $item, $item.children( 'a:first' ).text() );
					} );

					return false;

				}
				else {
					self.options.onLinkClick( $item, event );
				}

			} );

this.$back.on( 'click.dlmenu', function( event ) {

	var $this = $( this ),
	$submenu = $this.parents( 'ul.dl-submenu:first' ),
	$item = $submenu.parent(),

	$flyin = $submenu.clone().insertAfter( self.$menu );

	var onAnimationEndFn = function() {
		self.$menu.off( self.animEndEventName ).removeClass( self.options.animationClasses.classin );
		$flyin.remove();
	};

	setTimeout( function() {
		$flyin.addClass( self.options.animationClasses.classout );
		self.$menu.addClass( self.options.animationClasses.classin );
		if( self.supportAnimations ) {
			self.$menu.on( self.animEndEventName, onAnimationEndFn );
		}
		else {
			onAnimationEndFn.call();
		}

		$item.removeClass( 'dl-subviewopen' );

		var $subview = $this.parents( '.dl-subview:first' );
		if( $subview.is( 'li' ) ) {
			$subview.addClass( 'dl-subviewopen' );
		}
		$subview.removeClass( 'dl-subview' );
	} );

	return false;

} );

},
closeMenu : function() {
	if( this.open ) {
		this._closeMenu();
	}
},
_closeMenu : function() {
	var self = this,
	onTransitionEndFn = function() {
		self.$menu.off( self.transEndEventName );
		self._resetMenu();
	};

	this.$menu.removeClass( 'dl-menuopen' );
	this.$menu.addClass( 'dl-menu-toggle' );
	this.$trigger.removeClass( 'dl-active' );

	if( this.supportTransitions ) {
		this.$menu.on( this.transEndEventName, onTransitionEndFn );
	}
	else {
		onTransitionEndFn.call();
	}

	this.open = false;
},
openMenu : function() {
	if( !this.open ) {
		this._openMenu();
	}
},
_openMenu : function() {
	var self = this;
			// clicking somewhere else makes the menu close
			$body.off( 'click' ).on( 'click.dlmenu', function() {
				self._closeMenu() ;
			} );
			this.$menu.addClass( 'dl-menuopen dl-menu-toggle' ).on( this.transEndEventName, function() {
				$( this ).removeClass( 'dl-menu-toggle' );
			} );
			this.$trigger.addClass( 'dl-active' );
			this.open = true;
		},
		// resets the menu to its original state (first level of options)
		_resetMenu : function() {
			this.$menu.removeClass( 'dl-subview' );
			this.$menuitems.removeClass( 'dl-subview dl-subviewopen' );
		}
	};

	var logError = function( message ) {
		if ( window.console ) {
			window.console.error( message );
		}
	};

	$.fn.dlmenu = function( options ) {
		if ( typeof options === 'string' ) {
			var args = Array.prototype.slice.call( arguments, 1 );
			this.each(function() {
				var instance = $.data( this, 'dlmenu' );
				if ( !instance ) {
					logError( "cannot call methods on dlmenu prior to initialization; " +
						"attempted to call method '" + options + "'" );
					return;
				}
				if ( !$.isFunction( instance[options] ) || options.charAt(0) === "_" ) {
					logError( "no such method '" + options + "' for dlmenu instance" );
					return;
				}
				instance[ options ].apply( instance, args );
			});
		} 
		else {
			this.each(function() {	
				var instance = $.data( this, 'dlmenu' );
				if ( instance ) {
					instance._init();
				}
				else {
					instance = $.data( this, 'dlmenu', new $.DLMenu( options, this ) );
				}
			});
		}
		return this;
	};

} )( jQuery, window );