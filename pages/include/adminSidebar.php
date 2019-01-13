            <nav class="nav nav-pills flex-column w-100">
                <a class="nav-item nav-link<?php if (isset(explode("/", $_GET['path'])[1]) && explode("/", $_GET['path'])[1] == "") { echo ' active'; } ?>" href="/admin/">Main</a>
                <a class="nav-item nav-link<?php if (isset(explode("/", $_GET['path'])[1]) && explode("/", $_GET['path'])[1] == "nodes") { echo ' active'; } ?>" href="/admin/nodes/">Nodes</a>
                <a class="nav-item nav-link<?php if (isset(explode("/", $_GET['path'])[1]) && explode("/", $_GET['path'])[1] == "servers") { echo ' active'; } ?>" href="/admin/servers/">Servers</a>
                <a class="nav-item nav-link<?php if (isset(explode("/", $_GET['path'])[1]) && explode("/", $_GET['path'])[1] == "users") { echo ' active'; } ?>" href="/admin/users/">Users</a>
            </nav>
            <br>