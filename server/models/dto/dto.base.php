<?php

abstract class DTO {

	protected static function get($class, array $args, ?string $function_name = 'validate') {
		$reflection = new ReflectionMethod($class, $function_name);
		$param_arr = [];
		foreach($reflection->getParameters() as $index => $param) {
			$name = $param->getName();
			$param_arr[$name] = $args[$index];
		};
		return $param_arr;
	}
}

?>
