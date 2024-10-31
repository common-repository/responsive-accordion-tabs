<?php

namespace Responsive_Accordion_Tabs\Admin;


if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly
}

class Posts
{
    public function __construct()
    {
        add_action( 'init', array( $this, 'add_accordion_tabs_post_type' ), 20 );
        add_filter( 'manage_accordion-tabs_posts_columns', array( $this, 'set_accordion_tabs_columns' ) );
        add_action(
            'manage_accordion-tabs_posts_custom_column',
            array( $this, 'accordion_tabs_column' ),
            10,
            2
        );
        add_action( 'add_meta_boxes_accordion-tabs', array( $this, 'add_accordion_tab_meta_box' ) );
        add_action(
            'save_post_accordion-tabs',
            array( $this, 'save_accordion_tab_meta_box' ),
            10,
            1
        );
        add_action(
            'save_post_accordion-tabs',
            array( $this, 'save_accordion_tab_sidebar_meta_box' ),
            11,
            1
        );
        add_action( 'wp_ajax_add_new_wp_editor', array( $this, 'add_new_wp_editor' ) );
    }
    
    public function add_accordion_tabs_post_type()
    {
        // Our custom post type function
        register_post_type( 'accordion-tabs', array(
            'labels'          => array(
            'name'                  => __( 'Accordion Tabs' ),
            'singular_name'         => __( 'Accordion Tab' ),
            'search_items'          => __( 'Search Accordion Tabs' ),
            'popular_items'         => __( 'Popular Accordion Tabs' ),
            'all_items'             => __( 'All Accordion Tabs' ),
            'edit_item'             => __( 'Edit Accordion Tab' ),
            'view_item'             => __( 'View Accordion Tab' ),
            'update_item'           => __( 'Update Accordion Tab' ),
            'add_new_item'          => __( 'Add New Accordion Tab' ),
            'new_item_name'         => __( 'New Accordion Tab' ),
            'add_or_remove_items'   => __( 'Add or remove accordion tabs' ),
            'choose_from_most_used' => __( 'Choose from most used accordion tabs' ),
            'not_found'             => __( 'No accordion tabs found' ),
            'no_venues'             => __( 'No accordion tabs' ),
        ),
            'description'     => 'Accordion Tabs to display across the site using shortcodes',
            'public'          => true,
            'has_archive'     => true,
            'rewrite'         => array(
            'slug' => 'accordion-tabs',
        ),
            'show_in_rest'    => false,
            'show_in_menu'    => true,
            'menu_position'   => 5,
            'capability_type' => 'post',
            'supports'        => array( 'title', 'editor' ),
            'menu_icon'       => 'dashicons-index-card',
        ) );
    }
    
    public function set_accordion_tabs_columns( $columns )
    {
        $columns['accordion_tab_id'] = 'ID';
        $columns['accordion_tab_shortcode'] = 'Shortcode';
        return $columns;
    }
    
    public function accordion_tabs_column( $column, $post_id )
    {
        switch ( $column ) {
            case 'accordion_tab_id':
                echo  esc_attr( $post_id ) ;
                break;
            case 'accordion_tab_shortcode':
                echo  "[ratabs id='" . esc_attr( $post_id ) . "']" ;
                break;
        }
    }
    
    public function add_accordion_tab_meta_box()
    {
        global  $wp_meta_boxes ;
        add_meta_box(
            'accordion-tab-metabox-div',
            __( 'Accordion / Tab Content' ),
            array( $this, 'accordion_tab_metaboxes_html' ),
            'accordion-tabs',
            'normal',
            'high'
        );
        add_meta_box(
            'accordion-tab-metabox-sidebar',
            __( 'Accordion / Tab Settings' ),
            array( $this, 'accordion_tab_metaboxes_sidebar_html' ),
            'accordion-tabs',
            'side',
            'core'
        );
    }
    
    public function accordion_tab_metaboxes_html()
    {
        $tabs_data = get_post_meta( get_the_ID(), 'accordion_tab_data', true );
        wp_nonce_field( 'accordion_tab_meta_box_nonce', 'ratabs_meta_box_nonce' );
        ?>
		<p>Enter content for each tab / accordion. You can add a title, select an image and enter the main content for the description of the tab.</p>
		<div class="accordion-tab-metabox">
<?php 
        if ( $tabs_data ) {
            foreach ( $tabs_data as $key => $tab_data ) {
                ?>
			<div class="accordion-tab-row">
				<span class="dashicons dashicons-move"></span>
				<div class="accordion-tab-field-wrapper">
					<p class="meta-options accordion-tab-field">
						<label for="accordion-tab-title_<?php 
                echo  esc_attr( $key ) ;
                ?>">Accordion / Tab Title *:</label> 
						<input id="accordion-tab-title_<?php 
                echo  esc_attr( $key ) ;
                ?>" class="fullwidth" type="text" name="accordion-tab-title[]" value="<?php 
                echo  esc_attr( $tab_data["title"] ) ;
                ?>" />
					</p>
					<p class="meta-options accordion-tab-field">
						<label for="accordion-tab-select-image-<?php 
                echo  esc_attr( $key ) ;
                ?>">Select Image:</label> 
						<button 
						id="accordion-tab-select-image-<?php 
                echo  esc_attr( $key ) ;
                ?>"
						class="button accordion-tabs-plugin-media-button"
						data-accordion-tabs-plugin-media-uploader-target=".accordion-tabs-image-url"
						data-accordion-tabs-plugin-media-uploader-img-target=".accordion-tabs-image-display">Upload File</button>
					</p>
<?php 
                $image_url = wp_get_attachment_image_url( esc_attr( $tab_data["media_id"] ), 'thumbnail' );
                ?>
					<p class="meta-options accordion-tab-field">
						<label for="accordion-tab-current-image-<?php 
                echo  esc_attr( $key ) ;
                ?>">Current Image:</label> 
						<img class="accordion-tabs-image-display" src="<?php 
                echo  ( $image_url ? esc_url( $image_url ) : "" ) ;
                ?>" />
						<input id="accordion-tab-current-image-<?php 
                echo  esc_attr( $key ) ;
                ?>" class="accordion-tabs-image-url" name="accordion-tab-media-id[]" type="hidden" value="<?php 
                echo  esc_attr( $tab_data["media_id"] ) ;
                ?>">
					</p>
					<p class="meta-options accordion-tab-field remove-image-wrap <?php 
                echo  ( $image_url ? "show" : "" ) ;
                ?>">
						<label>&nbsp;</label>
						<button 
							id="accordion-tab-delete-image-<?php 
                echo  esc_attr( $key ) ;
                ?>"
							class="button accordion-tabs-remove-image-button">Remove Image</button>
					</p>
					<p class="meta-options accordion-tab-field">
						<label for="accordion-tab-imgalt_<?php 
                echo  esc_attr( $key ) ;
                ?>">Image Alt Text:</label> 
						<input id="accordion-tab-imgalt_<?php 
                echo  esc_attr( $key ) ;
                ?>" class="fullwidth" type="text" name="accordion-tab-imgalt[]" value="<?php 
                echo  ( isset( $tab_data["imgalt"] ) ? esc_attr( $tab_data["imgalt"] ) : '' ) ;
                ?>" />
					</p>
					<p class="meta-options accordion-tab-field">
						<label for="accordion-tab-hashvalue_<?php 
                echo  esc_attr( $key ) ;
                ?>">Hash Value:</label> 
						<input id="accordion-tab-hashvalue_<?php 
                echo  esc_attr( $key ) ;
                ?>" class="fullwidth" type="text" name="accordion-tab-hashvalue[]" value="<?php 
                echo  ( isset( $tab_data["hashvalue"] ) ? esc_attr( $tab_data["hashvalue"] ) : "" ) ;
                ?>" placeholder="tab<?php 
                echo  $key ;
                ?>" />
					</p>
					<div class="meta-options accordion-tab-field">
						<label for="accordion-tab-description-<?php 
                echo  esc_attr( $key ) ;
                ?>">Tab Description *:</label>
		<?php 
                $text = "";
                //get_post_meta( $post, 'SMTH_METANAME' , true );
                wp_editor( wp_kses_post( $tab_data["description"] ), 'accordion-tabs-wp-editor_' . esc_attr( $key ), $settings = array(
                    'textarea_name' => 'accordion-tab-description[]',
                ) );
                ?>
					</div>
					<p class="meta-options accordion-tab-field">
						<label>&nbsp;</label>
						<button 
						id="accordion-tab-delete-tab"
						class="button accordion-tabs-delete-button">Delete Accordion / Tab</button>
					</p>
				</div>
			</div>
<?php 
            }
        }
        ?>
			<div class="clone-row">
				<span class="dashicons dashicons-move"></span>
				<div class="accordion-tab-field-wrapper">
					<p class="meta-options accordion-tab-field">
						<label for="accordion-tab-title">Accordion / Tab Title *:</label> 
						<input id="accordion-tab-title" class="fullwidth" type="text" name="clone_accordion-tab-title[]" value="" />
					</p>
					<p class="meta-options accordion-tab-field">
						<label for="accordion-tab-select-image">Select Image:</label> 
						<button 
						id="accordion-tab-select-image"
						class="button accordion-tabs-plugin-media-button"
						data-accordion-tabs-plugin-media-uploader-target=".accordion-tabs-image-url"
						data-accordion-tabs-plugin-media-uploader-img-target=".accordion-tabs-image-display">Upload File</button>
					</p>
					<p class="meta-options accordion-tab-field">
						<label for="accordion-tab-current-image">Current Image:</label> 
						<img class="accordion-tabs-image-display" src="" />
						<input id="accordion-tab-current-image" class="accordion-tabs-image-url" name="clone_accordion-tab-media-id[]" type="hidden">
					</p>
					<p class="meta-options accordion-tab-field remove-image-wrap">
						<label>&nbsp;</label>
						<button 
							id="accordion-tab-delete-image-<?php 
        echo  esc_attr( $key ) ;
        ?>"
							class="button accordion-tabs-remove-image-button">Remove Image</button>
					</p>
					<p class="meta-options accordion-tab-field">
						<label for="accordion-tab-imgalt">Image Alt Text:</label> 
						<input id="accordion-tab-imgalt" class="fullwidth" type="text" name="accordion-tab-imgalt[]" value="" />
					</p>
					<p class="meta-options accordion-tab-field">
						<label for="accordion-tab-hashvalue">Hash Value:</label> 
						<input id="accordion-tab-hashvalue" class="fullwidth" type="text" name="accordion-tab-hashvalue[]" value="" placeholder="tab<?php 
        echo  esc_attr( $key + 1 ) ;
        ?>" />
					</p>
					<div class="meta-options accordion-tab-field">
						<label for="accordion-tab-description">Tab Description *:</label>
						<div class="wp-editor"></div>
					</div>
					<p class="meta-options accordion-tab-field">
						<label>&nbsp;</label>
						<button 
						id="accordion-tab-delete-tab"
						class="button accordion-tabs-delete-button">Delete Accordion / Tab</button>
					</p>
				</div>
			</div>
			<hr />
			<div class="button-row">
				<button 
				id="accordion-tab-add-tab"
				class="button accordion-tabs-add-button">Add Accordion / Tab</button>
			</div>
			
		</div>
<?php 
    }
    
    public function accordion_tab_metaboxes_sidebar_html()
    {
        $tabs_settings = get_post_meta( get_the_ID(), 'accordion_tab_settings', true );
        wp_nonce_field( 'accordion_tab_sidebar_meta_box_nonce', 'ratabs_sidebar_meta_box_nonce' );
        ?>
		<p>The following settings will override the default settings but you can also use shortcode attributes to override these settings.</p>
		<div class="accordion-tab-theme-meta-wrap components-base-control__field">
			<p class="post-attributes-label-wrapper">
				<strong> Theme </strong>
			</p>
			<select name="accordion-tab-theme" id="accordion-tab-theme">
				<option value="default" <?php 
        selected( ( isset( $tabs_settings['theme'] ) ? $tabs_settings['theme'] : 'default' ), 'default' );
        ?>> Default</option>
				<option value="light" <?php 
        selected( ( isset( $tabs_settings['theme'] ) ? $tabs_settings['theme'] : 'default' ), 'light' );
        ?>> Light</option>
				<option value="dark" <?php 
        selected( ( isset( $tabs_settings['theme'] ) ? $tabs_settings['theme'] : 'default' ), 'dark' );
        ?>> Dark</option>
				<option value="transparent" <?php 
        selected( ( isset( $tabs_settings['theme'] ) ? $tabs_settings['theme'] : 'default' ), 'transparent' );
        ?>> Transparent</option>
<?php 
        ?>
			</select>
			<p>Select a theme.<?php 
        if ( !ratabs_fs()->can_use_premium_code() ) {
            ?> Upgrade to Pro for custom theme!<?php 
        }
        ?></p>
		</div>
		<div class="accordion-tab-breakpoint-meta-wrap components-base-control__field">
			<p class="post-attributes-label-wrapper">
				<strong> Breakpoint </strong>
			</p>
			<input id="accordion-tab-breakpoint" class="fullwidth" type="text" name="accordion-tab-breakpoint" value="<?php 
        echo  ( isset( $tabs_settings['breakpoint'] ) ? esc_attr( $tabs_settings['breakpoint'] ) : '' ) ;
        ?>" placeholder="640" />px<br />
			<small>The width at which accordions turn to tabs</small>
		</div>
		
		<div class="accordion-tab-hide-sections-meta-wrap components-base-control__field">
			<p class="post-attributes-label-wrapper">
				<strong> Hide Sections </strong>
			</p>
			<input type='checkbox' name='accordion-tab-hide-title' value='1' <?php 
        checked( ( isset( $tabs_settings['hide_title'] ) ? $tabs_settings['hide_title'] : '' ), '1' );
        ?> /> Hide title<br />
			<input type='checkbox' name='accordion-tab-hide-description' value='1' <?php 
        checked( ( isset( $tabs_settings['hide_description'] ) ? $tabs_settings['hide_description'] : '' ), '1' );
        ?> /> Hide description<br />
			<input type='checkbox' name='accordion-tab-hide-tabs' value='1' <?php 
        checked( ( isset( $tabs_settings['tabs_allowed'] ) && $tabs_settings['tabs_allowed'] ? '' : '1' ), '1' );
        ?> /> Hide tabs<br /> <small>Show accordions only</small>
		</div>
		
		<div class="accordion-tab-direction-meta-wrap components-base-control__field">
			<p class="post-attributes-label-wrapper">
				<strong> Direction </strong>
			</p>
			<select name="accordion-tab-direction" id="accordion-tab-direction">
				<option value="default" <?php 
        selected( ( isset( $tabs_settings['direction'] ) ? $tabs_settings['direction'] : 'default' ), 'default' );
        ?>> Default</option>
				<option value="horizontal" <?php 
        selected( ( isset( $tabs_settings['direction'] ) ? $tabs_settings['direction'] : 'default' ), 'horizontal' );
        ?>> Horizontal</option>
<?php 
        ?>
			</select>
			<p>Direction for tabs to appear.<?php 
        if ( !ratabs_fs()->can_use_premium_code() ) {
            ?> Upgrade to Pro for vertical tab direction!<?php 
        }
        ?></p>
		</div>
		
		<div class="accordion-tab-direction-meta-wrap components-base-control__field">
			<p class="post-attributes-label-wrapper">
				<strong> Selected Tab </strong>
			</p>
			<input id="accordion-tab-selected" class="fullwidth" type="text" name="accordion-tab-selected" value="<?php 
        echo  ( isset( $tabs_settings['selected_tab'] ) ? esc_attr( $tabs_settings['selected_tab'] ) : '' ) ;
        ?>" placeholder="0" /><br />
			<p>Index number of tab to first show as open. Start at 0 for first, 1 for second....</p>
		</div>
		
		<div class="accordion-tab-direction-meta-wrap components-base-control__field">
			<p class="post-attributes-label-wrapper">
				<strong> Collapse Accordion </strong>
			</p>
			<input type='checkbox' name='accordion-tab-collapsed' value='1' <?php 
        checked( ( isset( $tabs_settings['start_collapsed'] ) && $tabs_settings['start_collapsed'] ? '1' : '' ), '1' );
        ?> /> Collapse Accordions
			<p>Tick if you would accordions to be closed on page load.</p>
		</div>
<?php 
    }
    
    public function add_new_wp_editor()
    {
        wp_editor( "", sanitize_text_field( $_POST['id'] ), $settings = array(
            'textarea_name' => 'accordion-tab-description[]',
        ) );
        exit;
    }
    
    public function save_accordion_tab_meta_box( $post_id )
    {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
        if ( !isset( $_POST['ratabs_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['ratabs_meta_box_nonce'], 'accordion_tab_meta_box_nonce' ) ) {
            return;
        }
        if ( $parent_id = wp_is_post_revision( $post_id ) ) {
            $post_id = $parent_id;
        }
        $tab_data = array();
        $tab_titles = array_map( 'sanitize_text_field', $_POST["accordion-tab-title"] );
        $tab_media = array_map( 'sanitize_text_field', $_POST["accordion-tab-media-id"] );
        $tab_imgalt = array_map( 'sanitize_text_field', $_POST["accordion-tab-imgalt"] );
        $tab_hashvalues = array_map( 'sanitize_text_field', $_POST["accordion-tab-hashvalue"] );
        $tab_description = array_map( 'wp_kses_post', $_POST["accordion-tab-description"] );
        foreach ( $tab_titles as $key => $tab_title ) {
            $tab_data[] = array(
                "title"       => $tab_title,
                "media_id"    => $tab_media[$key],
                "imgalt"      => $tab_imgalt[$key],
                "hashvalue"   => $tab_hashvalues[$key],
                "description" => $tab_description[$key],
            );
        }
        update_post_meta( $post_id, 'accordion_tab_data', $tab_data );
    }
    
    public function save_accordion_tab_sidebar_meta_box( $post_id )
    {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
        if ( !isset( $_POST['ratabs_sidebar_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['ratabs_sidebar_meta_box_nonce'], 'accordion_tab_sidebar_meta_box_nonce' ) ) {
            return;
        }
        if ( $parent_id = wp_is_post_revision( $post_id ) ) {
            $post_id = $parent_id;
        }
        $tab_settings = array();
        $theme = sanitize_text_field( $_POST["accordion-tab-theme"] );
        $breakpoint = sanitize_text_field( $_POST["accordion-tab-breakpoint"] );
        $title = sanitize_text_field( $_POST["accordion-tab-hide-title"] );
        $description = wp_kses_post( $_POST["accordion-tab-hide-description"] );
        $direction = sanitize_text_field( $_POST["accordion-tab-direction"] );
        $collapse = sanitize_text_field( $_POST["accordion-tab-collapsed"] );
        $hide_tabs = sanitize_text_field( $_POST["accordion-tab-hide-tabs"] );
        $selected = sanitize_text_field( $_POST["accordion-tab-selected"] );
        $tab_settings = array(
            'theme'            => $theme,
            'breakpoint'       => $breakpoint,
            'tabs_allowed'     => ( $hide_tabs ? false : true ),
            'selected_tab'     => ( !empty($selected) ? $selected : 0 ),
            'start_collapsed'  => ( $collapse ? true : false ),
            'hide_title'       => $title,
            'hide_description' => $description,
            'direction'        => $direction,
        );
        update_post_meta( $post_id, 'accordion_tab_settings', $tab_settings );
    }

}