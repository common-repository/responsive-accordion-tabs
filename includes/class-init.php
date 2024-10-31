<?php
namespace Responsive_Accordion_Tabs;

if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}
	
class Init {

	public function __construct() {
		
		new \Responsive_Accordion_Tabs\Assets\Load;
		
		//FRONTEND
		new \Responsive_Accordion_Tabs\Frontend\Shortcodes;
		
		//BLOCKS
		new \Responsive_Accordion_Tabs\Blocks\Load;
		
		//ADMIN
		new \Responsive_Accordion_Tabs\Admin\Posts;
		new \Responsive_Accordion_Tabs\Admin\Settings;
		
		self::check_version_changes();
			
	}
	
	public static function check_version_changes() {
		$current_version = get_option( 'ratabs_version' );
		
		if ( !$current_version || version_compare( RESPONSIVE_ACCORDION_TABS_PLUGIN_VERSION, $current_version, '>' ) ) {
			do_action( 'ratabs_on_update' );
			
			update_option( 'ratabs_version', RESPONSIVE_ACCORDION_TABS_PLUGIN_VERSION );
		}
	}

}