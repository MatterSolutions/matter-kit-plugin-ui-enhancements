//trigger on document ready
jQuery( document ).ready( function( $ ) {

	var mttr_lyt_val;

	function mttr_add_class_flexible_standard_content() {

		$( '.acf-field-mttr-flex-standard-content-column-options' ).each( function() {
		        
			mttr_lyt_val = $( this ).find( 'input:checked' ).val();

			$( this ).parent().attr( 'class', 'mttr-lyt-active  mttr-lyt-active--' + mttr_lyt_val );	    

	    });

	}


	function mttr_add_class_flexible_standard_content_click() {

		$( '.acf-field-mttr-flex-standard-content-column-options input' ).on( 'click', function() {

			mttr_add_class_flexible_standard_content();

		});

	}


	// Add the layout classes on page load
	mttr_add_class_flexible_standard_content();
	

	// Add the layout classes on CLICK
	mttr_add_class_flexible_standard_content_click();

	// Check to ensure ACF is defined
	if ( typeof( acf ) !== 'undefined' ) {

		// Add the layout classes when new FLEX lyts are added
		acf.add_action( 'append', function( $el ) {

			mttr_add_class_flexible_standard_content_click();
			
		});

	}

});