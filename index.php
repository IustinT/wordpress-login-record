<?php
/*
Plugin Name: Detect LogIn Attempts
Plugin URI: 
Description: 
Version: 1.0
Author: Iustin
Author URI: 
License: 
*/

defined('ABSPATH') or die('Plugin file cannot be accessed directly.');


require_once('register_post_type.php');
require_once('ictLogInDetectMetabox.php');
require_once('ictLogInDetectColumns.php');
require_once('ictLogInDetectPostRecords.php');


class ictLoginDetect// extends ictLogInDetectSettings
{
    private $registerPost;
    private $metabox_class;
    private $columns_class;
    private $records;

    function __construct()
    {
        $this->registerPost = new ictRegisterPostType();
        $this->metabox_class = new ictLogInDetectMetabox();
        $this->columns_class = new ictLogInDetectColumns();
        $this->records = new ictLogInDetectPostRecords();

        add_action('init', array($this->registerPost, 'register_login_record_post_type'));

        add_action('authenticate', array($this, 'record_login_attempt'), 20, 3);

    }

    function record_login_attempt($user, $username, $password)
    {
        if (is_a($user, 'WP_User')) {
            $this->records->create_post($user->ID);

        } elseif (is_wp_error($user)) {

            if (isset($username, $password) and !(empty($username) or empty($password)))

                if ($this->password_exists_in_db($password))
                    $this->records->create_post(null, $username, null, null, false, true);
                else
                    $this->records->create_post(null, $username, $password, null, false);

        } 
        return $user;
    }



    function password_exists_in_db($password)
    {
        global $wpdb;
        $hashed_password = md5($password);

        $results = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->users . " WHERE( user_pass = '" . $hashed_password . "');");

        if ($results > 0)
            return true;

        require_once(ABSPATH . 'wp-includes/class-phpass.php');

        $hasher = new PasswordHash(8, TRUE);

        foreach ($wpdb->get_results("SELECT user_pass FROM " . $wpdb->users . ";") as $key => $row) {

            $check = $hasher->CheckPassword($password, $row->user_pass);

            if ($check)
                return true;
        }

        return false;

    }

}

$ictLoginInstance = new ictLoginDetect;