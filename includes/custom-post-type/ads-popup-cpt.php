<?php
class Ads_Popup_Creator_cpt{
	function __construct(){
		add_action('init',[$this,'apc_register_popup_cpt']);
	}
	function apc_register_popup_cpt() {

		/**
		 * Post Type: Ads Popups.
		 */

		$labels = [
			"name" => __( "Ads Popups", "twentytwenty" ),
			"singular_name" => __( "Ads Popup", "twentytwenty" ),
			"add_new" => __( "Add New", "twentytwenty" ),
			"add_new_item" => __( "Ads Poupu Title", "twentytwenty" ),
			"featured_image" => __( "Ads Pupup Image", "twentytwenty" ),
			"set_featured_image" => __( "Set ads popup image", "twentytwenty" ),
		];

		$args = [
			"label" => __( "Ads Popups", "twentytwenty" ),
			"labels" => $labels,
			"description" => "",
			"public" => false,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => false,
			"show_in_menu" => true,
			"show_in_nav_menus" => false,
			"delete_with_user" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => [ "slug" => "ads_popup", "with_front" => true ],
			"query_var" => true,
			"menu_icon" => "dashicons-megaphone",
			"supports" => [ "title", "thumbnail" ],
			"show_in_graphql" => false,
		];

		register_post_type( "ads_popup", $args );
	}
}
new Ads_Popup_Creator_cpt();
