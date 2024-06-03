<?php

require_once 'serverconfig.php';

class Connection
{
	private readonly mysqli $connectionDB;
	private function connectDB()
	{
		$this->connectionDB = new mysqli(server, user, password, db, port);
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
		$result = false;
		$connection = $this->connectDB();

		$stmt = $connection->prepare($sql);
		$stmt->execute($params);
		$result = $stmt->get_result();
		$this->closeDB();
		return $result;
	}
}
