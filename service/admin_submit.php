<?php
// admin_submit


// getting the IDcode , grade variables from form

// checks the grade in some range OR can be done in HTML

// updating the database row matching the IDcode provided

//

function validate_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


$idcode = $grade = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if(empty($_POST["IDcode"])){
		$npcodeErr = "ID code is required";
	}else{
		$idcode = validate_input($_POST["NeptunCode"]));
	}
	if(empty($_POST["Grade"])){
		$nameErr = "Grade is required";
	}else{
	
		$grade= validate_input($_POST["Grade"]);
		
}


function validate_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


?>