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
    $page_name = "Servers";
    include ROOT_PATH . '/pages/include/header.php';
    include ROOT_PATH . '/pages/include/navbar.php';
?>
<div class="container">
    <div><h1>Servers <small>View your servers.</small></h1></div>
    <hr>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Players</th>
                <th scope="col">RAM</th>
                <th scope="col">Manage</th>
            </tr>
        </thead>
        <tbody>
<?php
    $servers = $server->listServers($_SESSION['id']);
    foreach ($server->listServers($_SESSION['id']) as $serverID){
        $playerCount = $maxPlayerCount = 0;
        $serverName = $server->getName($serverID);
        if (true) {
            $playerCount = $server->getStatus($serverID)["players"]["online"];
            $maxPlayerCount = $server->getStatus($serverID)["players"]["max"];;
        } else {
            $playerCount = "0";
            $maxPlayerCount = "0";
        }
?>
            <tr>
                <th><?php echo $serverName; ?></th>
                <td><?php echo '(' . $playerCount . '/' . $maxPlayerCount . ')'; ?></td>
                <td><?php echo $server->getMaxRam($serverID); ?></td>
                <td><a href="/server/?id=<?php echo $serverID; ?>">(Console)</a> / <a href="/server/files/?id=<?php echo $serverID; ?>">(Files)</a></td>
            </tr>
<?php } ?>
        </tbody>
    </table>
</div>
<?php
    include ROOT_PATH . '/pages/include/footer.php';
    include ROOT_PATH . '/pages/include/scripts.php';
?>