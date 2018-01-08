<?php
    /*
    * StartPanel
    * (c) BrightSkyz and SirHyperNova 2018
    * Version 0.1
    */
    include ROOT_PATH . '/core/config.php';
    class User {
        protected static $sql;
        function __construct ($sql) {
            self::$sql = $sql;
        }
        public function getID($username) {
            $fetch = self::$sql->statements->user->fetchID;
            $fetch->bind_param('s', $username);
            $fetch->execute();
            $result = $fetch->get_result()->fetch_object();
            $id = $result->id;
            return $id;
        }
        public function getUsername($id) {
            $fetch = self::$sql->statements->user->fetchData;
            $fetch->bind_param('i', $id);
            $fetch->execute();
            $result = $fetch->get_result()->fetch_object();
            return $result->username;
        }
        public function getPassword($id) {
            $fetch = self::$sql->statements->user->fetchData;
            $fetch->bind_param('i', $id);
            $fetch->execute();
            $result = $fetch->get_result()->fetch_object();
            return $result->password;
        }
        public function getEmail($id) {
            $fetch = self::$sql->statements->user->fetchData;
            $fetch->bind_param('i', $id);
            $fetch->execute();
            $result = $fetch->get_result()->fetch_object();
            return $result->email;
        }
        public function getValue($id, $column) {
            $fetch = self::$sql->statements->user->fetchData;
            $fetch->bind_param('i', $id);
            $fetch->execute();
            $result = $fetch->get_result()->fetch_object();
            return $result->{$column};
        }
        public function setValue($id, $column, $value) {
            $set = self::$sql->statements->user->updateValue($column);
            $set->bind_param('si', $value, $id);
            $set->execute();
            return true;
        }
        public function setEmail($id, $email) {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
            $set = self::$sql->statements->user->updateEmail;
            $set->bind_param('si', $email, $id);
            $set->execute();
            return true;
        }
        public function setPassword($id, $password) {
            $set = self::$sql->statements->user->updatePassword;
            $set->bind_param('si', password_hash($password, PASSWORD_DEFAULT), $id);
            $set->execute();
            return true;
        }
        public function isAdmin($id) {
            $fetch = self::$sql->statements->user->fetchData;
            $fetch->bind_param('i', $id);
            $fetch->execute();
            $result = $fetch->get_result()->fetch_object();
            if ($result->isAdmin == "1") {
                return true;
            }
            return false;
        }
        public function listAllUsers($min, $max) {
            $fetch = self::$sql->statements->user->listAllUsers;
            $fetch->bind_param('ii', $min, $max);
            $fetch->execute();
            $rs = $fetch->get_result();
            $rt = [];
            while ($result = $rs->fetch_object()) {
                $rt[]= $result->id;
            }
            return $rt;
        }
        public function addUser($username, $password, $email, $isAdmin) {
            $new = self::$sql->statements->user->new;
            $new->bind_param('ssss', $username, password_hash($password, PASSWORD_DEFAULT), $email, $isAdmin);
            $new->execute();
            return true;
        }
        public function deleteUser($id) {
            $delete = self::$sql->statements->user->deleteUser;
            $delete->bind_param('i', $id);
            $delete->execute();
            return true;
        }
        
        public function login($username, $password) {
            $id = $this->getID($username);
            $hashedPassword = $this->getValue($id, 'password');
            return password_verify($password, strval($hashedPassword));
        }
}