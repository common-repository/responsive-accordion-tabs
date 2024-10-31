<?php

namespace  Responsive_Accordion_Tabs\Admin\Settings;

if ( ! defined( 'ABSPATH' ) ) { 
	exit; // Exit if accessed directly
}
	
class Styles {
	
	public function __construct() {
		
		register_activation_hook( RATABS_PLUGIN_FILE, array( $this, 'write_css' ) );
		
		add_action( 'ratabs_on_update', array( $this, 'write_css' ) );
		add_action( 'admin_init', array( $this, 'register_styles_admin_settings' ) );
	}
	
	public function register_styles_admin_settings() {
		//register our settings
		register_setting( 'ratabs_settings_styles_group', 'ratabs_settings_styles', array( $this, 'save_ratabs_styles_settings' ) );
		add_settings_section( 'ratabs_settings_styles_group_section', 'Custom Styles', array( $this, 'ratabs_settings_styles_text' ), 'ratabs-settings-styles-group' );
		
		add_settings_field( 'ratabs_settings_styles_tabs_wrapper', '<h3>Tab Wrapper</h3>', array( $this, 'ratabs_settings_styles_empty' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_wrapper_tb_colour', 'Top Border Colour:', array( $this, 'ratabs_settings_styles_tabs_wrapper_tb_colour' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_wrapper_tb_width', 'Top Border Width:', array( $this, 'ratabs_settings_styles_tabs_wrapper_tb_width' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_wrapper_tb_style', 'Top Border Style:', array( $this, 'ratabs_settings_styles_tabs_wrapper_tb_style' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		
		add_settings_field( 'ratabs_settings_styles_tabs_list', '<h3>Tabs / Accordions</h3>', array( $this, 'ratabs_settings_styles_empty' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_text_colour', 'Text Colour:', array( $this, 'ratabs_settings_styles_tabs_text_colour' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_text_hover_colour', 'Text Colour (Hover):', array( $this, 'ratabs_settings_styles_tabs_text_hover_colour' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_selected_text_colour', 'Text Colour (Seleted):', array( $this, 'ratabs_settings_styles_tabs_selected_text_colour' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_list_bg_colour', 'Background Colour:', array( $this, 'ratabs_settings_styles_tabs_list_bg_colour' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_list_bg_colour_hover', 'Background Colour (Hover):', array( $this, 'ratabs_settings_styles_tabs_list_bg_colour_hover' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_selected_bg_colour', 'Background Colour (Selected):', array( $this, 'ratabs_settings_styles_tabs_selected_bg_colour' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_list_bb_colour', 'Bottom Border Colour:', array( $this, 'ratabs_settings_styles_tabs_list_bb_colour' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_list_bb_width', 'Bottom Border Width:', array( $this, 'ratabs_settings_styles_tabs_list_bb_width' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_list_font_size', 'Font Size:', array( $this, 'ratabs_settings_styles_tabs_list_font_size' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_list_font_size_hover', 'Font Size (Hover):', array( $this, 'ratabs_settings_styles_tabs_list_font_size_hover' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_list_font_weight', 'Font Weight:', array( $this, 'ratabs_settings_styles_tabs_list_font_weight' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_list_font_weight_hover', 'Font Weight (Hover):', array( $this, 'ratabs_settings_styles_tabs_list_font_weight_hover' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_list_font_weight_selected', 'Font Weight (Selected):', array( $this, 'ratabs_settings_styles_tabs_list_font_weight_selected' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_list_font_weight_focus', 'Font Weight (Focus):', array( $this, 'ratabs_settings_styles_tabs_list_font_weight_focus' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_list_text_align', 'Text Align:', array( $this, 'ratabs_settings_styles_tabs_list_text_align' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_list_tab_height', 'Tab Height:', array( $this, 'ratabs_settings_styles_tabs_list_tab_height' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_list_tab_width_selected', 'Tab Width (Selected):', array( $this, 'ratabs_settings_styles_tabs_list_tab_width_selected' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tabs_list_line_height', 'Line Height:', array( $this, 'ratabs_settings_styles_tabs_list_line_height' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		
		add_settings_field( 'ratabs_settings_styles_content', '<h3>Content Section</h3>', array( $this, 'ratabs_settings_styles_empty' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_content_text_colour', 'Text Colour:', array( $this, 'ratabs_settings_styles_content_text_colour' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_content_header_colour', 'Header Text Colour:', array( $this, 'ratabs_settings_styles_content_header_colour' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_content_anchor_colour', 'Link Text Colour:', array( $this, 'ratabs_settings_styles_content_anchor_colour' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_content_anchor_hover_colour', 'Link Text Colour (Hover):', array( $this, 'ratabs_settings_styles_content_anchor_hover_colour' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_content_bg_colour', 'Background Colour:', array( $this, 'ratabs_settings_styles_content_bg_colour' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_content_top_border_colour', 'Top Border Colour:', array( $this, 'ratabs_settings_styles_content_top_border_colour' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_content_top_border_width', 'Top Border Width:', array( $this, 'ratabs_settings_styles_content_top_border_width' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		
		add_settings_field( 'ratabs_settings_styles_padding', '<h3>Padding</h3>', array( $this, 'ratabs_settings_styles_empty' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tab_padding', 'Tab Padding:', array( $this, 'ratabs_settings_styles_tab_padding' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_tab_padding_hover', 'Tab Padding (Hover):', array( $this, 'ratabs_settings_styles_tab_padding_hover' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_accordion_header_padding', 'Accordion Header Padding:', array( $this, 'ratabs_settings_styles_accordion_header_padding' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_content_padding', 'Content Padding:', array( $this, 'ratabs_settings_styles_content_padding' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_text_content_padding', 'Text Content Padding:', array( $this, 'ratabs_settings_styles_text_content_padding' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		
		add_settings_field( 'ratabs_settings_styles_vertical', '<h3>Vertical Tab Section</h3>', array( $this, 'ratabs_settings_styles_empty' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_vertical_list_width', 'Tab List Width:', array( $this, 'ratabs_settings_styles_vertical_list_width' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		
		add_settings_field( 'ratabs_settings_styles_jump_links', '<h3>Jump Links</h3>', array( $this, 'ratabs_settings_styles_empty' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
		add_settings_field( 'ratabs_settings_styles_jump_links_scroll_padding', 'Header Spacing:', array( $this, 'ratabs_settings_styles_jump_links_scroll_padding' ), 'ratabs-settings-styles-group', 'ratabs_settings_styles_group_section');
	}
	
	public function ratabs_settings_styles_text() {
		echo "<p>To customise the accordion tabs to match your theme you can update colours below and then select 'Custom' as the theme option.</p>";
		echo "<p>If you would like to request additional options are included here, please email <a href='mailto:support@ampersandstudio.uk'>support@ampersandstudio.uk</a> with your requirements.</p>";
	}
	
	public function ratabs_settings_styles_empty() {
		echo "";
	}
	
	//Tabs Wrapper
	public function ratabs_settings_styles_tabs_wrapper_tb_colour() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_wrapper_bb_colour' name='ratabs_settings_styles[tabs_wrapper_tb_colour]' type='text' class='ratabs-colour-picker' value='".( isset( $options['tabs_wrapper_tb_colour'] ) ? esc_attr( $options['tabs_wrapper_tb_colour'] ) : '' )."' data-alpha-enabled='true' />";
	}
	
	public function ratabs_settings_styles_tabs_wrapper_tb_width() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_wrapper_tb_width' name='ratabs_settings_styles[tabs_wrapper_tb_width]' type='text' value='".( isset( $options['tabs_wrapper_tb_width'] ) ? esc_attr( $options['tabs_wrapper_tb_width'] ) : '' )."' placeholder='Default: 0px' />";
	}
	
	public function ratabs_settings_styles_tabs_wrapper_tb_style() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_wrapper_tb_style' name='ratabs_settings_styles[tabs_wrapper_tb_style]' type='text' value='".( isset( $options['tabs_wrapper_tb_style'] ) ? esc_attr( $options['tabs_wrapper_tb_style'] ) : '' )."' placeholder='Default: solid' />";
	}
	
	//Tabs/Accordions
	public function ratabs_settings_styles_tabs_text_colour() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_text_colour' name='ratabs_settings_styles[tabs_text_colour]' type='text' class='ratabs-colour-picker' value='".( isset( $options['tabs_text_colour'] ) ? esc_attr( $options['tabs_text_colour'] ) : '' )."' data-alpha-enabled='true' />";
	}
	
	public function ratabs_settings_styles_tabs_text_hover_colour() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_text_hover_colour' name='ratabs_settings_styles[tabs_text_hover_colour]' type='text' class='ratabs-colour-picker' value='".( isset( $options['tabs_text_hover_colour'] ) ? esc_attr( $options['tabs_text_hover_colour'] ) : '' )."' data-alpha-enabled='true' />";
	}
	
	public function ratabs_settings_styles_tabs_selected_text_colour() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_selected_text_colour' name='ratabs_settings_styles[tabs_selected_text_colour]' type='text' class='ratabs-colour-picker' value='".( isset( $options['tabs_selected_text_colour'] ) ? esc_attr( $options['tabs_selected_text_colour'] ) : '' )."' data-alpha-enabled='true' />";
	}
	
	public function ratabs_settings_styles_tabs_list_bg_colour() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_list_bg_colour' name='ratabs_settings_styles[tabs_list_bg_colour]' type='text' class='ratabs-colour-picker' value='".( isset( $options['tabs_list_bg_colour'] ) ? esc_attr( $options['tabs_list_bg_colour'] ) : '' )."' data-alpha-enabled='true' />";
	}
	
	public function ratabs_settings_styles_tabs_list_bg_colour_hover() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_list_bg_colour_hover' name='ratabs_settings_styles[tabs_list_bg_colour_hover]' type='text' class='ratabs-colour-picker' value='".( isset( $options['tabs_list_bg_colour_hover'] ) ? esc_attr( $options['tabs_list_bg_colour_hover'] ) : '' )."' data-alpha-enabled='true' />";
	}
	
	public function ratabs_settings_styles_tabs_selected_bg_colour() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_selected_bg_colour' name='ratabs_settings_styles[tabs_selected_bg_colour]' type='text' class='ratabs-colour-picker' value='".( isset( $options['tabs_selected_bg_colour'] ) ? esc_attr( $options['tabs_selected_bg_colour'] ) : '' )."' data-alpha-enabled='true' />";
	}
	
	public function ratabs_settings_styles_tabs_list_bb_colour() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_list_bb_colour' name='ratabs_settings_styles[tabs_list_bb_colour]' type='text' class='ratabs-colour-picker' value='".( isset( $options['tabs_list_bb_colour'] ) ? esc_attr( $options['tabs_list_bb_colour'] ) : '' )."' data-alpha-enabled='true' />";
	}
	
	public function ratabs_settings_styles_tabs_list_bb_width() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_list_bb_width' name='ratabs_settings_styles[tabs_list_bb_width]' type='text' value='".( isset( $options['tabs_list_bb_width'] ) ? esc_attr( $options['tabs_list_bb_width'] ) : '' )."' placeholder='Default: 1px' />";
	}
	
	public function ratabs_settings_styles_tabs_list_font_size() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_list_font_size' name='ratabs_settings_styles[tabs_list_font_size]' type='text' value='".( isset( $options['tabs_list_font_size'] ) ? esc_attr( $options['tabs_list_font_size'] ) : '' )."' placeholder='' />";
	}
	
	public function ratabs_settings_styles_tabs_list_font_size_hover() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_list_font_size_hover' name='ratabs_settings_styles[tabs_list_font_size_hover]' type='text' value='".( isset( $options['tabs_list_font_size_hover'] ) ? esc_attr( $options['tabs_list_font_size_hover'] ) : '' )."' placeholder='' />";
	}
	
	public function ratabs_settings_styles_tabs_list_font_weight() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_list_font_weight' name='ratabs_settings_styles[tabs_list_font_weight]' type='text' value='".( isset( $options['tabs_list_font_weight'] ) ? esc_attr( $options['tabs_list_font_weight'] ) : '' )."' placeholder='Default: 400' />";
	}
	
	public function ratabs_settings_styles_tabs_list_font_weight_hover() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_list_font_weight_hover' name='ratabs_settings_styles[tabs_list_font_weight_hover]' type='text' value='".( isset( $options['tabs_list_font_weight_hover'] ) ? esc_attr( $options['tabs_list_font_weight_hover'] ) : '' )."' placeholder='' />";
	}
	
	public function ratabs_settings_styles_tabs_list_font_weight_selected() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_list_font_weight_selected' name='ratabs_settings_styles[tabs_list_font_weight_selected]' type='text' value='".( isset( $options['tabs_list_font_weight_selected'] ) ? esc_attr( $options['tabs_list_font_weight_selected'] ) : '' )."' placeholder='' />";
	}
	
	public function ratabs_settings_styles_tabs_list_font_weight_focus() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_list_font_weight_focus' name='ratabs_settings_styles[tabs_list_font_weight_focus]' type='text' value='".( isset( $options['tabs_list_font_weight_focus'] ) ? esc_attr( $options['tabs_list_font_weight_focus'] ) : '' )."' placeholder='' />";
	}
	
	public function ratabs_settings_styles_tabs_list_text_align() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_list_text_align' name='ratabs_settings_styles[tabs_list_text_align]' type='text' value='".( isset( $options['tabs_list_text_align'] ) ? esc_attr( $options['tabs_list_text_align'] ) : '' )."' placeholder='Default: center' />";
	}
	
	public function ratabs_settings_styles_tabs_list_tab_height() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_list_tab_height' name='ratabs_settings_styles[tabs_list_tab_height]' type='text' value='".( isset( $options['tabs_list_tab_height'] ) ? esc_attr( $options['tabs_list_tab_height'] ) : '' )."' placeholder='' />";
	}
	
	public function ratabs_settings_styles_tabs_list_tab_width_selected() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_list_tab_width_selected' name='ratabs_settings_styles[tabs_list_tab_width_selected]' type='text' value='".( isset( $options['tabs_list_tab_width_selected'] ) ? esc_attr( $options['tabs_list_tab_width_selected'] ) : '' )."' placeholder='' />";
	}
	
	public function ratabs_settings_styles_tabs_list_line_height() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tabs_list_line_height' name='ratabs_settings_styles[tabs_list_line_height]' type='text' value='".( isset( $options['tabs_list_line_height'] ) ? esc_attr( $options['tabs_list_line_height'] ) : '' )."' placeholder='' />";
	}
	
	//Content Section
	public function ratabs_settings_styles_content_text_colour() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_content_text_colour' name='ratabs_settings_styles[content_text_colour]' type='text' class='ratabs-colour-picker' value='".( isset( $options['content_text_colour'] ) ? esc_attr( $options['content_text_colour'] ) : '' )."' data-alpha-enabled='true' />";
	}
	
	public function ratabs_settings_styles_content_header_colour() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_content_header_colour' name='ratabs_settings_styles[content_header_colour]' type='text' class='ratabs-colour-picker' value='".( isset( $options['content_header_colour'] ) ? esc_attr( $options['content_header_colour'] ) : '' )."' data-alpha-enabled='true' />";
	}
	
	public function ratabs_settings_styles_content_anchor_colour() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_content_anchor_colour' name='ratabs_settings_styles[content_anchor_colour]' type='text' class='ratabs-colour-picker' value='".( isset( $options['content_anchor_colour'] ) ? esc_attr( $options['content_anchor_colour'] ) : '' )."' data-alpha-enabled='true' />";
	}
	
	public function ratabs_settings_styles_content_anchor_hover_colour() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_content_anchor_hover_colour' name='ratabs_settings_styles[content_anchor_hover_colour]' type='text' class='ratabs-colour-picker' value='".( isset( $options['content_anchor_hover_colour'] ) ? esc_attr( $options['content_anchor_hover_colour'] ) : '' )."' data-alpha-enabled='true' />";
	}
	
	public function ratabs_settings_styles_content_bg_colour() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_bg_colour' name='ratabs_settings_styles[content_bg_colour]' type='text' class='ratabs-colour-picker' value='".( isset( $options['content_bg_colour'] ) ? esc_attr( $options['content_bg_colour'] ) : '' )."' data-alpha-enabled='true' />";
	}
	
	public function ratabs_settings_styles_content_top_border_colour() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_content_top_border_colour' name='ratabs_settings_styles[content_top_border_colour]' type='text' class='ratabs-colour-picker' value='".( isset( $options['content_top_border_colour'] ) ? esc_attr( $options['content_top_border_colour'] ) : '' )."' data-alpha-enabled='true' />";
	}
	
	public function ratabs_settings_styles_content_top_border_width() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_content_top_border_width' name='ratabs_settings_styles[content_top_border_width]' type='text' value='".( isset( $options['content_top_border_width'] ) ? esc_attr( $options['content_top_border_width'] ) : '' )."' data-alpha-enabled='true' />";
	}
	
	//Padding
	public function ratabs_settings_styles_tab_padding() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tab_padding' name='ratabs_settings_styles[tabs_list_tab_padding]' type='text' value='".( isset( $options['tabs_list_tab_padding'] ) ? esc_attr( $options['tabs_list_tab_padding'] ) : '' )."' placeholder='Default: 15px 20px' />";
	}
	public function ratabs_settings_styles_tab_padding_hover() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_tab_padding_hover' name='ratabs_settings_styles[tabs_list_tab_padding_hover]' type='text' value='".( isset( $options['tabs_list_tab_padding_hover'] ) ? esc_attr( $options['tabs_list_tab_padding_hover'] ) : '' )."' placeholder='' />";
	}
	public function ratabs_settings_styles_accordion_header_padding() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_accordion_header_padding' name='ratabs_settings_styles[accordion_header_padding]' type='text' value='".( isset( $options['accordion_header_padding'] ) ? esc_attr( $options['accordion_header_padding'] ) : '' )."' placeholder='Default: 15px 20px' />";
	}
	
	public function ratabs_settings_styles_content_padding() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_content_padding' name='ratabs_settings_styles[content_padding]' type='text' value='".( isset( $options['content_padding'] ) ? esc_attr( $options['content_padding'] ) : '' )."' placeholder='Default: 20px' />";
	}
	
	public function ratabs_settings_styles_text_content_padding() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_text_content_padding' name='ratabs_settings_styles[text_content_padding]' type='text' value='".( isset( $options['text_content_padding'] ) ? esc_attr( $options['text_content_padding'] ) : '' )."' placeholder='' />";
	}
	
	//Vertical Tab Section
	public function ratabs_settings_styles_vertical_list_width() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_vertical_list_width' name='ratabs_settings_styles[tabs_list_vertical_width]' type='text' value='".( isset( $options['tabs_list_vertical_width'] ) ? esc_attr( $options['tabs_list_vertical_width'] ) : '' )."' placeholder='Default: 20%' />";
	}
	
	//Jump Links
	public function ratabs_settings_styles_jump_links_scroll_padding() {
		$options = get_option( 'ratabs_settings_styles' );
		echo "<input id='ratabs_settings_styles_jump_links_scroll_padding' name='ratabs_settings_styles[jump_links_scroll_padding]' type='text' value='".( isset( $options['jump_links_scroll_padding'] ) ? esc_attr( $options['jump_links_scroll_padding'] ) : '' )."' placeholder='Default: auto' />";
	}
	
	public function save_ratabs_styles_settings($input) {
				
		if ( sanitize_text_field( $_POST['submit'] ) == 'Reset to Defaults' ) {
			$styles = "";
			$input = array();
			
			$css_file = fopen( plugin_dir_path( RATABS_PLUGIN_FILE ) . '/assets/css/custom-styles.css', 'w' );
			fwrite( $css_file, $styles );
			fclose( $css_file );
		}
		else {
			self::write_css( $input );
		}
		
		return $input;
		
	}
	
	public static function write_css( $input = array() ) {
		
		$input = ( !empty( $input ) ? $input : get_option( 'ratabs_settings_styles' ) );
		
		ob_start(); ?>

html {
	scroll-padding-top: <?php echo ( !empty( $input['jump_links_scroll_padding'] ) ? esc_attr( $input['jump_links_scroll_padding'] ) : "auto" ); ?>;
}
.accordion-tabs-wrapper {
	border-top: <?php echo ( !empty( $input['tabs_wrapper_tb_width'] ) ? esc_attr( $input['tabs_wrapper_tb_width'] ) : "0px" ); ?> <?php echo ( !empty( $input['tabs_wrapper_tb_style'] ) ? esc_attr( $input['tabs_wrapper_tb_style'] ) : "solid" ); ?> <?php echo ( !empty( $input['tabs_wrapper_tb_colour'] ) ? esc_attr( $input['tabs_wrapper_tb_colour'] ) : "#ffffff" ); ?>!important;

}
.accordion-tabs.custom {
	color: <?php echo ( !empty( $input['content_text_colour'] ) ? esc_attr( $input['content_text_colour'] ) : "#000" ); ?> !important;
	background-color: <?php echo ( !empty( $input['content_bg_colour'] ) ? esc_attr( $input['content_bg_colour'] ) : "transparent" ); ?>!important;
}

.accordion-tabs.custom .tabs-tab-list,
.accordion-tabs.custom .accordion-trigger {
	background-color: <?php echo ( !empty( $input['tabs_list_bg_colour'] ) ? esc_attr( $input['tabs_list_bg_colour'] ) : "#eee" ); ?>!important;
	font-size: <?php echo ( !empty( $input['tabs_list_font_size'] ) ? esc_attr( $input['tabs_list_font_size'] ) : "inherit" ); ?>!important;
	text-align: <?php echo ( !empty( $input['tabs_list_text_align'] ) ? esc_attr( $input['tabs_list_text_align'] ) : "center" ); ?>!important;
}
.accordion-tabs.custom.vertical .tabs-tab-list {
	flex-basis: <?php echo ( !empty( $input['tabs_list_vertical_width'] ) ? esc_attr( $input['tabs_list_vertical_width'] ) : "20%" ); ?>!important;
}
.accordion-tabs.custom.vertical.tabs-allowed .tabs-tab-list li {
	border-bottom: <?php echo ( !empty( $input['tabs_list_bb_width'] ) ? esc_attr( $input['tabs_list_bb_width'] ) : "1px" ); ?> solid <?php echo ( !empty( $input['tabs_list_bb_colour'] ) ? esc_attr( $input['tabs_list_bb_colour'] ) : "#dee4ec" ); ?>!important;
}
.accordion-tabs.custom .tabs-trigger,
.accordion-tabs.custom .accordion-trigger {
	color: <?php echo ( !empty( $input['tabs_text_colour'] ) ? esc_attr( $input['tabs_text_colour'] ) : "#fff" ); ?>!important;
	font-weight: <?php echo ( !empty( $input['tabs_list_font_weight'] ) ? esc_attr( $input['tabs_list_font_weight'] ) : "400" ); ?>!important;
	height: <?php echo ( !empty( $input['tabs_list_tab_height'] ) ? esc_attr( $input['tabs_list_tab_height'] ) : "inherit" ); ?>!important;
	line-height: <?php echo ( !empty( $input['tabs_list_line_height'] ) ? esc_attr( $input['tabs_list_line_height'] ) : "inherit" ); ?>!important;
}
.accordion-tabs.custom .tabs-trigger {
	padding: <?php echo ( !empty( $input['tabs_list_tab_padding'] ) ? esc_attr( $input['tabs_list_tab_padding'] ) : "15px 20px" ); ?>!important;
}
.accordion-tabs.custom .accordion-trigger {
	padding: <?php echo ( !empty( $input['accordion_header_padding'] ) ? esc_attr( $input['accordion_header_padding'] ) : "15px 20px" ); ?>!important;
}
.accordion-tabs.custom .tabs-trigger:hover,
.accordion-tabs.custom .accordion-trigger:hover {
	color: <?php echo ( !empty( $input['tabs_text_hover_colour'] ) ? esc_attr( $input['tabs_text_hover_colour'] ) : "#ccc" ); ?>!important;
	font-weight: <?php echo ( !empty( $input['tabs_list_font_weight_hover'] ) ? esc_attr( $input['tabs_list_font_weight_hover'] ) : ( !empty( $input['tabs_list_font_weight'] ) ? esc_attr( $input['tabs_list_font_weight'] ) : "400" ) ); ?>!important;
	font-size: <?php echo ( !empty( $input['tabs_list_font_size_hover'] ) ? esc_attr( $input['tabs_list_font_size_hover'] ) : "inherit" ); ?>!important;
	background-color: <?php echo ( !empty( $input['tabs_list_bg_colour_hover'] ) ? esc_attr( $input['tabs_list_bg_colour_hover'] ) : ( !empty( $input['tabs_list_bg_colour'] ) ? esc_attr( $input['tabs_list_bg_colour'] ) : "#eee" ) ); ?>!important;
}
.accordion-tabs.custom .tabs-trigger:hover {
	padding: <?php echo ( !empty( $input['tabs_list_tab_padding_hover'] ) ? esc_attr( $input['tabs_list_tab_padding_hover'] ) : ( !empty( $input['tabs_list_tab_padding'] ) ? esc_attr( $input['tabs_list_tab_padding'] ) : "15px 20px" ) ); ?>!important;
}
.accordion-tabs.custom .tabs-trigger:active,
.accordion-tabs.custom .accordion-trigger:active {
	font-weight: <?php echo ( !empty( $input['tabs_list_font_weight_selected'] ) ? esc_attr( $input['tabs_list_font_weight_selected'] ) : ( !empty( $input['tabs_list_font_weight'] ) ? esc_attr( $input['tabs_list_font_weight'] ) : "400" ) ); ?>!important;
}
.accordion-tabs.custom .tabs-trigger:focus,
.accordion-tabs.custom .accordion-trigger:focus {
	font-weight: <?php echo ( !empty( $input['tabs_list_font_weight_focus'] ) ? esc_attr( $input['tabs_list_font_weight_focus'] ) : ( !empty( $input['tabs_list_font_weight'] ) ? esc_attr( $input['tabs_list_font_weight'] ) : "400" ) ); ?>!important;
}
.accordion-tabs.custom .tabs-trigger.is-selected, 
.accordion-tabs.custom .tabs-trigger.is-selected:hover, 
.accordion-tabs.custom .tabs-trigger.is-selected:focus,
.accordion-tabs.custom .tabs-panel.is-open > div.accordion-trigger {
	background-color: <?php echo ( !empty( $input['tabs_selected_bg_colour'] ) ? esc_attr( $input['tabs_selected_bg_colour'] ) : ( !empty( $input['tabs_list_bg_colour'] ) ? esc_attr( $input['tabs_list_bg_colour'] ) : "#000" ) ); ?>!important;
	color: <?php echo ( !empty( $input['tabs_selected_text_colour'] ) ? esc_attr( $input['tabs_selected_text_colour'] ) : "#fff" ); ?>!important;
	font-weight: <?php echo ( !empty( $input['tabs_list_font_weight_selected'] ) ? esc_attr( $input['tabs_list_font_weight_selected'] ) : ( !empty( $input['tabs_list_font_weight'] ) ? esc_attr( $input['tabs_list_font_weight'] ) : "400" ) ); ?>!important;
}
.accordion-tabs.custom .tabs-trigger.is-selected, 
.accordion-tabs.custom .tabs-trigger.is-selected:hover, 
.accordion-tabs.custom .tabs-trigger.is-selected:focus {
	width: <?php echo ( !empty( $input['tabs_list_tab_width_selected'] ) ? esc_attr( $input['tabs_list_tab_width_selected'] ) : "inherit" ); ?>!important;
}
.accordion-tabs.custom div.content.is-open {
	padding: <?php echo ( !empty( $input['content_padding'] ) ? esc_attr( $input['content_padding'] ) : "20px" ); ?>!important;
}
.accordion-tabs.custom h1,
.accordion-tabs.custom h2,
.accordion-tabs.custom h3,
.accordion-tabs.custom h4,
.accordion-tabs.custom h5,
.accordion-tabs.custom h6 {
	color: <?php echo ( !empty( $input['content_header_colour'] ) ? esc_attr( $input['content_header_colour'] ) : "#fff" ); ?>;
}
.accordion-tabs.custom .section-text {
	padding: <?php echo ( !empty( $input['text_content_padding'] ) ? esc_attr( $input['text_content_padding'] ) : "0px" ); ?>!important;
}
.accordion-tabs.custom .section-text a {
	color: <?php echo ( !empty( $input['content_anchor_colour'] ) ? esc_attr( $input['content_anchor_colour'] ) : "#ccc" ); ?>!important;
}
.accordion-tabs.custom .section-text a:hover {
	color: <?php echo ( !empty( $input['content_anchor_hover_colour'] ) ? esc_attr( $input['content_anchor_hover_colour'] ) : "#fff" ); ?>!important;
}
.tabs-panel:not(:first-of-type),
.tabs-allowed .tabs-panel:first-of-type {
	border-top: <?php echo ( !empty( $input['content_top_border_width'] ) ? esc_attr( $input['content_top_border_width'] ) : "2px" ); ?> solid <?php echo ( !empty( $input['content_top_border_colour'] ) ? esc_attr( $input['content_top_border_colour'] ) : "#eee" ); ?>!important;
}
		
<?php	$styles = ob_get_clean();
		
		$css_file = fopen( plugin_dir_path( RATABS_PLUGIN_FILE ) . '/assets/css/custom-styles.css', 'w' );
		fwrite( $css_file, $styles );
		fclose( $css_file );
		
	}
	
}