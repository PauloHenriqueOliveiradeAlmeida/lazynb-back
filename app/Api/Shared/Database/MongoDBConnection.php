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
			$uri =
				"mongodb+srv://".getenv("MONGODB_USER").":".getenv("MONGODB_PASSWORD")."@lazynb.dfr3v7a.mongodb.net/?retryWrites=true&w=majority&appName=lazynb";

			try {
				$client = new Client($uri);
				self::$db = $client->selectDatabase("lazynb");
				$client->selectDatabase('lazynb')->command(['ping' => 1]);
			} catch (MongoDBException $e) {
				error_log("Erro ao conectar ao MongoDB: " . $e->getMessage());
				self::$db = null;
			}
		}
		return self::$db;
	}
}
