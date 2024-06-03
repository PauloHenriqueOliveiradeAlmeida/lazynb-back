<?php

require_once __DIR__ . "/../../../shared/database/connection.php";

class Amenity
{
    private readonly string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function create()
    {
        $connection = new Connection();
        $query = $connection->queryDB(
            "INSERT INTO amenities (name) VALUES (?)",
            [$this->name]
        );
        return $query;
    }

    public static function findByName($name)
    {
        $connection = new Connection();
        $query = $connection->queryDB(
            "SELECT * FROM amenities WHERE name = ?",
            [$name]
        );
        return $query->fetch_assoc();
    }

    public static function getLastInsertId()
    {
        $connection = new Connection();
        return $connection->getLastInsertId();
    }

	public static function addAmenityToProperty($propertyId, $amenityId)
    {
        $connection = new Connection();
        $query = $connection->queryDB(
            "INSERT INTO properties_amenities (propertyId, amenityId) VALUES (?, ?)",
            [$propertyId, $amenityId]
        );
        return $query;
    }
}
?>
