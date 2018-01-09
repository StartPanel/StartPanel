<?php
    /*
    * StartPanel
    * (c) BrightSkyz and SirHyperNova 2018
    * Version 0.1
    */
    session_start();
    spl_autoload_register(function($class) {
        if (file_exists(ROOT_PATH . '/core/classes/' . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php'))
        require_once ROOT_PATH . '/core/classes/' . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    });
    $sql = new SQL($db_host, $db_user, $db_pass, $db_name);
    $user = new User($sql);
    $node = new Node($sql);
    $settings = new Settings($sql);
    $server = new Server($sql, $node, $settings);
    
    set_include_path(get_include_path() . PATH_SEPARATOR . ROOT_PATH . '/core/classes/phpseclib');
    include(ROOT_PATH . '/core/classes/phpseclib/Net/SSH2.php');
