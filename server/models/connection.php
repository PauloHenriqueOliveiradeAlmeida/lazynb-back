<?php

require_once 'serverconfig.php';

class Connection extends ServerConfig{
	protected mysqli $connectionDB;
	public function connectDB(){
		$this->connectionDB = new mysqli($this->server, $this->user, $this->password, $this->db, $this->port);
		if ($this->connectionDB -> connect_errno){
			echo "Failed connection". $this->connectionDB -> connect_errno;
			exit();
		}
		else{
			return $this->connectionDB;
		};
	}

	public function closeDB(){
		$this->connectionDB->close();
	}

	public function queryDB(string $sql,array $params = []){
		$connection = $this->connectDB();

		$stmt = $connection->prepare($sql);
		$stmt->execute($params);
		$this->closeDB();
		return $stmt;

	}

}
?>
