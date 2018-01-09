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
    $error = "";
    if (isset($_POST['submitEmail'])) {
        if (!$user->setEmail($_SESSION['id'],$_POST['email'])) {
            $error = "Invalid email address format.";
        }
    }
    if (isset($_POST['submitPassword'])) {
        // Check if old password is correct
        if (password_verify($_POST['password-current'], strval($user->getValue($_SESSION['id'],'password')))) {
            // Check if password meets requirements
            if (!(preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $_POST['password-new']))) {
               $error = "Password must have a characters minimum, one upper case letter, one lower case letter, and one digit.";
            } else {
                if ($_POST['password-new'] === $_POST['password-new2']) {
                    // Change password
                    $user->setValue($_SESSION['id'], 'password', password_hash($_POST['password-new'],PASSWORD_DEFAULT));
                } else {
                    $error = "Passwords do not match.";
                }
            }
        } else {
            $error = "Your current password is incorrect.";
        }
        
    }
    $page_name = "Account Settings";
    include ROOT_PATH . '/pages/include/header.php';
    include ROOT_PATH . '/pages/include/navbar.php';
?>
<div class="container">
    <?php if ((isset($_POSt['submitEmail']) || isset($_POST['submitPassword'])) && ($error != "")) { ?>
    <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
    <?php } ?>
    <h2>Change Email</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email Address">
        </div>
        <input type="submit" name="submitEmail" class="btn btn-primary w-100" value="Change Email">
    </form>
    <br>
    <h2>Change Password</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="password">Current Password</label>
            <input type="password" class="form-control" name="password-current" id="password" placeholder="Password">
        </div>
        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" class="form-control" name="password-new" id="password" placeholder="Password">
        </div>
        <div class="form-group">
            <label for="password">Confirm Password</label>
            <input type="password" class="form-control" name="password-new2" id="password" placeholder="Password">
        </div>
        <input type="submit" name="submitPassword" class="btn btn-primary w-100" value="Change Password">
    </form>
</div>
<?php
    include ROOT_PATH . '/pages/include/footer.php';
    include ROOT_PATH . '/pages/include/scripts.php';
?>