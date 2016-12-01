<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Plugin Name: Matter Solutions WordPress Enhancements
 * Description: Add simple enhancements for better UX
 * Version: 1.0.0
 * Author: Matter Solutions
 * Author URI: http://www.mattersolutions.com.au
 */




/*
*	Display images in WPadmin
*/

// Add featured image column
function mttr_add_featured_image_admin_columns( $defaults ) {

	$defaults = array( 'featured_image' => 'Image') + $defaults;
    return $defaults;

}
 
// Display the featured image
function mttr_display_featured_image_admin_column( $column_name, $post_ID ) {
    
    if ( $column_name == 'featured_image' ) {

        if ( has_post_thumbnail( $post_ID ) ) {

            echo the_post_thumbnail( 'thumbnail' );
       
        }

    }

}



// Add featured image to the admin columns
add_filter( 'manage_posts_columns', 'mttr_add_featured_image_admin_columns' );
add_action( 'manage_posts_custom_column', 'mttr_display_featured_image_admin_column', 10, 2 );


// Add featured image to pages as well
add_filter('manage_page_posts_columns', 'mttr_add_featured_image_admin_columns', 10);
add_action('manage_page_posts_custom_column', 'mttr_display_featured_image_admin_column', 10, 2);






/**
 * Add the abilty to edit menus as an EDITOR role
 */
$roleObject = get_role( 'editor' );
if ( !$roleObject->has_cap( 'edit_theme_options' ) ) {

    $roleObject->add_cap( 'edit_theme_options' );
    
}




/*
*	Add styling for ACF etc in the admin
*/
add_action( 'admin_enqueue_scripts', 'mttr_add_admin_stylesheets' );
function mttr_add_admin_stylesheets() {

	if ( is_admin() ) {

		$plugin_name = plugin_basename( __FILE__ );

		// ACF stylesheet
		$acf_stylesheet = '/wp-content/plugins/' . plugin_dir_path( $plugin_name ) . 'css/matter-acf-styles.css';
		wp_enqueue_style( 'mttr_acf_styles', $acf_stylesheet, false, '1.0.0' );


		// Column stylesheet
		$acf_stylesheet = '/wp-content/plugins/' . plugin_dir_path( $plugin_name ) . 'css/matter-admin-styles.css';
		wp_enqueue_style( 'mttr_admin_styles', $acf_stylesheet, false, '1.0.0' );


		// Scripts
		$mttr_acf_script = '/wp-content/plugins/' . plugin_dir_path( $plugin_name ) . 'js/enhanced-scripts.js';
		wp_enqueue_script( 'mttr_admin_script', $mttr_acf_script );

	}

}



function mttr_tiny_mce_before_init( $init_array ) {
    $init_array['body_class'] = 'mttr-wysiwyg';
    return $init_array;
}
add_filter('tiny_mce_before_init', 'mttr_tiny_mce_before_init');



/*
*	Populate ACF icon choices
*/
function mttr_acf_load_icons( $field ) {

	$icon_dir = get_stylesheet_directory() . '/assets/img/icons/';
	$icon_arr = glob( $icon_dir . '*.svg' );

	$field[ 'choices' ] = array();

	foreach( $icon_arr as $icon ) {

		$field[ 'choices' ][ esc_attr( basename( $icon ) ) ] = basename( $icon );

	}

    return $field;
    
}

// name
add_filter('acf/load_field/key=mttr_meta_fields_icon', 'mttr_acf_load_icons');

// key
add_filter('acf/load_field/key=mttr_flex_layouts_grid_style_items_icon', 'mttr_acf_load_icons');




/*
*	Populate ACF feature choices
*/
/*
*	Populate ACF feature choices
*/
function mttr_acf_load_features( $field ) {

	if ( function_exists ( 'mttr_get_feature_data_array' ) ) {

		$feature_types = mttr_get_feature_data_array();
		
	    $field[ 'choices' ] = array();

		foreach( $feature_types as $key => $value ) {

			$field[ 'choices' ][ esc_attr( $key ) ] = esc_html( $value[ 'listing_label' ] );

		}

   		return $field;

   	}

   	return false;
    
}

// key
add_filter('acf/load_field/key=field_56f669dc451a7', 'mttr_acf_load_features');