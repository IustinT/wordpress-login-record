<?php

/**
 * User: Iustin
 * Date: 25/10/2015
 * Time: 10:03
 */
class ictLogInDetectPostRecords extends ictLogInDetectSettings
{

    function create_post($user_id = null,
                         $user_name = null, $password = null,
                         $ip = null, $successful = false,
                         $existing_password = false)
    {
        $post_id = $this->create_new_record();
        if (isset($user_id))
            update_post_meta($post_id, '_detected_user_id', $user_id);

        if (isset($user_name) and !empty($user_name))
            update_post_meta($post_id, '_detected_username', $user_name);

        if (isset($password) and !empty($password))
            update_post_meta($post_id, '_detected_password', $password);

        if (isset($ip))
            update_post_meta($post_id, '_detected_ip', $ip);

        if ($successful)
            update_post_meta($post_id, '_detected_successful', $successful);


        if ($existing_password) {
            update_post_meta($post_id, '_detected_existing_password', 'true');
        }

    }


    function create_new_record()
    {
        $new_post = array(
            'post_status' => 'publish',
            'post_type' => $this->postType,
            'post_title' => '',
            'post_content' => '',
        );

        return wp_insert_post($new_post);
    }

}