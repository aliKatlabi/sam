<?php

include 'user_utiles.php';
include 'utiles.php';

/*

This service is ment to be used as a backend service for the purpose of saving user's information and uploading the FILE that 
it will be used for as a give back a grade corresponding with the it 
 
*/

// informaton to be collected from the HTML form are ( NeptunCode , name )
// the form is using POST method 



// creating new row instence

$row = new Row();

/// uploading file 

$target_dir = "/afs/elte.hu/user/a/alikatlabi/web/Thesis_project/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


//$_FILES["fileToUpload"]["tmp_name"]


// TODO : ajax function in (user.js) TO recieve check message and present them in the HTML document 

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists <br>";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["file"]["size"] > 5000000) {
    echo "Sorry, your file is too large <br>";
    $uploadOk = 0;
}
// Allow certain file formats
if($FileType != "pdf" ) {
    echo "Sorry, only pdf files are allowed <br>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded <br>";
// if everything is ok, try to upload file

} else {
		
        //echo "The file ". basename($_FILES["file"]["name"]). " has been uploaded.";
		if (isset($_FILES["file"]["name"])) 
		{
			//$file_ =  file_get_contents($_FILES["file"]["tmp_name"]);
			
			/* $fp      = fopen($_FILES["file"]["tmp_name"], 'r');
			$file_content = fread($fp, filesize($_FILES["file"]["tmp_name"]));
			$file_content = addslashes($file_content);
			fclose($fp); */
			
			$row->set_file_content($_FILES["file"]["tmp_name"]);

		}
 }


//// TODO : generate a unique IDcode 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if(empty($_GET["NeptunCode"])){
	
		$npcodeErr = "Neptun Code is required";
	}else{
		$row->set_NPCode(validate_input($_GET["NeptunCode"]));
	}
	if(empty($_GET["name"])){
		
		$nameErr = "name is required";
	}else{
	
		$row->set_name(validate_input($_GET["name"]));
		
}
	
	$row->set_IDCode("23asqwe123");
	$row->set_date(date("Y-m-d"));
	$row->set_time(date("h:i:s"));

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


$sql = "INSERT INTO `Grade_Table`(`IDCode`		, 
								`NeptunCode` 	,
								`StudentName`	,
								`SubmittedFile`	, 
								`Date` 			,
								`Time`) 
VALUES (
		 $row->IDCode_ 			, 
		'$row->NPCode_' 		,	
		'$row->name_'			,
		'$row->file_content_'	,
		'$row->date_'			,
		'$row->time_'	
		)";

if ($conn->query($sql) === TRUE) {
	
     echo "MSG Successfully uploaded <br>";
	

} else {
		
	 echo "MSG Failed to update <br>";
}


$conn->close();

 

/*

	?>
			<script>
			alert('successfully uploaded');
			window.location.href='http://alikatlabi.web.elte.hu/Thesis_project/';
			</script>

		<?php

?>
			<script>
				alert('failed to update');
				window.location.href='http://alikatlabi.web.elte.hu/Thesis_project/';
			</script>
		<?php
		

*/
?>