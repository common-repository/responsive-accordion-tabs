<?php

namespace Responsive_Accordion_Tabs\Admin\Settings;


if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly
}

class Defaults
{
    public function __construct()
    {
        add_action( 'admin_init', array( $this, 'register_defaults_admin_settings' ) );
        $options = get_option( 'ratabs_settings_defaults' );
        if ( !$options ) {
            update_option( 'ratabs_settings_defaults', array(
                "theme"     => "transparent",
                "direction" => "horizontal",
            ) );
        }
    }
    
    public function register_defaults_admin_settings()
    {
        //register our settings
        register_setting( 'ratabs_settings_defaults_group', 'ratabs_settings_defaults', array( $this, 'save_ratabs_defaults_settings' ) );
        add_settings_section(
            'ratabs_settings_defaults_group_section',
            'Default Settings',
            array( $this, 'ratabs_settings_defaults_text' ),
            'ratabs-settings-defaults-group'
        );
        add_settings_field(
            'ratabs_settings_defaults_theme',
            'Theme',
            array( $this, 'ratabs_settings_defaults_theme' ),
            'ratabs-settings-defaults-group',
            'ratabs_settings_defaults_group_section'
        );
        add_settings_field(
            'ratabs_settings_defaults_direction',
            'Direction',
            array( $this, 'ratabs_settings_defaults_direction' ),
            'ratabs-settings-defaults-group',
            'ratabs_settings_defaults_group_section'
        );
    }
    
    public function ratabs_settings_defaults_text()
    {
        echo  '<p>Set the options to be used, by default, for all Accordion Tabs.</p>' ;
    }
    
    public function ratabs_settings_defaults_theme()
    {
        $options = get_option( 'ratabs_settings_defaults' );
        ?>
		<select name="ratabs_settings_defaults[theme]" id="ratabs_settings_defaults_theme">
			<option value="light" <?php 
        selected( ( isset( $options['theme'] ) ? $options['theme'] : 'light' ), 'light' );
        ?>> Light</option>
			<option value="dark" <?php 
        selected( ( isset( $options['theme'] ) ? $options['theme'] : 'dark' ), 'dark' );
        ?>> Dark</option>
			<option value="transparent" <?php 
        selected( ( isset( $options['theme'] ) ? $options['theme'] : 'transparent' ), 'transparent' );
        ?>> Transparent</option>
<?php 
        ?>
		</select>
		<p>Direction for tabs to appear.<?php 
        if ( !ratabs_fs()->can_use_premium_code() ) {
            ?> Upgrade to Pro for vertical tab direction!<?php 
        }
        ?></p>
<?php 
    }
    
    public function ratabs_settings_defaults_direction()
    {
        $options = get_option( 'ratabs_settings_defaults' );
        ?>
		<select name="ratabs_settings_defaults[direction]" id="ratabs_settings_defaults_direction">
			<option value="horizontal" <?php 
        selected( ( isset( $options['direction'] ) ? $options['direction'] : 'horizontal' ), 'horizontal' );
        ?>> Horizontal</option>
<?php 
        ?>
		</select><br />
		<p>Direction for tabs to appear.<?php 
        if ( !ratabs_fs()->can_use_premium_code() ) {
            ?> Upgrade to Pro for vertical tab direction!<?php 
        }
        ?></p>
<?php 
    }
    
    public function save_ratabs_defaults_settings( $input )
    {
        return $input;
    }

}