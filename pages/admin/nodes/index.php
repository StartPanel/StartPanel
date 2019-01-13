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
    $page_name = "Node List";
    include ROOT_PATH . '/pages/include/header.php';
    include ROOT_PATH . '/pages/include/navbar.php';
    
    $page = 1;
    if (!isset($_GET['page']) || $_GET['page'] == "") {
        $page = "1";
    } else {
        $page = $_GET['page'];
    }
    if (isset($_GET['delete'])) {
        if ($node->getValue($_GET['id'],'id')) {
            $node->deleteNode($_GET['delete']);
        }
    }
?>

<div class="container">
    <div class="d-flex justify-content-between">
        <div><h1>Node List</h1></div>
        <div>
            <a class="btn btn-primary" href="/admin/nodes/add/">Create Node</a>
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
                        <th scope="col">IP</th>
                        <th scope="col">Status</th>
                        <th scope="col">Manage</th>
                    </tr>
                </thead>
                <tbody>
<?php
    $nodes = $node->listAllNodes((($page * 15) - 15), ($page * 15));
    foreach ($nodes as $key => $nodeID){
        $nodeName = $node->getValue($nodeID, 'name');
        $nodeIP = $node->getValue($nodeID, 'ip');
        $nodePort = $node->getValue($nodeID, 'port');
        $nodeUsername = $node->getValue($nodeID, 'username');
        $nodePassword = $node->getValue($nodeID, 'password');
        $nodeStatus = $node->getStatus($nodeID);
        if ($nodeStatus) {
            $nodeStatus = '<span class="badge badge-success">Online</span>';
        } else {
            $nodeStatus = '<span class="badge badge-danger">Offline</span>';
        }
        if ($node->getStatus($nodeID)) {
            $nodeStatus = '<span class="badge badge-success">Online</span>';
            if (@$node->isSshValid($nodeIP, $nodePort, $nodeUsername, $nodePassword)) {
                $nodeStatus = '<span class="badge badge-success">Online</span>';
            } else {
                $nodeStatus = '<span class="badge badge-warning">Invalid SSH Info</span>';
            }
        } else {
            $nodeStatus = '<span class="badge badge-danger">Offline</span>';
        }
?>
                    <tr>
                        <th><?php echo $nodeName; ?></th>
                        <td><?php echo $nodeIP; ?></td>
                        <td><?php echo $nodeStatus; ?></td>
                        <td><a href="/admin/nodes/edit/?id=<?php echo $nodeID; ?>">(Manage)</a> / <a href="/admin/nodes/delete/?id=<?php echo $nodeID; ?>">(Delete)</a></td>
                    </tr>
<?php } ?>
                </tbody>
            </table>
            <br>
<?php
    $nodes = $node->listAllNodes(1, 999999);
    $numNodes = count($nodes);
    $numPages = ceil($numNodes / 15);
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