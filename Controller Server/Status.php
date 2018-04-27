<?php

/*
 ███╗   ███╗██╗███████╗ ██████╗
 ████╗ ████║██║██╔════╝██╔════╝
 ██╔████╔██║██║███████╗██║
 ██║╚██╔╝██║██║╚════██║██║
 ██║ ╚═╝ ██║██║███████║╚██████╗
 ╚═╝     ╚═╝╚═╝╚══════╝ ╚═════╝
*/

class Status {
	static public function returnStatus($message) {
		$hype = new stdClass();
		$hype->status = $message;
		$myJSON = json_encode($hype);
		echo $myJSON;
	}
}

?>
