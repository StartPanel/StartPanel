<?php
    /*
    * StartPanel
    * (c) BrightSkyz and SirHyperNova 2018
    * Version 0.1
    */
    class SQL {
        protected static $conn;
        function __construct($dbhost, $dbuser, $dbpass, $dbname) {
            self::$conn = new mysqli($dbhost, $dbuser, $dbpass);
            self::$conn->select_db($dbname);
            $this->statements = new Statements();
        }
    }
    class Statements extends SQL{
        function __construct() {
            $this->user = new UserStatements();
            $this->server = new ServerStatements();
            $this->settings = new SettingsStatements();
            $this->node = new NodeStatements();
        }
    }
    class UserStatements extends SQL {
        function __construct() {
            $this->fetchData = parent::$conn->prepare("SELECT * FROM users WHERE id = ?");
            $this->fetchID = parent::$conn->prepare("SELECT id FROM users WHERE username = ?");
            $this->listAllUsers = parent::$conn->prepare("SELECT id FROM users ORDER BY id ASC LIMIT ? , ?");
            $this->new = parent::$conn->prepare("INSERT INTO `users` (`username`,`password`,`email`,`isAdmin`) VALUES (?,?,?,?)");
            $this->deleteUser = parent::$conn->prepare("DELETE FROM users WHERE id = ?");
            $this->updateEmail = parent::$conn->prepare("UPDATE users SET email = ? WHERE id = ?");
            $this->updatePassword = parent::$conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        }
        public function updateValue($column) {
            $column = parent::$conn->real_escape_string($column);
            return parent::$conn->prepare("UPDATE users SET $column = ? WHERE id = ? ");
        }
    }
    
    class ServerStatements extends SQL {
        function __construct() {
            $this->fetchData = parent::$conn->prepare("SELECT * FROM servers WHERE id = ?");
            $this->listServers = parent::$conn->prepare('SELECT id FROM servers WHERE ownerID = ?');
            
            $this->listAllServers = parent::$conn->prepare("SELECT id FROM servers ORDER BY id ASC LIMIT ? , ?");
            $this->getNewestServer = parent::$conn->prepare("SELECT id FROM servers ORDER BY id DESC LIMIT 1");
            $this->new = parent::$conn->prepare("INSERT INTO `servers` (`name`,`nodeID`,`ownerID`,`maxRam`,`jarFile`,`ip`,`port`) VALUES (?,?,?,?,?,?,?)");
            $this->deleteServer = parent::$conn->prepare("DELETE FROM servers WHERE id = ?");
            $this->updateOwner = parent::$conn->prepare("UPDATE servers SET ownerID = ? WHERE id = ?");
            $this->updateName = parent::$conn->prepare("UPDATE servers SET name = ? WHERE id = ?");
            $this->updateIP = parent::$conn->prepare("UPDATE servers SET ip = ? WHERE id = ?");
            $this->updatePort = parent::$conn->prepare("UPDATE servers SET ip = ? WHERE id = ?");
            $this->updateName = parent::$conn->prepare("UPDATE servers SET port = ? WHERE id = ?");
        }
    }
    
    class SettingsStatements extends SQL {
        function __construct() {
            $this->fetchData = parent::$conn->prepare("SELECT * FROM settings WHERE name = ?");
            $this->fetchAllSettings = parent::$conn->prepare("SELECT name FROM settings WHERE hidden = 0");
            $this->updateSetting = parent::$conn->prepare("UPDATE settings SET value = ? WHERE name = ?");
        }
    }
    class NodeStatements extends SQL {
        function __construct() {
            $this->fetchValue = parent::$conn->prepare("SELECT * FROM nodes WHERE id = ?");
            $this->deleteNode = parent::$conn->prepare("DELETE FROM nodes WHERE id = ?");
            $this->listAllNodes = parent::$conn->prepare("SELECT id FROM nodes ORDER BY id ASC LIMIT ? , ?");
            $this->new = parent::$conn->prepare("INSERT INTO `nodes` (`name`,`ip`,`port`,`username`,`password`) VALUES (?,?,?,?,?)");
        }
        public function updateValue($column) {
            $column = parent::$conn->real_escape_string($column);
            return parent::$conn->prepare("UPDATE nodes SET $column = ? WHERE id = ? ");
        }
    }
    