<?php


namespace App\Api\Modules\Auth\Entity;

use App\Api\Modules\Auth\Dtos\UserCodeDto;
use App\Api\Shared\Database\Connection;

class UserCodeEntity
{
	public function __construct(
		private readonly Connection $connection = new Connection()
	) {}

	public function create(string $verification_code, int $user_id)
	{
		return $this->connection->query(
			"INSERT INTO user_code (verification_code, user_id) VALUES (:verification_code, :user_id)",
			[
				'verification_code' => $verification_code,
				'user_id' => $user_id
			]
		);
	}

	/** @return UserCodeDto */
	public function selectByUserId(int $id)
	{
		$userCode = $this->connection->query(
			"SELECT id, verification_code, user_id FROM user_code WHERE user_id = :id",
			['id' => $id]
		);

		return (object) $userCode[0];
	}

	public function delete(int $id)
	{
		return $this->connection->query("DELETE FROM user_code WHERE id = :id", ['id' => $id]);
	}

	public function update(string $verification_code, int $user_id)
	{
		return $this->connection->query(
			"UPDATE user_code SET verification_code = :verification_code WHERE user_id = :user_id",
			[
				'verification_code' => $verification_code,
				'user_id' => $user_id
			]
		);
	}

	public function upsert(string $verification_code, int $user_id)
	{
		return $this->connection->query(
			"INSERT INTO user_code (verification_code, user_id) VALUES (:verification_code, :user_id)
			ON CONFLICT (user_id) DO UPDATE SET verification_code = :verification_code",
			['verification_code' => $verification_code, 'user_id' => $user_id]
		);
	}
}
