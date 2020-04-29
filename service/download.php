<?php



	if(empty($_GET['file'])){
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
		exit;
		
	}else{
		$file =$_GET['file'];
		$name =$_GET['name'];
	
			header('Pragma: public');
			//header('HTTP/1.1 206 Partial Content');
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header("Content-Disposition: attachment; filename=\"" . $name . "\"");
			header('Expires: -1');
			header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0");
			
			header('Content-Length: ' .filesize($file));
		
			readfile($file);
			exit;   
			
		}
		//header('Content-Description: File Transfer');
	
	
	

?>