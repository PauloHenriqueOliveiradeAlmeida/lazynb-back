<?php 

namespace App\Api\Shared\Database;

use MongoDB\Client;
use MongoDB\Database;
use MongoDB\Driver\Exception\Exception as MongoDBException;

class MongoDBConnection
{
	private static ?Database $db = null;

	public static function getDatabase(): ?Database
	{
		if (self::$db === null) {
			$uri = getenv("MONGODB_URI");

			try {
				$client = new Client($uri);
				self::$db = $client->selectDatabase(getenv("MONGODB_DATABASE"));
				$client->selectDatabase(getenv("MONGODB_DATABASE"))->command(['ping' => 1]);
			} catch (MongoDBException $e) {
				error_log("Erro ao conectar ao MongoDB: " . $e->getMessage());
				self::$db = null;
			}
		}
		return self::$db;
	}
}
