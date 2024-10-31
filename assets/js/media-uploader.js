var AccordionTabsMediaUploader = {
	construct:function(){
			// Run initButton when the media button is clicked.
		jQuery( '.accordion-tabs-plugin-media-button' ).each( function( index ) {
			  	AccordionTabsMediaUploader.initButton( jQuery( this ) );
		} );
	},
	initButton:function( _that ){
		_that.unbind("click");
		_that.click( function( e ) {
		// Instantiates the variable that holds the media library frame.
		var metaImageFrame;
	   	// Get the btn
			var btn = e.target;
	
			// Check if it's the upload button
			if ( !btn || !jQuery( btn ).attr( 'data-accordion-tabs-plugin-media-uploader-target' ) ) return;
	
			// Get the field target
			var field = jQuery( btn ).data( 'accordion-tabs-plugin-media-uploader-target' );
			var img_field = jQuery( btn ).data( 'accordion-tabs-plugin-media-uploader-img-target' );
	
			// Prevents the default action from occuring.
			e.preventDefault();
	
			// Sets up the media library frame
			metaImageFrame = wp.media.frames.metaImageFrame = wp.media({
				title: 'Select or Upload an Image',
				button: { text:  'Use this image' },
			});
	
			// Runs when an image is selected.
			metaImageFrame.on( 'select', function() {
	
				// Grabs the attachment selection and creates a JSON representation of the model.
				var media_attachment = metaImageFrame.state().get( 'selection' ).first().toJSON();
				// Sends the attachment URL to our custom image input field.
				jQuery( btn ).closest( ".accordion-tab-field-wrapper" ).find( field ).val( media_attachment.id );
				jQuery( btn ).closest( ".accordion-tab-field-wrapper" ).find( img_field ).attr( 'src', media_attachment.sizes.thumbnail.url );
				jQuery( btn ).closest( ".accordion-tab-field-wrapper" ).find( ".remove-image-wrap" ).addClass( "show" );
	
			} );
	
			// Opens the media library frame.
			metaImageFrame.open();
		} );
	}
};