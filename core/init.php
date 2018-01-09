<?php
    /*
    * StartPanel
    * (c) BrightSkyz and SirHyperNova 2018
    * Version 0.1
    */
    session_start();
    include ROOT_PATH . '/core/config.php';
    include ROOT_PATH . '/core/classes/minecraftping.class.php';
    include ROOT_PATH . '/core/classes/settings.class.php';
    include ROOT_PATH . '/core/classes/user.class.php';
    include ROOT_PATH . '/core/classes/server.class.php';
    include ROOT_PATH . '/core/classes/node.class.php';
    include ROOT_PATH . '/core/classes/sql.class.php';
    $sql = new SQL($db_host, $db_user, $db_pass, $db_name);
    $user = new User($sql);
    $node = new Node($sql);
    $settings = new Settings($sql);
    $server = new Server($sql, $node, $settings);
    
    set_include_path(get_include_path() . PATH_SEPARATOR . ROOT_PATH . '/core/classes/phpseclib');
    include(ROOT_PATH . '/core/classes/phpseclib/Net/SSH2.php');