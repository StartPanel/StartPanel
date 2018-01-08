<?php
    /*
    * StartPanel
    * (c) BrightSkyz and SirHyperNova 2018
    * Version 0.1
    */
	
    include ROOT_PATH . '/core/config.php';
    class Node {
        protected static $sql;
        function __construct ($sql) {
            self::$sql = $sql;
        }
        public function getValue($id, $column) {
            $fetch = self::$sql->statements->node->fetchValue;
            $fetch->bind_param('i', $id);
            $fetch->execute();
            $result = $fetch->get_result()->fetch_object();
            return $result->{$column};
        }
        public function getRow($id) {
            $fetch = self::$sql->statements->node->fetchValue;
            $fetch->bind_param('i', $id);
            $fetch->execute();
            $result = $fetch->get_result()->fetch_object();
            return $result;
        }
        public function setValue($id, $column, $value) {
            $set = self::$sql->statements->node->updateValue($column);
            $set->bind_param('si', $value, $id);
            $set->execute();
            return true;
        }
        public function addNode($name, $ip, $port, $username, $password) {
            $new = self::$sql->statements->node->new;
            $new->bind_param('sssss', $name, $ip, $port, $username, $password);
            $new->execute();
            return true;
        }
        public function deleteNode($id) {
            $delete = self::$sql->statements->node->deleteNode;
            $delete->bind_param('i', $id);
            $delete->execute();
            return true;
        }
        public function listAllNodes($min, $max) {
            $fetch = self::$sql->statements->node->listAllNodes;
            $fetch->bind_param('ii', $min, $max);
            $fetch->execute();
            $rs = $fetch->get_result();
            $rt = [];
            while ($result = $rs->fetch_object()) {
                $rt[]= $result->id;
            }
            return $rt;
        }
        /*
        $ssh = new Net_SSH2('dev.sirhypernova.net');
        if (!$ssh->login("root", "DevelopmentVPS!")) {
            die('Login failed.');
        }
        */
        public function isSshValid($ip, $port, $username, $password) {
            $ssh = new Net_SSH2($ip, $port);
            if (!$ssh->login($username, $password)) {
                return false;
            } else {
                return true;
            }
        }
        public function getStatus($id) {
            $ip = $this->getValue($id, "ip");
            $port = $this->getValue($id, "port");
            $timeout = 1; 
            if($fp = @fsockopen($ip, $port, $errorCode, $errorString, $timeout)){
                return true;
            } else {
                return false;
            } 
            fclose($fp);
        }
    }