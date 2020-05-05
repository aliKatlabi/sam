<?php

// utiles : contains global variables and useful functions  

include 'connection_info.php';

function admin_logger($message){
	echo "<span> <span id='pep'>+</span>  ".$message." <span> <br> ";

}

function validate_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function RandomToken($length){
    if(!isset($length) || intval($length) <= 3 ){
      $length = 6;
    }
    if (function_exists('random_bytes')) {
        return bin2hex(random_bytes($length));
    }
    if (function_exists('mcrypt_create_iv')) {
        return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
    }
    if (function_exists('openssl_random_pseudo_bytes')) {
        return bin2hex(openssl_random_pseudo_bytes($length));
    }
}

function exist($table , $column , $value){
	
	$conn = new mysqli($GLOBALS['servername'],$GLOBALS['username'] ,$GLOBALS['password'],$GLOBALS['dbname']);
	
	$result = $conn->query("SELECT * FROM {$table} WHERE {$column} = {$value}");
	if($result->num_rows == 0) {
		 return false;
	} else {
		return true;
	}
	$conn->close();
}
function Salt(){
    return substr(strtr(base64_encode(hex2bin(RandomToken(32))), '+', '.'), 0, 44);
}


?>