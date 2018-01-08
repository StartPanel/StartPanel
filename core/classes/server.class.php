<?php
    /*
    * StartPanel
    * (c) BrightSkyz and SirHyperNova 2018
    * Version 0.1
    */

    include ROOT_PATH . '/core/config.php';
    class Server {
        protected static $sql;
        protected $node;
        protected $settings;
        function __construct($sql, $node, $settings) {
            self::$sql = $sql;
            $this->node = $node;
            $this->settings = $settings;
        }
        public function getName($id) {
            $fetch = self::$sql->statements->server->fetchData;
            $fetch->bind_param('i', $id);
            $fetch->execute();
            $result = $fetch->get_result()->fetch_object();
            return $result->name;
        }
        public function getOwner($id) {
            $fetch = self::$sql->statements->server->fetchData;
            $fetch->bind_param('i', $id);
            $fetch->execute();
            $result = $fetch->get_result()->fetch_object();
            return $result->id;
        }
        public function getNode($id) {
            $fetch = self::$sql->statements->server->fetchData;
            $fetch->bind_param('i', $id);
            $fetch->execute();
            $result = $fetch->get_result()->fetch_object();
            return $result->nodeID;
        }
        public function getMaxRAM($id) {
            $fetch = self::$sql->statements->server->fetchData;
            $fetch->bind_param('i', $id);
            $fetch->execute();
            $result = $fetch->get_result()->fetch_object();
            return $result->maxRam;
        }
        public function getIP($id) {
            $fetch = self::$sql->statements->server->fetchData;
            $fetch->bind_param('i', $id);
            $fetch->execute();
            $result = $fetch->get_result()->fetch_object();
            return $result->ip;
        }
        public function getPort($id) {
            $fetch = self::$sql->statements->server->fetchData;
            $fetch->bind_param('i', $id);
            $fetch->execute();
            $result = $fetch->get_result()->fetch_object();
            return $result->port;
        }

        public function setName($id, $name) {
            $set = self::$sql->statements->server->updateName;
            $set->bind_param('si', $name, $id);
            $set->execute();
            return true;
        }
        public function setOwner($id, $userID) {
            $set = self::$sql->statements->server->updateOwner;
            $set->bind_param('ii', $userID, $id);
            $set->execute();
            return true;
        }
        public function setIP($id, $ip) {
            $set = self::$sql->statements->server->updateIP;
            $set->bind_param('si', $ip, $id);
            $set->execute();
            return true;
        }
        public function setPort($id, $port) {
            $set = self::$sql->statements->server->updatePort;
            $set->bind_param('si', $port, $id);
            $set->execute();
            return true;
        }
        public function listServers($userID) {
            $fetch = self::$sql->statements->server->listServers;
            $fetch->bind_param('i', $userID);
            $fetch->execute();
            $rs = $fetch->get_result();
            $rt = [];
            while ($result = $rs->fetch_object()) {
                $rt[]= $result->id;
            }
            return $rt;
        }
        public function listAllServers($min, $max) {
            $fetch = self::$sql->statements->server->listAllServers;
            $fetch->bind_param('ii', $min, $max);
            $fetch->execute();
            $rs = $fetch->get_result();
            $rt = [];
            while ($result = $rs->fetch_object()) {
                $rt[]= $result->id;
            }
            return $rt;
        }

		public function isOnline($id) {
        	$nodeID = $this->getNode($id);
            $nodeInfo = $this->node->getRow($nodeID);
            $ssh = new Net_SSH2($nodeInfo->ip, $nodeInfo->port);
            if (!$ssh->login($nodeInfo->username, $nodeInfo->password)) {
                die('Login failed.');
            }
            $ssh->setTimeout(0.5);
            $out = $ssh->exec('docker exec server'.$id.' mc_status');
            if (strpos($out, 'PID')) {
                return true;
            } else {
                return false;
            }
        }
        public function getStatus($id) {
            $Info = false;
        	$Query = null;
        	try {
        		$Query = new MinecraftPing($this->getIP($id), $this->getPort($id), 1);
        		$Info = $Query->Query();
        		if($Info === false) {
        			$Query->Close();
        			$Query->Connect();
        			$Info = $Query->QueryOldPre17();
        		}
        		return $Info;
        	} catch (MinecraftPingException $e) {
        		$Exception = $e;
        	}
        	if($Query !== null) {
        		$Query->Close();
        	}
        }

        public function createServer($name, $nodeID, $ownerID, $maxRam, $jarFile, $ip, $port) {
            $new = self::$sql->statements->server->new;
            $new->bind_param('siisssi', $name, $nodeID, $ownerID, $maxRam, $jarFile, $ip, $port);
            $new->execute();
            // Fix this
            $nodeInfo = $this->node->getRow($nodeID);
            $ssh = new Net_SSH2($nodeInfo->ip, $nodeInfo->port);
            if (!$ssh->login($nodeInfo->username, $nodeInfo->password)) {
                die('Login failed.');
            }
            $new = self::$sql->statements->server->getNewestServer;
            $new->execute();
            $result = $new->get_result()->fetch_object();
            $cmd_serverID = $result->id;
            $cmd_port = $this->getPort($cmd_serverID);
            $cmd_minRam = $this->settings->getSetting('minRam');
            $cmd_maxRam = $this->getMaxRAM($cmd_serverID);
            $ssh->exec('mkdir /var/servers/server'.$cmd_serverID.';wget https://s3.amazonaws.com/Minecraft.Download/versions/1.12.2/minecraft_server.1.12.2.jar -O /var/servers/server'.$cmd_serverID.'/spigot.jar');
            //$ssh->exec('docker pull nimmis/spigot');
            $ssh->exec("docker run -d -p $cmd_port:25565 --name server$cmd_serverID -v /var/servers/server$cmd_serverID:/minecraft -e MC_MINMEM=".$cmd_minRam."m -e MC_MAXMEM=".$cmd_maxRam."m -e EULA=true nimmis/spigot");
            return true;
        }
        public function deleteServer($id) {
            $nodeID = $this->getNode($id);
            $nodeRow = $this->node->getRow($nodeID);
            echo var_dump($nodeRow);
            $ssh = new Net_SSH2($nodeRow->ip, $nodeRow->port);
            if (!$ssh->login($nodeRow->username, $nodeRow->password)) {
                die('Login failed.');
            }
            $ssh->exec('docker kill server'.$id.'; docker rm server'.$id.'; rm -r /var/servers/server'.$id);
            $delete = self::$sql->statements->server->deleteServer;
            $delete->bind_param('i', $id);
            $delete->execute();
            return true;
        }
}
