<!DOCTYPE html>
<html>
    <head>
        <title><?php if (!isset($page_name)) { echo "Untitled"; } else { echo $page_name; } ?> &bull; <?php echo $settings->getSetting("site_name"); ?></title>
        <link rel="stylesheet" href="/assets/css/bootstrap.css">
<?php
    $bootstrapTheme = $settings->getSetting("bs_theme");
    if ($bootstrapTheme != "default") {
?>
        <link rel="stylesheet" href="https://bootswatch.com/4/<?php echo $bootstrapTheme; ?>/bootstrap.min.css">
<?php } ?>
        <link rel="stylesheet" href="/assets/css/custom.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
