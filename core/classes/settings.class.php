<?php
    /*
    * StartPanel
    * (c) BrightSkyz and SirHyperNova 2018
    * Version 0.1
    */
    include ROOT_PATH . '/core/config.php';
    class Settings {
        protected static $sql;
        function __construct ($sql) {
            self::$sql = $sql;
        }
        public function getSetting($name) {
            $fetch = self::$sql->statements->settings->fetchData;
            $fetch->bind_param('s', $name);
            $fetch->execute();
            $result = $fetch->get_result()->fetch_object();
            return $result->value;
        }
        public function getSettingCleanName($name) {
            $fetch = self::$sql->statements->settings->fetchData;
            $fetch->bind_param('s', $name);
            $fetch->execute();
            $result = $fetch->get_result()->fetch_object();
            return $result->cleanName;
        }
        public function getSettingOptions($name) {
            $fetch = self::$sql->statements->settings->fetchData;
            $fetch->bind_param('s', $name);
            $fetch->execute();
            $result = $fetch->get_result()->fetch_object();
            return $result->dropdownOptions;
        }
        public function listAllSettings() {
            $fetch = self::$sql->statements->settings->fetchAllSettings;
            $fetch->execute();
            $rs = $fetch->get_result();
            $rt = [];
            while ($result = $rs->fetch_object()) {
                $rt[]= $result;
            }
            return $rt;
        }
        public function setSetting($name, $value) {
            $set = self::$sql->statements->settings->updateSetting;
            $set->bind_param('ss', $value, $name);
            $set->execute();
            return true;
        }
        public function isDropdown($name) {
            $fetch = self::$sql->statements->settings->fetchData;
            $fetch->bind_param('s', $name);
            $fetch->execute();
            $result = $fetch->get_result()->fetch_object();
            if ($result->isDropdown == 1) {
                return true;
            }
            return false;
        }
}