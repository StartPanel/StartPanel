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
    if ($user->getValue($_GET['id'], 'username') == null || $user->getValue($_GET['id'], 'username') == "") {
        include ROOT_PATH . '/pages/404.php';
        http_response_code(404);
        die();
    }
    
    $error = "";
    if (isset($_POST['submit'])) {
        foreach ($_POST as $key => $part) {
            if ($key == "username" || $key == "password" || $key == "email" || $key == "isAdmin") {
                if ($key == "password" && $_POST['password'] == "") {
                    // don't change password
                } else if ($key == "password" && $_POST['password'] != "") {
                    if (!(preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $_POST['password']))) {
                       $error = "Password must have 8 characters minimum, one upper case letter, one lower case letter, and one digit.";
                    }
                    $user->setValue($_GET['id'], $key, password_hash($_POST['password'], PASSWORD_DEFAULT));
                } else if ($key == "isAdmin") {
                    $isAdmin = "0";
                    if ($_POST['isAdmin'] == "1") {
                        $isAdmin = "1";
                    } else {
                        $isAdmin = "0";
                    }
                    $user->setValue($_GET['id'], $key, $isAdmin);
                } else if ($key == " email") {
                    if (!filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) {
                        $error .= " Please provide a valid email.";
                    } else {
                        $user->setValue($_GET['id'], $key, $_POST['email']);
                    }
                } else {
                    $user->setValue($_GET['id'], $key, htmlspecialchars($part));
                }
            }
        }
    }
    
    $page_name = "Edit User";
    include ROOT_PATH . '/pages/include/header.php';
    include ROOT_PATH . '/pages/include/navbar.php';
?>

<div class="container">
    <div class="d-flex justify-content-between">
        <div><h1>Edit Node <small><?php echo $user->getValue($_GET['id'], "username"); ?></small></h1></div>
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
                    <label for="username">Username</label>
                    <input required type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $user->getValue($_GET['id'], 'username'); ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input required type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $user->getValue($_GET['id'], 'email'); ?>">
                </div>
                <div class="form-check">
                    <input type="hidden" name="isAdmin" value="0">
                    <input type="checkbox" class="form-check-input" id="isAdmin" name="isAdmin" value="1" <?php if ($user->getValue($_GET['id'], 'isAdmin') == "1") { echo 'checked'; } ?>>
                    <label class="form-check-label" for="isAdmin">Is the user an admin?</label>
                </div>
             </form>
        </div>
    </div>
</div>
<?php
    include ROOT_PATH . '/pages/include/footer.php';
    include ROOT_PATH . '/pages/include/scripts.php';
?>