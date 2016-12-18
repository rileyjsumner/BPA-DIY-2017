<?php
session_start();

$_SESSION['config'] = array(
    
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expire' => 60 * 60 * 24 * 30
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    )
);

spl_autoload_register(
    function($class){
        require_once 'classes/'.$class.'.php';
});
