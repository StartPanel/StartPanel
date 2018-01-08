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
    if (!$user->isAdmin($_SESSION['id'])) {
        header('Location: /');
        die();
    }
    if ($_SESSION['id'] == $_GET['id'] || $_GET['id'] == 1) {
        header('Location: /admin/users/');
        die();
    }
    if ($user->getValue($_GET['id'], 'username') == null || $user->getValue($_GET['id'], 'username') == "") {
        include ROOT_PATH . '/pages/404.php';
        http_response_code(404);
        die();
    }
    if (isset($_POST['delete'])) {
        $user->deleteUser($_GET['id']);
        header('Location: /admin/users/');
        die();
    }
    if (isset($_POST['cancel'])) {
        header('Location: /admin/users/');
        die();
    }
    $page_name = "Delete User";
    include ROOT_PATH . '/pages/include/header.php';
    include ROOT_PATH . '/pages/include/navbar.php';
?>

<div class="container">
    <div class="d-flex justify-content-between">
        <div><h1>Delete User</h1></div>
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
            <div class="text-center">Are you sure you want to delete the user <span class="font-weight-bold"><?php echo htmlspecialchars($user->getValue($_GET['id'], 'username')); ?></span>?<br><br>
            This action is <span class="font-weight-bold">permanent</span>.</div>
        </div>
    </div>
</div>
<?php
    include ROOT_PATH . '/pages/include/footer.php';
    include ROOT_PATH . '/pages/include/scripts.php';
?>