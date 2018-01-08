<?php
    /*
    * StartPanel
    * (c) BrightSkyz and SirHyperNova 2018
    * Version 0.1
    */
    if (!isset($_SESSION['id']) || !$user->isAdmin($_SESSION['id'])) {
        header('Location: /account/login/');
        die();
    }
    
    if (isset($_POST['submit'])) {/*($name, $ownerID <- you need to get from username specified in $_POST['owner'], $nodeid, $ip, $port, $maxRam, $jarFile)*/
        if (!$user->getID($_POST['owner'])) {
            $error .= "Owner user does not exist.";
        }
        if (!$node->getValue($_POST['node'], 'id')) {
            $error .= " Node does not exist.";
        }
        if ($_POST['maxRam'] > $settings->getSetting('maxRam') || $_POST['maxRam'] < $settings->getSetting('minRam')) {
            $error .= " The ram option must be a minimum of {$settings->getSetting('minRam')} MB and a maximum of {$settings->getSetting('maxRam')} MB.";
        }
        if (!ip2long($_POST['ip']) && !ip2long(gethostbyname($_POST['ip'].'.'))) {
            $error .= " Please provide a valid IP address or domain name.";
        }
        if ($_POST['port'] < 1 || $_POST['port'] > 65535) {
            $error .= " Please provide a valid port (1-65535)";
        }
        $error = trim($error);
        if (!strlen($error)) {
            $server->createServer(htmlspecialchars($_POST['name']), $_POST['node'], $user->getID($_POST['owner']), $_POST['maxRam'], 'spigot.jar', $_POST['ip'], $_POST['port']);
            header('Location: /admin/servers/');
            die();
        }
    }
    
    $page_name = "Create Server";
    include ROOT_PATH . '/pages/include/header.php';
    include ROOT_PATH . '/pages/include/navbar.php';
?>

<div class="container">
    <div class="d-flex justify-content-between">
        <div><h1>Create Server</h1></div>
        <form method="post">
            <input type="submit" class="btn btn-primary" name="submit" value="Save">
    </div>
    <hr>
    <div class="row">
        <div class="col-md-3 col-12">
<?php include ROOT_PATH . '/pages/include/adminSidebar.php'; ?>
        </div>
        <div class="col-md-9 col-12">
<?php if (isset($error) && ($error != "")) { ?>
                <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
<?php } ?>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input required type="text" class="form-control" id="name" name="name" placeholder="Server Name">
                </div>
                <div class="form-group">
                    <label for="node">Node</label>
                    <select required class="form-control" id="node" name="node">
<?php
    $nodes = $node->listAllNodes(0, 9999);
    foreach ($nodes as $key => $nodeID){
        $nodeName = $node->getValue($nodeID, 'name');
        $nodeIP = $node->getValue($nodeID, 'ip');
        $nodePort = $node->getValue($nodeID, 'port');
        $nodeUsername = $node->getValue($nodeID, 'username');
        $nodePassword = $node->getValue($nodeID, 'password');
        $nodeStatus = $node->getStatus($nodeID);
        if ($nodeStatus) {
            //online
            if ($node->isSshValid($nodeIP, $nodePort, $nodeUsername, $nodePassword)) {
                //online + ssh info works
?>
                        <option value="<?php echo $nodeID;?>"><?php echo $nodeName . ' (' . $nodeIP . ')'; ?></option>
<?php
            } else {
                //invalid ssh info
            }
        } else {
            //offline
        }
    }
?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ip">IP</label>
                    <input required type="text" class="form-control" id="ip" name="ip" placeholder="IP Address">
                </div>
                <div class="form-group">
                    <label for="owner">Owner</label>
                    <input required type="text" class="form-control" id="owner" name="owner" placeholder="Owner's Username">
                </div>
                <div class="form-group">
                    <label for="port">Port</label>
                    <input required type="number" class="form-control" id="port" name="port" min="1" max="65535" placeholder="Server Port">
                </div>
                <div class="form-group">
                    <label for="username">Max RAM (In MB, only specify number.)</label>
                    <input required type="number" class="form-control" id="maxram" name="maxRam" min="<?php echo $settings->getSetting('minRam'); ?>" max="<?php echo $settings->getSetting('maxRam'); ?>" placeholder="Max Ram">
                </div>
                <div class="form-group">
                    <label for="jarFile">Server Jar</label>
                    <input required type="text" class="form-control" id="jarFile" name="jarFile" placeholder="Server Jar File" value="spigot.jar" disabled>
                </div>
             </form>
        </div>
    </div>
</div>
<?php
    include ROOT_PATH . '/pages/include/footer.php';
    include ROOT_PATH . '/pages/include/scripts.php';
?>