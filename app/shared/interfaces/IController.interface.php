<?php

interface IController {
	public static function create(array $data);

	public static function getAll();

	public static function getById($id);

	public static function update($id, array $data);

	public static function delete($id);
}
