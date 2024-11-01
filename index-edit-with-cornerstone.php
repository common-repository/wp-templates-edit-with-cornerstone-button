<?php
/**
 * Plugin Name: WP Templates - Edit with Cornerstone Button
 * Plugin URI: https://www.wptemplates.store/
 * Description: Re-add the Edit with Cornerstone button when in a page being edited with Gutenberg
 * Version: 1.0.0
 * Author: WP Templates
 * Author URI: https://www.wptemplates.store/plugins/wptemplates-edit-with-cornerstone-button/
 */

// Add Toolbar Menus
function add_edit_with_cornerstone_toolbar() {
	global $wp_admin_bar;

	$id_to_edit = sanitize_text_field($_GET['post']);
	$post_type_to_edit = sanitize_text_field($_GET['post_type']);
	$this_post_type = get_post_type($id_to_edit);
	
	if(($post_type_to_edit === 'page' || $this_post_type === 'page') && $id_to_edit > 0) {
		$allow_edit_cornerstone = true;
	} 
	
	if($allow_edit_cornerstone) {
		$theme = get_current_theme();
		
		if (strpos($theme, 'X') !== false) {
			$theme_edit_url = 'x';
		} else if (strpos($theme, 'Pro') !== false) {
			$theme_edit_url = 'pro';
		}

		$site_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
		$site_array = explode('wp-admin', $site_url);

		$id_to_edit = $_GET['post'];
		$edit_url = $site_array[0] . $theme_edit_url . '/#/content/' . $id_to_edit;

		$args = array(
			'id'     => 'edit_cornerstone',
			'title'  => __( 'Edit with Cornerstone', 'text_domain' ),
			'href'   => esc_url_raw($edit_url),
			'group'  => false
		);
		$wp_admin_bar->add_menu( $args );
	}
}
add_action( 'wp_before_admin_bar_render', 'add_edit_with_cornerstone_toolbar', 999 );