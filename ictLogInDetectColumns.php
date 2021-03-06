<?php

/**
 * User: Iustin
 * Date: 25/10/2015
 * Time: 09:46
 */
class ictLogInDetColumns extends ictLogInDetectSettings
{

    function __construct()
    {

        add_filter('manage_edit-loginrecord_columns', array($this, 'add_table_columns'));

        add_action('manage_loginrecord_posts_custom_column', array($this, 'output_table_columns_data'), 10, 2);

    }

// 'Title' => __('Title')
// 'comments' => __('Comments')
    function add_table_columns($columns)
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            '_detected_username' => __('Username'),
            '_detected_password' => __('Password'),
            '_detected_ip' => __('IP Address'),
            '_detected_successful' => __('Logged In'),
            'date' => __('Date and Time')
        );

        return $columns;
    }

    function output_table_columns_data($columnName, $post_id)
    {
        //$field = get_field($columnName, $post_id);
        $echo_flag = true;

        $field = get_post_meta($post_id, $columnName, true);

        if ('_detected_username' == $columnName)
            if (empty($field))
                $id = get_post_meta($post_id, '_detected_user_id', true);
        if (!empty($id))
            $field = get_userdata($id)->user_login;


        if ('_detected_successful' == $columnName)
            if (empty($field))
                $field = 'No';
            else
                $field = 'Yes';

        if ('_detected_password' == $columnName)
            if (empty($field))
                $field = 'Not Recorded';


        echo $field;
    }
}