<?php

/**
 * User: Iustin
 * Date: 25/10/2015
 * Time: 10:03
 */
class ictLogInDetectPostRecords extends ictLogInDetectSettings
{

    function create_post($user_id = null, $user_name = null, $password = null, $ip=null, $successful=null)
    {
        $post_id = $this->create_new_record();

        if (!(is_null($user_id) || empty($user_id)))
        update_post_meta($post_id, '_detected_user_id', $user_id);

        if (!(is_null($user_name) || empty($user_name)))
            $this->update_record_meta($post_id, '_detected_username', $user_name);

        if (!(is_null($password) || empty($password)))
            $this->update_record_meta($post_id, '_detected_password', $password);

        if (!(is_null($ip) || empty($ip)))
            $this->update_record_meta($post_id, '_detected_ip', $ip);

        if (!(is_null($successful) || empty($successful)))
            $this->update_record_meta($post_id, '_detected_successful', $successful);

    }

    function update_record_meta($post_id, $meta_column, $data)
    {
            update_post_meta($post_id, $meta_column, $data);
    }

    /**
     * function update_record_meta($post_id, $user_id = null, $user_name = null, $password = null)
     * {
     * if($user_id!=null)
     * update_post_meta($post_id, '_detected_user_id', $user_id);
     * }
     **/

    function create_new_record()
    {
        $new_post = array(
            'post_status' => 'publish',
            'post_type' => $this->postType,
  'post_title'    => '',
  'post_content'  => '',
        );

        return  wp_insert_post($new_post);
    }

}