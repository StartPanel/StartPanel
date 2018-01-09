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
    
    if (isset($_POST['submit'])) {
        if (strlen($_POST['username']) < 2  || strlen($_POST['username']) > 16) {
            $error .= " Username must be at or more than 2 characters and less than or equal to 16 characters.";
        }
        if (!filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) {
            $error .= " Please provide a valid email.";
        }
        if ($_POST['password'] != $_POST['password2']) {
            $error .= " The passwords do not match.";
        }
        if (!(preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $_POST['password']))) {
           $error = "Password must have 8 characters minimum, one upper case letter, one lower case letter, and one digit.";
        } else {
            $user->setValue($_SESSION['id'], 'password', password_hash($_POST['password'], PASSWORD_DEFAULT));
        }
        $isAdmin = "0";
        if ($_POST['isAdmin'] == "true") {
            $isAdmin = "1";
        } else {
            $isAdmin = "0";
        }
        $error = trim($error);
        if (!strlen($error) > 0) {
            $user->addUser(htmlspecialchars($_POST['username']), $_POST['password'], $_POST['email'], $isAdmin);
            header('Location: /admin/users/');
            die();
        }
    }
    
    $page_name = "Create User";
    include ROOT_PATH . '/pages/include/header.php';
    include ROOT_PATH . '/pages/include/navbar.php';
?>

<div class="container">
    <div class="d-flex justify-content-between">
        <div><h1>Create User</h1></div>
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
                    <input required type="text" class="form-control" id="username" name="username" placeholder="Username" value="">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input required type="email" class="form-control" id="email" name="email" placeholder="Email" value="">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input required type="password" class="form-control" id="password" name="password" placeholder="Password" value="">
                </div>
                <div class="form-group">
                    <label for="password2">Confirm Password</label>
                    <input required type="password" class="form-control" id="password2" name="password2" placeholder="Confirm Password" value="">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="isAdmin" name="isAdmin" value="true">
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