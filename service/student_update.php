<?php

include 'student_update_utiles.php';



$servername = "mysql.caesar.elte.hu";
$username = "alikatlabi";
$password = "WimgnHENWgITEhxr";
$dbname = "alikatlabi";


// collected through form : NeptunCode , name
// using post method 


// creating new row instence

 
$row = new Row();


/// uploading file 

$target_dir = "/afs/elte.hu/user/a/alikatlabi/web/Thesis_project/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


//$_FILES["fileToUpload"]["tmp_name"]

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["file"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($FileType != "pdf" ) {
    echo "Sorry, only pdf files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file

} else {
		
        //echo "The file ". basename($_FILES["file"]["name"]). " has been uploaded.";
		if (isset($_FILES["file"]["name"])) 
		{
			$file_ =  file_get_contents($_FILES["file"]["tmp_name"]);
			
			//echo $file_;
			/*
			$tmpname = $_FILES['file']['tmp_name'];
			if(move_uploaded_file($tmpname, $target_file)){
				
			}else{
			
				echo  $_FILES['file']['tmp_name'];
				
				echo "not upload";
			}*/
			
		}
 }


////


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if(empty($_POST["NeptunCode"])){
		$npcodeErr = "Neptun Code is required";
	}else{
		$row->set_NPCode(validate_input($_POST["NeptunCode"]));
	}
	if(empty($_POST["name"])){
		$nameErr = "name is required";
	}else{
	
		$row->set_name(validate_input($_POST["name"]));
		
}
	
	$row->set_IDCode("23asqwe123");
	$row->set_date_(date("Y-m-d"));
	$row->set_time_(date("h:i:s"));

}


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

	
/* Grade_table columns 

ID Code
Neptun Code
Student Name
Submitted File
Report
Date
Time  

*/

$sql = "INSERT INTO `Grade_Table`(`IDCode`, `NeptunCode` ,`StudentName`,`Date` ,`Time`) 
VALUES (
		'$row->IDCode' 		, 
		'$row->NPCode' 		,	
		'$row->name'		,
		'$row->date_'		,
		'$row->time_'	
		)";



$sql_ = "UPDATE `Grade_Table` SET SubmittedFile = '$file_' WHERE NeptunCode = '$row->NPCode' ";


if ($conn->query($sql_) === TRUE) {
    
    echo "New record updated successfully";
	
	header("Location: http://alikatlabi.web.elte.hu/Thesis_project/ ");

	exit();
} else {
	
    echo "Error: " . $sql_ . "<br>" . $conn->error;

	header("Location: http://alikatlabi.web.elte.hu/Thesis_project/ ");
	
	
	exit();
}

$conn->close();

//function update_row($primaryKey , $column_name , $value_to_update)

//update_row($row->NPCode , 'Submitted File', $file_ );

 


?>