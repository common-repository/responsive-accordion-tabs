<?php
namespace Responsive_Accordion_Tabs\Blocks;

if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}
	
class Load {

	public function __construct() {
		add_action( 'init', array( $this, 'create_ratabs_block_init' ) );
	}
	
	function create_ratabs_block_init() {
		//register_block_type( __DIR__ . '/build' );
	}
	
}