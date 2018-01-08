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
    $page_name = "Admin";
    include ROOT_PATH . '/pages/include/header.php';
    include ROOT_PATH . '/pages/include/navbar.php';
    
    if (isset($_POST['site_name'])) {
        $settings->setSetting("site_name", $_POST['settingValue']);
        header('Location: /admin/');
        die();
    }
    if (isset($_POST['bs_theme'])) {
        $settings->setSetting("bs_theme", $_POST['settingValue']);
        header('Location: /admin/');
        die();
    }
    if (isset($_POST['maxRam'])) {
        $settings->setSetting("maxRam", $_POST['settingValue']);
        header('Location: /admin/');
        die();
    }
?>
<div class="container">
    <div class="d-flex justify-content-between">
        <div><h1>Admin</h1></div>
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
                        <th scope="col">Value</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
<?php
    $settingsl = $settings->listAllSettings();
    foreach ($settingsl as $key => $name) {
        $settingCleanName = $settings->getSettingCleanName($name->name);
        $settingValue = $settings->getSetting($name->name);
        if ($settings->isDropdown($name->name)) {
?>
                <th><?php echo $settingCleanName; ?></th>
                <td>
                    <form method="POST">
                        <div class="form-group">
                            <select class="form-control" name="settingValue">
<?php
            $options = $settings->getSettingOptions($name->name);
            $options = explode('&', $options);
            foreach ($options as $opt) {
?>
                                <option value="<?php echo $opt; ?>"<?php if ($settingValue == $opt) { echo ' selected'; } ?>><?php echo $opt; ?></option>
<?php
            }
?>
                            </select>
                        </div>
                </td>
                <td><button type="submit" name="<?php echo $name->name; ?>" class="btn btn-primary">Change</button></form></td>
<?php
        } else {
?>
                    <tr>
                        <th><?php echo $settingCleanName; ?></th>
                        <td>
                            <form method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="settingValue" value="<?php echo $settingValue; ?>" placeholder="Value">
                                </div>
                        </td>
                        <td><button type="submit" name="<?php echo $name->name; ?>" class="btn btn-primary">Change</button></form></td>
                    </tr>
<?php
        }
    }
?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
    include ROOT_PATH . '/pages/include/footer.php';
    include ROOT_PATH . '/pages/include/scripts.php';
?>