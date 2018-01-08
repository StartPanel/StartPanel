<?php
    /*
    * StartPanel
    * (c) BrightSkyz and SirHyperNova 2018
    * Version 0.1
    */
    $debug = false;
    define("ROOT_PATH", realpath(dirname(__FILE__)));
    
    if ($debug == true) {
        echo "Base directory path: " . ROOT_PATH;
    }
    include ROOT_PATH . '/core/config.php';
    if (!file_exists(ROOT_PATH . '/core/install.lock')) {
        include ROOT_PATH . '/pages/install.php';
    } else {
        include ROOT_PATH . '/core/init.php';
        if (!isset($_GET['path']) || $_GET['path'] == "") {
            include ROOT_PATH . '/pages/index.php';
        } else {
            if (file_exists(ROOT_PATH . '/pages/' . htmlspecialchars($_GET['path']) . '.php')) {
                include ROOT_PATH . '/pages/' . htmlspecialchars($_GET['path']) . '.php';
            } else {
                if (file_exists(ROOT_PATH . '/pages/' . htmlspecialchars($_GET['path']) . '/index.php')) {
                    include ROOT_PATH . '/pages/' . htmlspecialchars($_GET['path']) . '/index.php';
                } else {
                    include ROOT_PATH . '/pages/404.php';
                }
            }
        }
    }