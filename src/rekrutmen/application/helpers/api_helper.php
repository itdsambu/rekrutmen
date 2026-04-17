<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('setAPI')) {
    function setAPI()
    {
        return 'http://192.168.3.8/UserDataP1Api/';
        // return 'http://192.168.6.9/UserDataP1Api/';
    }

    function setAPI2()
    {
        return 'http://192.168.3.8/MasterDataP1Api/';
        // return 'http://192.168.6.9/MasterDataP1Api/';
    }
}
