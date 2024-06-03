<?php

class RandomPassword {
	public static function generate() {
		$bytes = openssl_random_pseudo_bytes(4);

		return bin2hex($bytes);
	}
}
