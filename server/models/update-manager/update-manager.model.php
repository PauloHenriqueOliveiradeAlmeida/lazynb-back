<?php

class UpdateManager {
	public static function updateValuesFrom(array $old_data, array $new_data) {
		foreach ($new_data as $index => $data) {
			if (isset($data) && $data !== $old_data[$index]) {
				$old_data[$index] = $data;
			}
		}

		return $old_data;
	}
}
