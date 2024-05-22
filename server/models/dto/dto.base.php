<?php

abstract class DTO {

	public function get() {
		$reflection = new ReflectionClass($this);
		return $reflection->getProperties();
	}

}

?>
