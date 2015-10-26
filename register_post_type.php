<?php
/**
 * User: Iustin
 * Date: 23/10/2015
 * Time: 23:50
 */
require_once "ictLogInDetectSettings.php";


 class ictRegisterPostType extends ictLogInDetectSettings
{
     function __construct(){}

// Register Custom Post Type
  public  function register_login_record_post_type()
    {

        $labels = array(
            'name' => _x('Log In Records', 'Post Type General Name', 'ict_login_records'),
            'singular_name' => _x('Log In Records', 'Post Type Singular Name', 'ict_login_records'),
            'menu_name' => __('Log In History', 'ict_login_records'),
            'name_admin_bar' => __('Log In History', 'ict_login_records'),
            'parent_item_colon' => __('Parent Record:', 'ict_login_records'),
            'all_items' => __('All Records', 'ict_login_records'),
            'add_new_item' => __('Add New Record', 'ict_login_records'),
            'add_new' => __('Add New', 'ict_login_records'),
            'new_item' => __('New Item', 'ict_login_records'),
            'edit_item' => __('Edit Item', 'ict_login_records'),
            'update_item' => __('Update Item', 'ict_login_records'),
            'view_item' => __('View Item', 'ict_login_records'),
            'search_items' => __('Search Item', 'ict_login_records'),
            'not_found' => __('Not found', 'ict_login_records'),
            'not_found_in_trash' => __('Not found in Trash', 'ict_login_records'),
        );
        $args = array(
            'label' => __('Log In Records', 'ict_login_records'),
            'description' => __('Records of login on site', 'ict_login_records'),
            'labels' => $labels,
            'supports' => array('comments',),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 10,
            'menu_icon' => 'dashicons-admin-network',
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'capability_type' => 'post',
        );
        register_post_type($this->postType, $args);

    }
}