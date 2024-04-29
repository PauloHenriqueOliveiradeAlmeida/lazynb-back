
<?php

function requestIsEmpty(array $request){
	foreach($request as $info){
		if (!isset($info)){
			return true;
		}
	}
	return false;
}

?>
