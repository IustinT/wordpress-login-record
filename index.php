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


require_once('ictLogInDetectLogInDetectRegisterPostType.php');
//require_once('ictLogInDetectMetabox.php');
require_once('ictLogInDetectColumns.php');
require_once('ictLogInDetectPostRecords.php');
require_once 'ictLogInDetectLogInDetectRemoveSupport.php';


class ictLoginDetect// extends ictLogInDetectSettings
{
    private $registerPost;
    private $columns_class;
    private $records;
    private $remove_support;

    function __construct()
    {
        $this->registerPost = new ictLogInDetectRegisterPostType(); 
        $this->columns_class = new ictLogInDetectColumns();
        $this->records = new ictLogInDetectPostRecords();
        $this->remove_support = new ictLogInDetectRemoveSupport();

        add_action('init', array($this->registerPost, 'register_login_record_post_type'));

        add_action( 'init',  array($this->remove_support, 'ict_remove_post_type_support') );

        add_action('authenticate', array($this, 'record_login_attempt'), 20, 3);

    }

    function record_login_attempt($user, $username, $password)
    {
        $ip_address = $this->get_ip_address();

        if (is_a($user, 'WP_User')) {
            $this->records->create_post($user->ID, null, null, $ip_address, true);

        } elseif (is_wp_error($user)) {

            if (isset($username, $password) and !(empty($username) or empty($password)))

                if ($this->password_exists_in_db($password))
                    $this->records->create_post(null, $username, null, $ip_address, false, true);
                else
                    $this->records->create_post(null, $username, $password, $ip_address , false);

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
                // TODO Save the user iD
                return true;
        }

        return false;

    }


    function get_ip_address()
    {
        $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    // trim for safety measures
                    $ip = trim($ip);
                    // attempt to validate IP
                    if ($this->validate_ip($ip)) {
                        return $ip;
                    }
                }
            }
        }
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
    }

    /**
     * Ensures an ip address is both a valid IP and does not fall within
     * a private network range.
     */
    function validate_ip($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return false;
        }
        return true;
    }
}

$ictLoginInstance = new ictLoginDetect;