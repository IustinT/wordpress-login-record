<?php

/**
 * User: Iustin
 * Date: 25/10/2015
 * Time: 09:41
 */
class ictLogInDetectMetabox extends ictLogInDetectSettings
{

    function __construct()
    {

        add_action('add_meta_boxes', array($this, 'register_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
    }

    function register_meta_boxes()
    {
        add_meta_box('login-record-details', 'Login Record Details', array($this, 'output_meta_box'), $this->postType, 'normal', 'high');
    }

    function output_meta_box($post)
    {

        $detected_username = get_post_meta($post->ID, '_detected_username', true);
        $detected_password = get_post_meta($post->ID, '_detected_password', true);
        $detected_time = get_the_time(null, $post);
        $detected_ip = get_post_meta($post->ID, '_detected_ip', true);
        $detected_successful = get_post_meta($post->ID, '_detected_successful', true);

        if (empty($detected_username))
            $id = get_post_meta($post->ID, '_detected_user_id', true);
        if (!empty($id))
            $detected_username = get_userdata($id)->user_login;


        if (empty($detected_successful))
            $detected_successful = false;

        // Add a nonce field so we can check for it later.
        wp_nonce_field('save_login_records_nonce', 'login_records_nonce');

        // Output label and field
        echo('<label for="detected_username">' . __('Username ', $this->nameSpace) . '</label>');
        echo('<input type="text" name="detected_username" id="detected_username" value="' . esc_attr($detected_username) . '" /><BR>');

        // Output label and field
        echo('<label for="detected_password">' . __('Password ', $this->nameSpace) . '</label>');
        echo('<input type="text" name="detected_password" id="detected_password" value="' . esc_attr($detected_password) . '" /><BR>');

        // Output label and field
        echo('<label for="detected_time">' . __('Date Time ', $this->nameSpace) . '</label>');
        echo('<input type="text" name="detected_time" id="detected_time" value="' . esc_attr($detected_time) . '" /><BR>');

        // Output label and field
        echo('<label for="detected_ip">' . __('IP ', $this->nameSpace) . '</label>');
        echo('<input type="text" name="detected_ip" id="detected_ip" value="' . esc_attr($detected_ip) . '" /><br>');

        // Output label and field
        echo('<label for="detected_successful">' . __('Allowed ', $this->nameSpace) . '</label>');
        echo('<input type="text" name="detected_successful" id="detected_successful" value="' . esc_attr($detected_successful) . '" /><br>');

    }

    function save_meta_boxes($post_id)
    {

        // Check if our nonce is set.
        if (!isset($_POST['login_records_nonce'])) {
            return $post_id;
        }


        // Verify that the nonce is valid.
        if (!wp_verify_nonce($_POST['login_records_nonce'], 'save_login_records_nonce')) {
            return $post_id;
        }


        // Check this is the Contact Custom Post Type
        if ($this->postType != $_POST['post_type']) {
            return $post_id;
        }

        // Check the logged in user has permission to edit this post
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        // OK to save meta data
        $username = sanitize_text_field($_POST['detected_username']);
        update_post_meta($post_id, '_detected_username', $username);

        // OK to save meta data
        $detected_password = sanitize_text_field($_POST['detected_password']);
        update_post_meta($post_id, '_detected_password', $detected_password);

        // OK to save meta data
        $detected_ip = sanitize_text_field($_POST['detected_ip']);
        update_post_meta($post_id, '_detected_ip', $detected_ip);

    }


}