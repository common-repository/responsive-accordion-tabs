<?php
namespace Responsive_Accordion_Tabs\Assets;

if ( ! defined( 'ABSPATH' ) ) { 
	exit; // Exit if accessed directly
}
	
class Load {

	public function __construct() {
		add_action('wp_head', array( $this, 'add_frontend_styles' ) );
		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'add_admin_scripts' ) );
		}
		
		add_action( 'wp_footer', array( $this, 'add_frontend_scripts' ) );
	}
	
	public function add_admin_scripts() {
		
		wp_register_style('responsive-accordion-tabs-admin-ui-css',
			plugins_url( "/assets/css/jquery-ui.css", RATABS_PLUGIN_FILE ),
			false,
			RESPONSIVE_ACCORDION_TABS_PLUGIN_VERSION,
			false
		);
		wp_enqueue_style( 'responsive-accordion-tabs-admin-ui-css' );
						
		wp_register_style( 
			'responsive-accordion-tabs-admin-styles', 
			plugins_url( "/assets/css/styles-admin.css", RATABS_PLUGIN_FILE ), 
			false, 
			RESPONSIVE_ACCORDION_TABS_PLUGIN_VERSION 
		);
		wp_enqueue_style( 'responsive-accordion-tabs-admin-styles' );
		
		wp_enqueue_style( 'dashicons' );
		
		wp_register_script( 
			'responsive-accordion-tabs-admin-scripts', 
			plugins_url( "/assets/js/media-uploader.js", RATABS_PLUGIN_FILE ), 
			array( 'jquery' ), 
			RESPONSIVE_ACCORDION_TABS_PLUGIN_VERSION, 
			true 
		);
		wp_enqueue_script( 'responsive-accordion-tabs-admin-scripts' );
		
		wp_enqueue_style( 'wp-color-picker' );
		
		wp_register_script( 
			'wp-color-picker-alpha', 
			plugins_url( "/assets/js/alpha-colour-picker.js", RATABS_PLUGIN_FILE ), 
			array( 'wp-color-picker' ), 
			'3.0.2', 
			true 
		);
		wp_enqueue_script( 'wp-color-picker-alpha' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		
		wp_register_script( 
			'responsive-accordion-tabs-admin-metabox-scripts', 
			plugins_url( "/assets/js/metabox.js", RATABS_PLUGIN_FILE ), 
			array( 'jquery', 'responsive-accordion-tabs-admin-scripts', 'wp-color-picker-alpha' ), 
			RESPONSIVE_ACCORDION_TABS_PLUGIN_VERSION, 
			true 
		);
		wp_enqueue_script( 'responsive-accordion-tabs-admin-metabox-scripts' );
		
	}
	
	public function add_frontend_scripts() {
		wp_register_script( 
			'responsive-accordion-tabs-scripts', 
			plugins_url( "/assets/js/a11y-accordion-tabs.js", RATABS_PLUGIN_FILE ), 
			false, 
			RESPONSIVE_ACCORDION_TABS_PLUGIN_VERSION, 
			true 
		);
		wp_enqueue_script( 'responsive-accordion-tabs-scripts' );
	
	}
	
	public function add_frontend_styles() {
		wp_register_style( 
			'responsive-accordion-tabs-font-styles', 
			plugins_url( "/assets/css/light.min.css", RATABS_PLUGIN_FILE ), 
			false, 
			RESPONSIVE_ACCORDION_TABS_PLUGIN_VERSION 
		);
		wp_enqueue_style( 'responsive-accordion-tabs-font-styles' );
		
		wp_register_style( 
			'responsive-accordion-tabs-styles', 
			plugins_url( "/includes/blocks/build/style-index.css", RATABS_PLUGIN_FILE ), 
			false, 
			RESPONSIVE_ACCORDION_TABS_PLUGIN_VERSION 
		);
		wp_enqueue_style( 'responsive-accordion-tabs-styles' );
		
		wp_register_style( 
			'responsive-accordion-tabs-custom-styles', 
			plugins_url( "/assets/css/custom-styles.css", RATABS_PLUGIN_FILE ), 
			false, 
			RESPONSIVE_ACCORDION_TABS_PLUGIN_VERSION 
		);
	}
	
}