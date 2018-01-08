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
    if ($node->getValue($_GET['id'],'name') == null || $node->getValue($_GET['id'],'name') == "") {
        include ROOT_PATH . '/pages/404.php';
        http_response_code(404);
        die();
    }
    
    if (isset($_POST['submit'])) {
        foreach ($_POST as $key => $part) {
            if ($key == "name" || $key == "ip" || $key == "port" || $key == "username" || $key == "password") {
                $node->setValue($_GET['id'], $key, $part);
            }
        }
    }
    
    $page_name = "Edit Node";
    include ROOT_PATH . '/pages/include/header.php';
    include ROOT_PATH . '/pages/include/navbar.php';
?>

<div class="container">
    <div class="d-flex justify-content-between">
        <div><h1>Edit Node <small><?php echo $node->getValue($_GET['id'], "name"); ?></small></h1></div>
        <form method="post">
            <input type="submit" class="btn btn-primary" name="submit" value="Save">
    </div>
    <hr>
    <div class="row">
        <div class="col-md-3 col-12">
<?php include ROOT_PATH . '/pages/include/adminSidebar.php'; ?>
        </div>
        <div class="col-md-9 col-12">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input required type="text" class="form-control" id="name" name="name" placeholder="Node Name" value="<?php echo $node->getValue($_GET['id'], 'name'); ?>">
                </div>
                <div class="form-group">
                    <label for="ip">IP</label>
                    <input required type="text" class="form-control" id="ip" name="ip" placeholder="IP Address" value="<?php echo $node->getValue($_GET['id'], 'ip'); ?>">
                </div>
                <div class="form-group">
                    <label for="port">Port</label>
                    <input required type="number" class="form-control" id="port" name="port" min="1" max="65535" placeholder="Port for SSH" value="<?php echo $node->getValue($_GET['id'], 'port'); ?>">
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input required type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $node->getValue($_GET['id'], 'username'); ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input required type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo $node->getValue($_GET['id'], 'password'); ?>" >
                </div>
             </form>
        </div>
    </div>
</div>
<?php
    include ROOT_PATH . '/pages/include/footer.php';
    include ROOT_PATH . '/pages/include/scripts.php';
?>