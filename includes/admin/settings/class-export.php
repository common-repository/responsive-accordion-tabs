<?php

namespace  Responsive_Accordion_Tabs\Admin\Settings;

if ( ! defined( 'ABSPATH' ) ) { 
	exit; // Exit if accessed directly
}
	
class Export {
	
	public function __construct() {
		add_action( 'admin_init', array( $this, 'register_export_admin_settings' ) );
	}
	
	public function register_export_admin_settings() {
		//register our settings
		register_setting( 'ratabs_settings_export_group', 'ratabs_settings_export', array( $this, 'save_ratabs_export_settings' ) );
		add_settings_section( 'ratabs_settings_export_group_section', 'Export Styles and Settings', array( $this, 'ratabs_settings_export_text' ), 'ratabs-settings-export-group' );

	}
	
	public function ratabs_settings_export_text() {
		echo "<p>To take a backup of the styles and settings or to import into another setup, click the Export button below</p>";
	}
	
	public function ratabs_settings_export_empty() {
		echo "";
	}
	
	public function save_ratabs_export_settings($input) {
				
		if ( sanitize_text_field( $_POST['submit'] ) == 'Export Styles and Settings' ) {
			
			$defaults = get_option( 'ratabs_settings_defaults' );
			$styles = get_option( 'ratabs_settings_styles' );
			
			$output = array();
			$output['defaults'] = $defaults;
			$output['styles'] = $styles;
			
			// Handle request then generate response using echo or leaving PHP and using HTML
			$filename = "ratabs.txt";
			
			header('Content-Type:text/plain');
			header('Content-Disposition: attachment; filename="'.$filename.'";');
			
			$f = fopen('php://output', 'w');
			
			fwrite( $f, json_encode( $output ) );
			
			die();
		}
		
		return true;
		
	}
	
}