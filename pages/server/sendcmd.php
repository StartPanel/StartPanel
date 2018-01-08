<?php
    /*
    * StartPanel
    * (c) BrightSkyz and SirHyperNova 2018
    * Version 0.1
    */
    if (!isset($_SESSION['id'])) {
        header('Location: /account/login/');
        die();
    }
    if ($server->getOwner($_GET['id'])!=$_SESSION['id'] && !$user->isAdmin($_SESSION['id'])) {
        header('Location: /');
        die();
    }
    if ($server->getName($_GET['id']) == null || $server->getName($_GET['id']) == "") {
        include ROOT_PATH . '/pages/404.php';
        http_response_code(404);
        die();
    }
    if ($server->isOnline($_GET['id'])) {
        $nodeID = $server->getNode($_GET['id']);
        $nodeInfo = $node->getRow($nodeID);
        $ssh = new Net_SSH2($nodeInfo->ip, $nodeInfo->port);
        if (!$ssh->login($nodeInfo->username, $nodeInfo->password)) {
            die('Login failed.');
        }
        $ssh->setTimeout(0.5);
        $ssh->exec('docker exec server'.$_GET['id'].' mc_send "'.htmlspecialchars($_POST['command']).'"');
    } else {
        return;
    }
?>