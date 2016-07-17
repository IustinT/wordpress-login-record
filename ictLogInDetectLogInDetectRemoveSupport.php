<?php

/**
 * Created by PhpStorm.
 * User: Iustin
 * Date: 17/07/2016
 * Time: 19:56
 */
require_once 'ictLogInDetectSettings.php';

class ictLogInDetectRemoveSupport extends ictLogInDetectSettings
{
    function __construct(){

    }

    function ict_remove_post_type_support() {
        remove_post_type_support( $this->postType, 'title' );
    }
}