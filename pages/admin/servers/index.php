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
    $page_name = "Server List";
    include ROOT_PATH . '/pages/include/header.php';
    include ROOT_PATH . '/pages/include/navbar.php';
    
    $page = 1;
    if (!isset($_GET['page']) || $_GET['page'] == "") {
        $page = "1";
    } else {
        $page = $_GET['page'];
    }
?>

<div class="container">
    <div class="d-flex justify-content-between">
        <div><h1>Server List</h1></div>
        <div>
            <a class="btn btn-primary" href="/admin/servers/add/">Create Server</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-3 col-12">
<?php include ROOT_PATH . '/pages/include/adminSidebar.php'; ?>
        </div>
        <div class="col-md-9 col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">RAM</th>
                        <th scope="col">Manage</th>
                    </tr>
                </thead>
                <tbody>
<?php
    // (($_GET['page'] * 15) - 15), ($_GET['page'] * 15)
    $servers = $server->listAllServers((($page * 15) - 15), ($page * 15));
    foreach ($servers as $key => $serverID){
        $serverName = $server->getName($serverID);
        $serverRam = $server->getMaxRam($serverID);
?>
                    <tr>
                        <th><?php echo $serverName; ?></th>
                        <td><?php echo $serverRam; ?></td>
                        <td><a href="/server/?id=<?php echo $serverID; ?>">(Console)</a> / <a href="/server/files/?id=<?php echo $serverID; ?>">(Files)</a> / <a href="/admin/servers/delete/?id=<?php echo $serverID; ?>">(Delete)</a></td>
                    </tr>
<?php } ?>
                </tbody>
            </table>
            <br>
<?php
    $servers = $server->listAllServers(1, 999999);
    $numServers = count($servers);
    $numPages = ceil($numServers / 15);
?>
            <nav>
                <ul class="pagination justify-content-center">
<?php if (($page - 1) == 1) { ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a></li>
<?php } ?>
<?php if (($page - 3) == 1) { ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 3; ?>"><?php echo $page - 3; ?></a></li>
<?php } ?>
<?php if (($page - 2) == 1) { ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 2; ?>"><?php echo $page - 2; ?></a></li>
<?php } ?>
<?php if (($page - 1) == 1) { ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>"><?php echo $page - 1; ?></a></li>
<?php } ?>
                    <li class="page-item active"><a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a></li>
<?php if (($page + 1) == $numPages) { ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>"><?php echo $page + 1; ?></a></li>
<?php } ?>
<?php if (($page + 2) == $numPages) { ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>"><?php echo $page + 2; ?></a></li>
<?php } ?>
<?php if (($page + 3) == $numPages) { ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>"><?php echo $page + 3; ?></a></li>
<?php } ?>
<?php if (($page + 1) == $numPages) { ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">Next></a></li>
<?php } ?>
                </ul>
            </nav>
        </div>
    </div>
</div>
<?php
    include ROOT_PATH . '/pages/include/footer.php';
    include ROOT_PATH . '/pages/include/scripts.php';
?>