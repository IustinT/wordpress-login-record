<?php
/**
 * User: Iustin
 * Date: 23/10/2015
 * Time: 23:50
 */
require_once "ictLogInDetectSettings.php";


 class ictLogInDetectRegisterPostType extends ictLogInDetectSettings
{
     function __construct(){}

// Register Custom Post Type
    function register_login_record_post_type() {

        $labels = array(
            'name'                  => _x( 'Log In Records', 'Post Type General Name', 'ict_login_records' ),
            'singular_name'         => _x( 'Log In Records', 'Post Type Singular Name', 'ict_login_records' ),
            'menu_name'             => __( 'Log In History', 'ict_login_records' ),
            'name_admin_bar'        => __( 'Log In History', 'ict_login_records' ),
            'archives'              => __( 'Item Archives', 'ict_login_records' ),
            'parent_item_colon'     => __( 'Parent Record:', 'ict_login_records' ),
            'all_items'             => __( 'All Records', 'ict_login_records' ),
            'add_new_item'          => __( 'Add New Record', 'ict_login_records' ),
            'add_new'               => __( 'Add New', 'ict_login_records' ),
            'new_item'              => __( 'New Record', 'ict_login_records' ),
            'edit_item'             => __( 'Edit Record', 'ict_login_records' ),
            'update_item'           => __( 'Update Record', 'ict_login_records' ),
            'view_item'             => __( 'View Record', 'ict_login_records' ),
            'search_items'          => __( 'Search Record', 'ict_login_records' ),
            'not_found'             => __( 'Not found', 'ict_login_records' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'ict_login_records' ),
            'featured_image'        => __( 'Featured Image', 'ict_login_records' ),
            'set_featured_image'    => __( 'Set featured image', 'ict_login_records' ),
            'remove_featured_image' => __( 'Remove featured image', 'ict_login_records' ),
            'use_featured_image'    => __( 'Use as featured image', 'ict_login_records' ),
            'insert_into_item'      => __( 'Insert into record', 'ict_login_records' ),
            'uploaded_to_this_item' => __( 'Uploaded to this recordd', 'ict_login_records' ),
            'items_list'            => __( 'Records list', 'ict_login_records' ),
            'items_list_navigation' => __( 'Records list navigation', 'ict_login_records' ),
            'filter_items_list'     => __( 'Filter records list', 'ict_login_records' ),
        );

        $args = array(
            'label'                 => __( 'Log In Records', 'ict_login_records' ),
            'description'           => __( 'Records of login on site', 'ict_login_records' ),
            'labels'                => $labels,
            'supports'              => false,
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 100,
            'menu_icon'             => 'dashicons-admin-network',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => true,
            'publicly_queryable'    => false, 
        );
        register_post_type( 'loginRecord', $args );

    }
}