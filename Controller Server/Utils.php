<?php

class Utils {
	static public function get_string_between($string, $start, $end) {

	    $string = ' ' . $string;
	    $ini = strpos($string, $start);
	    if ($ini == 0) return '';
	    $ini += strlen($start);
	    $len = strpos($string, $end, $ini) - $ini;
	    return substr($string, $ini, $len);

	}

	static public function explodeEveryNth($delimiter, $string, $n) {

	    $arr = explode($delimiter, $string);
	    $arr2 = array_chunk($arr, $n);
	    $out = array();

	    for ($i = 0, $t = count($arr2); $i < $t; $i++) {
	        $out[] = implode($delimiter, $arr2[$i]);
    	}

    	return $out;
	}
}


?>
