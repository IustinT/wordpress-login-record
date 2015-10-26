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
            // if (isset($_POST['wp-submit']))
            if (isset($username,$password))

                $this->records->create_post(null, $username, $password, null, "0");

        } else $this->records->create_post(get_class($user));

        return $user;
    }
}

$ictLoginInstance = new ictLoginDetect;