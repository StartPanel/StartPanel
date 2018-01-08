<?php
    /*
    * StartPanel
    * (c) BrightSkyz and SirHyperNova 2018
    * Version 0.1
    */
    if (isset($_SESSION['id'])) header('Location: /');
    if (isset($_POST['submit'])) {
        if ($user->login($_POST['username'], $_POST['password'])) {
            // Login successful, do login action
            $_SESSION['id'] = $user->getID($_POST['username']);
            header('Location: /');
            die();
        } else {
            $error = "The username/password combination is incorrect.";
        }
    }
    
    $page_name = "Login";
    include ROOT_PATH . '/pages/include/header.php';
    include ROOT_PATH . '/pages/include/navbar.php';
?>
<div class="row">
    <!--<div class="col-4"></div>-->
    <div class="col-10 offset-1 col-md-4 offset-md-4">
        <h1 class="text-center">Login</h1>
        <form method="POST" action="">
            <?php if (isset($error) && ($error != "")) { ?>
            <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
            <?php } ?>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
          </div>
          <button type="submit" class="btn btn-primary w-100" name="submit">Login</button>
        </form>
    </div>
</div>
<?php
    include ROOT_PATH . '/pages/include/footer.php';
    include ROOT_PATH . '/pages/include/scripts.php';
?>