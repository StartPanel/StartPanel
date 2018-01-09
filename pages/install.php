<?php if (file_exists(ROOT_PATH . "/core/install.lock"))  { die("The installer is blocked by the file /core/install.lock"); } ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Install &bull; StartPanel</title>
        <link rel="stylesheet" href="/assets/css/bootstrap.css">
        <link rel="stylesheet" href="/assets/css/custom.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <main>
            <br>
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item<?php if (!(strlen($_GET['page']) > 0)) {echo ' active';} ?>">Getting Started</li>
                        <li class="breadcrumb-item<?php if ($_GET['page'] == 'db_info') {echo ' active';} ?>">Database Information</li>
                        <li class="breadcrumb-item<?php if ($_GET['page'] == 'db_setup') {echo ' active';} ?>">Database Setup</li>
                    </ol>
                </nav>
                <hr>
<?php if ($_GET['page'] == "") { ?>
                <h1>StartPanel Install</h1>
                <p>
                    StartPanel, the simple, sleek, and powerful Minecraft server management panel. Instead of 
                    paying for an expensive panel that is hard to configure, go for a panel that is free and open 
                    source, but also easy to setup.
                </p>
                <br>
                <a class="btn btn-primary" href="?page=db_info">Continue</a>
<?php } else if ($_GET['page'] == "db_info") { ?>
                <h1>Database Information</h1>
                <form method="POST" action="?page=db_setup">
                    <div class="form-group">
                        <label>Database Host</label>
                        <input required type="text" class="form-control" name="db_host" placeholder="Database Host">
                    </div>
                    <div class="form-group">
                        <label>Database Username</label>
                        <input required type="text" class="form-control" name="db_user" placeholder="Database Username">
                    </div>
                    <div class="form-group">
                        <label>Database Password</label>
                        <input type="password" class="form-control" name="db_pass" placeholder="Database Password">
                    </div>
                    <div class="form-group">
                        <label>Database Name</label>
                        <input required type="text" class="form-control" name="db_name" placeholder="Database Name">
                    </div>
                    <input type="submit" class="btn btn-primary" name="submit" value="Submit" />
                    <a class="btn btn-secondary" href="?page=">Back</a>
                </form>
<?php } else if ($_GET['page'] == "db_setup") { ?>
                <h1>Database Information</h1>
                <p>
<?php
    $filename = ROOT_PATH . '/core/StartPanelDatabase.sql';
    $mysql_host = $_POST['db_host'];
    $mysql_username = $_POST['db_user'];
    $mysql_password = $_POST['db_pass'];
    $mysql_database = $_POST['db_name'];
    
    echo "Starting import of StartPanelDatabase.sql...<br>";
    
    $conn = mysqli_connect($mysql_host, $mysql_username, $mysql_password) or die("Invalid MySQL database information.");
    mysqli_select_db($conn, $mysql_database) or die("Invalid MySQL database name.");
    
    $templine = '';
    $lines = file($filename);
    foreach ($lines as $line) {
        if (substr($line, 0, 2) == '--' || $line == '') {
            continue;
        }
        $templine .= $line;
        if (substr(trim($line), -1, 1) == ';') {
            mysqli_query($conn, $templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error() . '<br><br>');
            $templine = '';
        }
    }
    echo "Tables imported successfully.<br><br>";
    echo "You can now login to StartPanel with the following information:<br>
    <strong>Username:</strong> Administrator<br>
    <strong>Password:</strong> password<br>
    ";
    

    file_put_contents(ROOT_PATH . "/core/install.lock", "This file blocks access to the installer.");
    file_put_contents(ROOT_PATH . "/core/config.php", '<?php
    $db_host = "'.htmlspecialchars($mysql_host).'";
    $db_user = "'.htmlspecialchars($mysql_username).'";
    $db_pass = "'.htmlspecialchars($mysql_password).'";
    $db_name = "'.htmlspecialchars($mysql_database).'";
');
?>
                    <a class="btn btn-primary" href="/account/login/">Go to login.</a>
                </p>
<?php } ?>
            </div>
            <br>
        </main>
        <footer class="footer">
            <div class="container">
                <span class="float-right">&copy; <?php echo date('Y'); ?> <a href="https://github.com/StartPanel/StartPanel">StartPanel</a></span>
            </div>
        </footer>
    </body>
</html>