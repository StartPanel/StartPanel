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
    if ($server->getOwner($_GET['id'])!=$_SESSION['id'] && !$user->isAdmin($_SESSION['id'])) {
        header('Location: /');
        die();
    }
    if ($server->getName($_GET['id']) == null || $server->getName($_GET['id']) == "") {
        include ROOT_PATH . '/pages/404.php';
        http_response_code(404);
        die();
    }
    $page_name = "Console";
    include ROOT_PATH . '/pages/include/header.php';
    include ROOT_PATH . '/pages/include/navbar.php';
?>
<div class="container">
    
    <div class="d-flex justify-content-between">
        <div><h1>Console <small><?php echo $server->getName($_GET['id']); ?></small></h1></div>
        <div>
            <button type="button" id="startBtn" onClick="submitQuickCmd('start')" class="btn btn-success">Start</button>
            <button type="button" id="stopBtn" onClick="submitQuickCmd('stop')" class="btn btn-danger">Stop</button>
            <button type="button" id="restartBtn" onClick="submitQuickCmd('restart')" class="btn btn-warning">Restart</button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-3 col-12">
            <nav class="nav nav-pills flex-column w-100">
                <a class="nav-item nav-link" href="/server/config/?id=<?php echo $_GET['id'] ?>">Configuration</a>
                <a class="nav-item nav-link active" href="/server/?id=<?php echo $_GET['id'] ?>">Console</a>
                <a class="nav-item nav-link" href="/server/files/?id=<?php echo $_GET['id'] ?>">Files</a>
                <a class="nav-item nav-link disabled" href="#a">MySQL</a>
            </nav>
            <br>
        </div>
        <div class="col-md-9 col-12">
            <style type="text/css">
                .console {
                    background: #000;
                    color: #fff;
                    display: block;
                    width: 100%;
                    height: 400px;
                    padding: 4px; 
                    border-radius: 3px;
                    overflow: auto;
                    overflow-x: hidden !important;
                }
                .console-no-select-text {
                    -webkit-touch-callout: none;
                    -webkit-user-select: none;
                    -khtml-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    user-select: none;
                }
            </style>
            <samp id="consoleDisplay" class="console console-no-select-text">Loading console...
            </samp>
            <br>
            <div class="input-group">
                <input type="text" class="form-control" id="commandInput" onkeypress="enterCheck(event)">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button" id="commandSubmit">Execute</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include ROOT_PATH . '/pages/include/scripts.php';
?>

<script>
    /* Elements */
    var consoleDisplay = document.getElementById("consoleDisplay");
    var commandInput = document.getElementById("commandInput");
    var commandSubmit = document.getElementById("commandSubmit");
    var firstLoad = true;
    var runConsole = setInterval(function() {
        /* Update Console */
        $.get("/server/rawconsole/?id=<?php echo $_GET['id']; ?>", {}, function(data) {
            consoleDisplay.innerHTML = data;
            if (firstLoad == true) {
                firstLoad = false;
                consoleDisplay.scrollTop = consoleDisplay.scrollHeight;
            }
        });
        /* Check Scroll */
        var isScrolledToBottom = consoleDisplay.scrollHeight - consoleDisplay.clientHeight <= consoleDisplay.scrollTop + 10;
        if (isScrolledToBottom) {
            consoleDisplay.scrollTop = consoleDisplay.scrollHeight - consoleDisplay.clientHeight;
        }
    }, 250);
    function submitCmd() {
        var cmd = commandInput.value;
        commandInput.disabled = true;
        commandSubmit.disabled = true;
        $.post("/server/sendcmd/?id=<?php echo $_GET['id']; ?>", {command: cmd}, function(result) {
            commandInput.value = "";
            commandInput.disabled = false;
            commandSubmit.disabled = false;
            consoleDisplay.scrollTop = consoleDisplay.scrollHeight;
        });
    }
    commandSubmit.addEventListener("click", submitCmd);
    
    function submitQuickCmd(cmd) {
        $.post("/server/quickcmd/?id=<?php echo $_GET['id']; ?>", {command: cmd});
    }
    function enterCheck(event) {
        if (event.which == 13 || event.keyCode == 13) {
            submitCmd();
            return;
        }
        return;
    }
</script>
<?php
    include ROOT_PATH . '/pages/include/footer.php';
?>