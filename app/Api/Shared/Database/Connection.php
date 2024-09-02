<?php

namespace App\Api\Shared\Database;

require_once 'serverconfig.php';

class Connection
{
	protected \mysqli $connectionDB;
	public $id_inserted;
	private function connectDB()
	{
		$this->connectionDB = new \mysqli(server, user, password, db, port);
		if ($this->connectionDB->connect_errno) {
			echo "Failed connection" . $this->connectionDB->connect_errno;
			exit();
		} else {
			return $this->connectionDB;
		};
	}

	private function closeDB()
	{
		$this->connectionDB->close();
	}


	public function queryDB(string $sql, array $params = [])
	{
		$this->connectDB();
		$result = false;
		$connection = $this->connectDB();
		$stmt = $connection->prepare($sql);
		$stmt->execute($params);
		$result = $stmt->get_result();
		$this->id_inserted = $connection->insert_id;
		$this->closeDB();
		return $result;
	}

	public function getLastInsertId() {
		return $this->id_inserted;
	}
}
