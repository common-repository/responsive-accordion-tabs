<?php

namespace  Responsive_Accordion_Tabs\Admin\Settings;

if ( ! defined( 'ABSPATH' ) ) { 
	exit; // Exit if accessed directly
}
	
class Import {
	
	public function __construct() {
		add_action( 'admin_init', array( $this, 'register_import_admin_settings' ) );
	}
	
	public function register_import_admin_settings() {
		//register our settings
		register_setting( 'ratabs_settings_import_group', 'ratabs_settings_import', array( $this, 'save_ratabs_import_settings' ) );
		add_settings_section( 'ratabs_settings_import_group_section', 'Import Styles and Settings', array( $this, 'ratabs_settings_import_text' ), 'ratabs-settings-import-group' );
		
		add_settings_field( 'ratabs_settings_import_txt', 'Export Content:', array( $this, 'ratabs_settings_import_settings' ), 'ratabs-settings-import-group', 'ratabs_settings_import_group_section');

	}
	
	public function ratabs_settings_import_text() {
		echo "<p>To import the styles and settings from a backup or another setup, enter the contents of your export file here.</p>";
	}
	
	public function ratabs_settings_import_empty() {
		echo "";
	}
	
	public function ratabs_settings_import_settings() {
		
		echo "<textarea id='ratabs_settings_import' name='ratabs_settings_import[txt]'></textarea>";
	}
	
	public function save_ratabs_import_settings($input) {
		
		if ( !empty( $input["txt"] ) ) {
			
			$import = trim( $input["txt"] );
			$import = json_decode( $import, true );
			
			if ( is_array( $import ) ) {
				
				if ( isset( $import['defaults'] ) ) {
					
					update_option( 'ratabs_settings_defaults', $import['defaults'] );
					
				}
				
				if ( isset( $import['styles'] ) ) {
					
					update_option( 'ratabs_settings_styles', $import['styles'] );
					
				}
			}
			else {
				return false;
			}
	
			return true;
			   
		}
		
		return true;
		
	}
	
}