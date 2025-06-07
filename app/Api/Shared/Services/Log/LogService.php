<?php

namespace App\Api\Shared\Services\Log;

use MongoDB\Database;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Driver\Exception\Exception as MongoDBException;

class LogService
{
    private ?Database $db;

    public function __construct(?Database $db)
    {
        $this->db = $db;
    }

    public function logClientCreation(string $nome, string $email): bool
    {
        if ($this->db === null) {
            error_log("LogService: MongoDB connection is not available. Client log was not possible.");
            return false;
        }

        try {
            $collection = $this->db->selectCollection(getenv("MONGODB_COLLECTION")); 

            $logEntry = [
                'data_criacao' => new UTCDateTime(),
                'nome_criado'  => $nome,
                'email_criado' => $email,
                'ip_cliente'   => $_SERVER['REMOTE_ADDR'] ?? 'N/A'
            ];

            $result = $collection->insertOne($logEntry);

            return $result->getInsertedCount() > 0;

        } catch (MongoDBException $e) {
            error_log("LogService: Error on inserting the log: " . $e->getMessage());
            return false;
        }
    }

	public function logClientDelete(string $client_id): bool
    {
        if ($this->db === null) {
            error_log("LogService: MongoDB connection is not available. Client log was not possible.");
            return false;
        }

        try {
            $collection = $this->db->selectCollection(getenv("MONGODB_COLLECTION")); 

            $logEntry = [
                'data_remocao' => new UTCDateTime(),
                'id_deletado' => $client_id,
                'ip_cliente'   => $_SERVER['REMOTE_ADDR'] ?? 'N/A'
            ];

            $result = $collection->insertOne($logEntry);

            return $result->getInsertedCount() > 0;

        } catch (MongoDBException $e) {
            error_log("LogService: Error on inserting the log: " . $e->getMessage());
            return false;
        }
    }

	public function logPropertyCreation(string $name, string $cep, string $city, string $uf): bool
    {
        if ($this->db === null) {
            error_log("LogService: MongoDB connection is not available. Client log was not possible.");
            return false;
        }

        try {
            $collection = $this->db->selectCollection(getenv("MONGODB_COLLECTION")); 

            $logEntry = [
                'data_criacao' => new UTCDateTime(),
                'nome_criado'  => $name,
				'cep_criado'   => $cep,
				'cidade_criada'=> $city,
                'uf_criado'    => $uf,
                'ip_cliente'   => $_SERVER['REMOTE_ADDR'] ?? 'N/A'
            ];

            $result = $collection->insertOne($logEntry);

            return $result->getInsertedCount() > 0;

        } catch (MongoDBException $e) {
            error_log("LogService: Error on inserting the log: " . $e->getMessage());
            return false;
        }
    }
}