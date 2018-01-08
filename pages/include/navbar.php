        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="/"><?php echo $settings->getSetting("site_name"); ?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link <?php if (!strcasecmp($page_name,'Servers')) { echo 'active'; } ?>" href="/">Servers</a></li>
                    </ul>
                    <ul class="navbar-nav">
<?php if (!isset($_SESSION['id'])) { ?>
                        <li class="nav-item"><a class="nav-link <?php if (!strcasecmp($page_name,'Login')) { echo 'active'; } ?>" href="/account/login/">Login</a></li>
<?php } else { ?>
<?php if ($user->isAdmin($_SESSION['id'])) { ?>
                        <li class="nav-item"><a class="nav-link <?php if (!strcasecmp($page_name,'Admin')) { echo 'active'; } ?>" href="/admin/">Admin</a></li>
<?php } ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $user->getValue($_SESSION['id'],'username'); ?></a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/account/">Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/account/logout/">Logout</a>
                            </div>
                        </li>
<?php } ?>
                    </ul>
                </div>
            </nav>
        </header>
        <main>
        <br>
