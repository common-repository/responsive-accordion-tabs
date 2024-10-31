<?php

namespace Responsive_Accordion_Tabs\Admin;


if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly
}

class Settings
{
    public function __construct()
    {
        
        if ( is_admin() ) {
            add_action( 'admin_menu', array( $this, 'add_admin_settings' ) );
            $plugin = plugin_basename( RATABS_PLUGIN_FILE );
            add_filter( "plugin_action_links_{$plugin}", array( $this, 'ratabs_settings_link' ) );
        }
        
        new \Responsive_Accordion_Tabs\Admin\Settings\Defaults();
    }
    
    public function add_admin_settings()
    {
        // ...
        add_options_page(
            'Accordion Tabs',
            'Accordion Tabs',
            'manage_options',
            'ratabs-settings-group',
            array( $this, 'ratabs_admin_options' )
        );
    }
    
    public function ratabs_settings_link( $links )
    {
        // Build and escape the URL.
        $url = esc_url( add_query_arg( 'page', 'ratabs-settings-group', get_admin_url() . 'options-general.php' ) );
        // Create the link.
        $settings_link = "<a href='{$url}'>" . __( 'Settings' ) . '</a>';
        // Adds the link to the end of the array.
        array_unshift( $links, $settings_link );
        return $links;
    }
    
    public function ratabs_admin_options()
    {
        if ( !current_user_can( 'manage_options' ) ) {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        //Get the active tab from the $_GET param
        $default_tab = "defaults";
        $tab = ( isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : $default_tab );
        ?>
		
		<div class="wrap">
			<h2><?php 
        echo  esc_html( get_admin_page_title() ) ;
        ?></h2>
			
			<nav class="nav-tab-wrapper">
			  <a href="?page=ratabs-settings-group" class="nav-tab <?php 
        if ( $tab === "defaults" ) {
            ?>nav-tab-active<?php 
        }
        ?>">Defaults</a>
<?php 
        ?>
			
			</nav>
			
			<div class="tab-content">
	<?php 
        switch ( $tab ) {
            case 'styles':
                break;
            case 'export':
                break;
            case 'import':
                break;
            default:
                ?>
						
						<div class="wrap">
							
							<form action="options.php" method="post">
							
							<?php 
                settings_fields( 'ratabs_settings_defaults_group' );
                ?>
							<?php 
                do_settings_sections( 'ratabs-settings-defaults-group' );
                ?>
							<?php 
                submit_button();
                ?>
							
							</form>
						</div>
						
<?php 
                break;
        }
        ?>
		</div>
<?php 
    }

}