var RATABS = {
	
	construct: function() {
		
		this._init();
		
		this.setListeners();
		
		jQuery( '.ratabs-colour-picker' ).wpColorPicker();
	},
	
	_init: function() {
		
		this.sortableInit( jQuery( '.accordion-tab-metabox' ) );
		
		jQuery('.accordion-tab-row .accordion-tabs-delete-button').show();
		jQuery('.accordion-tab-row .dashicons-move').show();
		
		if ( jQuery( '.accordion-tab-row .accordion-tabs-delete-button' ).length == 1 ) {
			jQuery( '.accordion-tab-row .accordion-tabs-delete-button' ).hide();
		}
		if ( jQuery( '.accordion-tab-row .dashicons-move' ).length == 1 ) {
			jQuery( '.accordion-tab-row .dashicons-move' ).hide();
		}
		
		AccordionTabsMediaUploader.construct();
		
	},
	
	setListeners: function() {
		jQuery( 'body' ).on( 'click', '.accordion-tabs-delete-button', this.deleteButton );
		jQuery( 'body' ).on( 'click', '.accordion-tabs-add-button', this.addButton );
		jQuery( 'body' ).on( 'click', '.accordion-tabs-remove-image-button', this.removeImageButton );
	},
	
	sortableInit: function(container) {
		container.sortable({
			handle: jQuery('.accordion-tab-row .dashicons-move'),
			cursor: 'move',
			items: '.accordion-tab-row',
			placeholder: "accordion-tab-row-placeholder ui-corner-all",
			start: function( e, ui ) {
				jQuery( '#'+jQuery( 'textarea',ui.item )[0].id+'-tmce' ).click();
				tinyMCE.execCommand( 'mceRemoveEditor', false,  jQuery( 'textarea',ui.item )[0].id );
			},
			stop: function( e, ui ) {
				tinyMCE.execCommand( 'mceAddEditor', false,  jQuery( 'textarea',ui.item )[0].id );
			}
		});
	},
	
	deleteButton: function( e ) {
		var $this = jQuery(this);
		
		var dialog = jQuery( '<div></div>' )
			.appendTo( 'body')
			.html( '<div><h6>Are you sure you wish to delete this Accordion/ Tab?</h6></div>' )
			.dialog({
				modal: true,
				title: 'Confirm deletion',
				zIndex: 10000,
				autoOpen: true,
				width: 'auto',
				resizable: false,
				buttons: {
					Yes: function() {
						$this.closest( '.accordion-tab-row' ).remove();
						dialog.dialog( "close" );
						
						RATABS._init();
					},
					No: function() {
						dialog.dialog( "close" );
					}
				},
				close: function(event, ui) {
					dialog.remove();
				}
			});
		
		e.preventDefault();
	},
	
	addButton: function( e ) {
		e.preventDefault();
		e.stopPropagation();
		var $this = jQuery(this);
		
		var hidden = jQuery( '.accordion-tab-metabox .clone-row' ).clone();
		var hidden_html = jQuery( hidden ).html().replace( /clone_/g, '' );
		var $new_row = jQuery( '<div class="accordion-tab-row">'+hidden_html+'</div>' ).insertBefore( jQuery( '.accordion-tab-metabox .clone-row' ) );
		//update row class if applicable
		if ( $new_row.attr( 'class' ) != undefined ) {
			var $id = 'accordion-tabs-wp-editor-' + ( new Date().getTime() );
			jQuery.post(ajaxurl, { 
					action: "add_new_wp_editor",
					id: $id
				}, 
				function( response, status ) { 
					if ( status == "success" ) {
						var $global_settings =  tinyMCEPreInit.mceInit.content;
						jQuery( response ).insertBefore( '.accordion-tab-row .wp-editor' );
						
						quicktags( { id : $id } );
						
						tinymce.init( $global_settings ); 
						tinymce.execCommand( 'mceAddEditor', true, $id );
						
						jQuery( '.accordion-tab-row .wp-editor' ).remove();
						
					}
				}
			);
		}
		
		RATABS._init();
	},
	
	removeImageButton: function( e ) {
		var $this = jQuery(this),
			$wrapper = $this.closest( '.accordion-tab-field-wrapper' );
		
		$wrapper.find( '.accordion-tabs-image-display' ).attr( 'src', '' );
		$wrapper.find( '.accordion-tabs-image-url' ).val( '' );
		$this.closest( '.remove-image-wrap' ).removeClass( 'show' );
		
		e.preventDefault();
	}
	
}

RATABS.construct( jQuery );
