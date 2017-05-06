<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('session.cookie_httponly', 1);

return array(
    'URL' => 'http://' . $_SERVER['HTTP_HOST'] . str_replace('public', '', dirname($_SERVER['SCRIPT_NAME'])),

    'PATH_CONTROLLER' => realpath(dirname(__FILE__).'/../../') . '/application/controller/',
    'PATH_VIEW' => realpath(dirname(__FILE__).'/../../') . '/application/view/',
 
    'DEFAULT_CONTROLLER' => 'index',
    'DEFAULT_ACTION' => 'index',

    'DB_TYPE' => 'mysql',
    'DB_HOST' => '127.0.0.1',
    'DB_NAME' => 'voting',
    'DB_USER' => 'root',
    'DB_PASS' => '',
    'DB_PORT' => '3306',
    'DB_CHARSET' => 'utf8',

    'COOKIE_RUNTIME' => 1209600,
    'COOKIE_PATH' => '/',
    'COOKIE_DOMAIN' => "",
    'COOKIE_SECURE' => false,
    'COOKIE_HTTP' => true,
    'SESSION_RUNTIME' => 604800,

    'ENCRYPTION_KEY' => '6#x0gÊìf^25cL1f$08&',
    'HMAC_SALT' => '8qk9c^4L6d#15tM8z7n0%',
);