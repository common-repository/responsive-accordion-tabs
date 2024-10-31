<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the
 * plugin admin area. This file also includes all of the dependencies used by
 * the plugin, registers the activation and deactivation functions, and defines
 * a function that starts the plugin.
 *
 * @link              
 * @since             1.4.1
 * @package           responsive-accordion-tabs
 *
 * @wordpress-plugin
 * Plugin Name: Responsive Accordion Tabs Professional
 * Plugin URI:        
 * Description:       Add tabs to your website that convert to accordions on smaller screens
 * Version:           1.4.1
 * Author:            Richard Holmes
 * Author URI:        https://ampersandstudio.uk/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly
}


if ( function_exists( 'ratabs_fs' ) ) {
    ratabs_fs()->set_basename( false, __FILE__ );
} else {
    
    if ( !function_exists( 'ratabs_fs' ) ) {
        // Create a helper function for easy SDK access.
        function ratabs_fs()
        {
            global  $ratabs_fs ;
            
            if ( !isset( $ratabs_fs ) ) {
                // Activate multisite network integration.
                if ( !defined( 'WP_FS__PRODUCT_10438_MULTISITE' ) ) {
                    define( 'WP_FS__PRODUCT_10438_MULTISITE', true );
                }
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $ratabs_fs = fs_dynamic_init( array(
                    'id'              => '10438',
                    'slug'            => 'responsive-accordion-tabs',
                    'type'            => 'plugin',
                    'public_key'      => 'pk_253a3b567932f99a61c8be26c04a8',
                    'is_premium'      => false,
                    'premium_suffix'  => 'Professional',
                    'has_addons'      => false,
                    'has_paid_plans'  => true,
                    'trial'           => array(
                    'days'               => 3,
                    'is_require_payment' => false,
                ),
                    'menu'            => array(
                    'slug'    => 'ratabs-settings-group',
                    'support' => false,
                    'parent'  => array(
                    'slug' => 'options-general.php',
                ),
                ),
                    'connect_message' => 'Hey {first_name}, never miss an important update -- opt-in to our security and feature updates notifications, and non-sensitive diagnostic tracking with freemius.com.',
                    'is_live'         => true,
                ) );
            }
            
            return $ratabs_fs;
        }
        
        // Init Freemius.
        ratabs_fs();
        // Signal that SDK was initiated.
        do_action( 'ratabs_fs_loaded' );
    }

}

function ratabs_fs_custom_connect_message_on_update(
    $message,
    $user_first_name,
    $plugin_title,
    $user_login,
    $site_link,
    $freemius_link
)
{
    return sprintf( __( 'Hey %1$s' ) . ',<br>' . __( 'never miss an important update -- opt-in to our security and feature updates notifications, and non-sensitive diagnostic tracking with freemius.com.', 'responsive-accordion-tabs' ), $user_first_name );
}

ratabs_fs()->add_filter(
    'connect_message_on_update',
    'ratabs_fs_custom_connect_message_on_update',
    10,
    6
);
define( 'RATABS_PLUGIN_FILE', __FILE__ );
define( 'RESPONSIVE_ACCORDION_TABS_PLUGIN_VERSION', '1.4.1' );
// Define the main autoloader
spl_autoload_register( 'responsive_accordion_tabs_autoloader' );
function responsive_accordion_tabs_autoloader( $class_name )
{
    // These should be changed for your particular plugin requirements
    $parent_namespace = 'Responsive_Accordion_Tabs';
    $classes_subfolder = 'includes';
    
    if ( false !== strpos( $class_name, $parent_namespace ) ) {
        $classes_dir = realpath( plugin_dir_path( RATABS_PLUGIN_FILE ) ) . DIRECTORY_SEPARATOR . $classes_subfolder . DIRECTORY_SEPARATOR;
        // Project namespace
        $project_namespace = $parent_namespace . '\\';
        $length = strlen( $project_namespace );
        // Remove top-level namespace (that is the current dir)
        $class_file = substr( $class_name, $length );
        // Swap underscores for dashes and lowercase
        $class_file = str_replace( '_', '-', strtolower( $class_file ) );
        // Prepend `class-` to the filename (last class part)
        $class_parts = explode( '\\', $class_file );
        $last_index = count( $class_parts ) - 1;
        $class_parts[$last_index] = 'class-' . $class_parts[$last_index];
        // Join everything back together and add the file extension
        $class_file = implode( DIRECTORY_SEPARATOR, $class_parts ) . '.php';
        $location = $classes_dir . $class_file;
        if ( !is_file( $location ) ) {
            return;
        }
        require_once $location;
    }

}

$init = new \Responsive_Accordion_Tabs\Init();