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
	
    $page_name = "PHP Info";
    include ROOT_PATH . '/pages/include/header.php';
    include ROOT_PATH . '/pages/include/navbar.php';
?>
<div class="container">
    <div class="d-flex justify-content-between">
        <div><h1>PHP Info <small class="lead"><a href="/admin/">(Back)</a></small></h1></div>
    </div>
    <hr>
	<iframe src="/admin/phpinfo-raw/" width="100%" height="500vh"></iframe>
</div>
<?php
    include ROOT_PATH . '/pages/include/footer.php';
    include ROOT_PATH . '/pages/include/scripts.php';
?>