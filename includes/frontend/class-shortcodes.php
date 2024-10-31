<?php
namespace Responsive_Accordion_Tabs\Frontend;

if ( ! defined( 'ABSPATH' ) ) { 
	exit; // Exit if accessed directly
}
class Shortcodes {

	public function __construct() {
		
		add_shortcode( 'ratabs', array( $this, 'responsive_accordion_tabs_display' ) );
	}
	
	public function responsive_accordion_tabs_display( $atts = array(), $content = null ) {
		$options = get_option( 'ratabs_settings_defaults' );
		
		$atts = shortcode_atts(array(
			'id' => 0,
			'theme' => $options['theme'],
			'breakpoint' => 640,
			'tabs_allowed' => true,
			'selected_tab' => 0,
			'start_collapsed' => false,
			'hide_title' => false,
			'hide_description' => false,
			'direction' => $options['direction']
		), $atts); 
		
		ob_start(); 
		
		if ( $atts["id"] ) { 
			
			$tabs_settings = get_post_meta( $atts["id"], 'accordion_tab_settings', true );
			$tabs_settings['theme'] = ( isset( $tabs_settings['theme'] ) && $tabs_settings['theme'] == "default" ? esc_attr( $options['theme'] ) : $tabs_settings['theme'] );
			$tabs_settings['direction'] = ( isset( $tabs_settings['direction'] ) && $tabs_settings['direction'] == "default" ? esc_attr( $options['direction'] ) : $tabs_settings['direction'] );
			
			$atts = shortcode_atts(array(
				'id' => $atts["id"],
				'theme' => $atts['theme'],
				'breakpoint' => $atts['breakpoint'],
				'tabs_allowed' => $atts['tabs_allowed'],
				'selected_tab' => $atts['selected_tab'],
				'start_collapsed' => $atts['start_collapsed'],
				'hide_title' => $atts['hide_title'],
				'hide_description' => $atts['hide_description'],
				'direction' => $atts['direction']
			), $tabs_settings); 
			
			if ( $atts['theme'] == 'custom' ) {
				wp_enqueue_style( 'responsive-accordion-tabs-custom-styles' );
			} ?>
		
			<div class="accordion-tabs-wrapper">
				
				<div class="accordion-tabs-title-wrapper">
			
		<?php	if ( !$atts["hide_title"] ) { ?>
					<h3><?php echo get_the_title($atts["id"]); ?></h3>
		<?php	}
				if ( !$atts["hide_description"] ) {
					echo apply_filters( 'the_content', get_the_content( "", false, $atts["id"] ) );
				} ?>
				</div>
			
<?php		$tabs_data = get_post_meta( $atts["id"], 'accordion_tab_data', true ); ?>
	
				<div class="accordion-tabs js-tabs <?php echo esc_attr( $atts["theme"] ); ?> <?php echo esc_attr( $atts["direction"] ); ?>" data-breakpoint="<?php echo esc_attr( $atts['breakpoint'] ); ?>" data-tabs-allowed="<?php echo ( !$atts['tabs_allowed'] ? 'false' : 'true' ); ?>" data-selected-tab="<?php echo esc_attr( $atts['selected_tab'] ); ?>" data-start-collapsed="<?php echo ( !$atts['start_collapsed'] ? 'false' : 'true' ); ?>">
				
<?php			if ( !empty( $tabs_data ) ) { ?>
		  			<ul role="tablist" class="tabs-tab-list">
<?php				$index = 10;
					foreach( $tabs_data as $key => $tab_data ) { ?>
						<li role="presentation"><a href="#section<?php echo esc_attr( $key ); ?>" role="tab" id="<?php echo ( isset( $tab_data["hashvalue"] ) && !empty( $tab_data["hashvalue"] ) ? $tab_data["hashvalue"] : 'tab'.esc_attr( $key ) ); ?>" aria-controls="section<?php echo esc_attr( $key ); ?>" aria-selected="true" class="tabs-trigger js-tabs-trigger" tabindex="<?php echo $index; ?>"><?php echo esc_attr( $tab_data["title"] ); ?></a></li> 
<?php					$index++;
					} ?>
		  			</ul>
<?php				foreach( $tabs_data as $key => $tab_data ) { ?>
		  			<section id="section<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab<?php echo esc_attr( $key ); ?>" class="tabs-panel js-tabs-panel" tabindex="0">
						<div class="accordion-trigger js-accordion-trigger" aria-controls="section<?php echo esc_attr( $key ); ?>" aria-expanded="<?php echo ( !$key ? "true" : "false" ); ?>" tabindex="0"><?php echo esc_attr( $tab_data["title"] ); ?></div>
						<div class="content" aria-hidden="false">
	<?php					$image_url = wp_get_attachment_image_url( esc_attr( $tab_data["media_id"] ), 'large' );
							if ( $image_url ) { ?>
							<div class="section-image">
								<img src="<?php echo esc_attr( $image_url ); ?>" alt="<?php echo esc_attr( $tab_data["imgalt"] ); ?>" />
							</div>
	<?php					} ?>
							<div class="section-text<?php echo ( !$image_url ? " no-image" : "" ); ?>">
	<?php			  			echo apply_filters( 'the_content', $tab_data["description"] ); ?>
							</div>
						</div>
		  			</section>
<?php				} ?>
<?php			} ?>
				</div>
			
			</div>
<?php	}
		return ob_get_clean();
	}
	
}