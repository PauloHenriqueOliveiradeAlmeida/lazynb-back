<?php

namespace App\Api\Shared\Database;

use PDO;
use PDOException;
use Raven\Falcon\Http\Exceptions\ServiceUnavailableException;

class Connection
{
	private ?PDO $connection;
	public int $lastInsertedId;

	private function connect()
	{
		try {
			$this->connection = !isset($this->connection) ? new PDO(
				"pgsql:host=" . getenv('DATABASE_SERVER') . ";port=" . getenv('DATABASE_PORT') . ";dbname=" . getenv('DATABASE_NAME') . ";",
				getenv("DATABASE_USER"),
				getenv("DATABASE_PASSWORD")
			) : $this->connection;
		} catch (PDOException $exception) {
			throw new ServiceUnavailableException("Unable to open database connection due to [ {$exception->getMessage()} ]");
		}
	}

	private function close()
	{
		$this->connection = null;
	}


	public function query(string $sql, array $params = [])
	{
		$this->connect();
		$query = $this->connection->prepare($sql);
		$query->execute($params);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		if (str_contains($sql, "INSERT"))
			$this->lastInsertedId = $this->connection->lastInsertId() ?? $this->lastInsertedId;

		$this->close();

		return $result;
	}
}
