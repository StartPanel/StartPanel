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
    if ($server->getOwner($_GET['id'])!=$_SESSION['id'] && !$user->isAdmin($_SESSION['id'])) {
        header('Location: /');
        die();
    }
    if ($server->getName($_GET['id']) == null || $server->getName($_GET['id']) == "") {
        include ROOT_PATH . '/pages/404.php';
        http_response_code(404);
        die();
    }
    if (isset($_POST['delete'])) {
        $server->deleteServer($_GET['id']);
        header('Location: /admin/servers/');
        die();
    }
    if (isset($_POST['cancel'])) {
        header('Location: /admin/servers/');
        die();
    }
    $page_name = "Delete Server";
    include ROOT_PATH . '/pages/include/header.php';
    include ROOT_PATH . '/pages/include/navbar.php';
?>

<div class="container">
    <div class="d-flex justify-content-between">
        <div><h1>Delete Server</h1></div>
        <form method="post">
            <input type="submit" class="btn btn-secondary" name="cancel" value="Cancel">
            <input type="submit" class="btn btn-danger" name="delete" value="Delete">
        </form>
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
            <div class="text-center">Are you sure you want to delete the server <span class="font-weight-bold"><?php echo $server->getName($_GET['id']); ?></span> and its files?<br><br>
            This action is <span class="font-weight-bold">permanent</span> and you cannot recover the files.</div>
        </div>
    </div>
</div>
<?php
    include ROOT_PATH . '/pages/include/footer.php';
    include ROOT_PATH . '/pages/include/scripts.php';
?>