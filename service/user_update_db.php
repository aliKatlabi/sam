<?php

include 'dbclass_report.php';
include 'utiles.php';
include 'connection_info.php';
include 'queries_par.php';


/*

This service is ment to be used as a backend service for the purpose of saving user's information and uploading the FILE that 
it will be used for as a give back a grade corresponding with the it 
 
*/

// informaton to be collected from the HTML form are ( NeptunCode , name )
// the form is using POST method 



// creating new Report instence


/// uploading file 


//$_FILES["fileToUpload"]["tmp_name"]


// TODO : ajax function in (user.js) TO recieve check message and present them in the HTML document 
	
				$target_dir = '/data/';
				$target_file = $target_dir . basename($_FILES["file"]["name"]);
				$uploadOk = true;
				$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


// Check if file already exists
if (file_exists($target_file)) {
    echo "no file! <br>";
    $uploadOk = false;
}else{
		// Check file size
	if ($_FILES["file"]["size"] > 5000000) {
		echo "Sorry, your file is too large <br>";
		$uploadOk = false;
	}
	// Allow certain file formats
	if($FileType != "pdf" and !empty($FileType)) {
		echo "Sorry, only pdf files are allowed <br>";
		$uploadOk = false;
	}
	// Check if $uploadOk is set to 0 by an error
	if(empty($_FILES["file"]["tmp_name"])){
		echo "no file! are you kidding me  !<br>";
		$uploadOk = false;
	}
}


if (!$uploadOk) {
    echo "Sorry, your file was not uploaded <br>";
// if everything is ok, try to upload file

} else {
		
        //echo "The file ". basename($_FILES["file"]["name"]). " has been uploaded.";
	if (isset($_FILES["file"]["name"])) 
	{
			$row = new Report();
			$file = new DBFile();
			
		
			
			$ERR = false;
			$emialErr="";
			$nameErr="";
			$npcodeErr="";
			
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				
				if(empty($_POST["NeptunCode"])){
					$ERR = true;
					$npcodeErr = "Neptun Code is required"."<br>";
				}else{
					$row->set_NPCode(validate_input($_POST["NeptunCode"]));
				}
				if(empty($_POST["name"])){
					$ERR = true;
					$nameErr = "name is required"."<br>";
				}else{
				
					$row->set_name(validate_input($_POST["name"]));
				}
				if(empty($_POST["Email"])){
					$ERR = true;
					$emialErr = "Email is required"."<br>";
				}else{
				
					$row->set_email(validate_input($_POST["Email"]));
				}
				$row->set_IDCode(RandomToken(6));
				$row->set_date(date("Y-m-d"));
				$row->set_time(date("h:i:s"));
				
				$file->set_idcode($row->get_IDCode());
				$file->set_name($_FILES["file"]["name"]);
				$file->set_type($_FILES["file"]["type"]);
				$file->set_size($_FILES["file"]["size"]);
				$file->set_content($_FILES["file"]["tmp_name"]);
				
				//move_uploaded_file($file->get_content(), $target_dir);
			/* 	if (move_uploaded_file($file->get_content(), $target_dir)) {
					
					echo "File uploaded successfully<br>";
					
				}else {
					echo "Failed to upload file.<br>";
					$ERR=true;
				}
				 */
			}
			if($ERR){
				echo "not succesful submitting <br>".$nameErr.$emialErr.$npcodeErr;
			}else{
				
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}


			$rowfile = $row->file_;

			
			$user_insert = "INSERT INTO `Report_Table`(
											
											`IDCode`		, 
											`NeptunCode` 	,
											`StudentName`	,
											`Date` 			,
											`Time`			,
											`Email`) 
			VALUES (
					'$row->IDCode_ '		, 
					'$row->NPCode_' 		,	
					'$row->name_'			,
					'$row->date_'			,
					'$row->time_'			,
					'$row->email_'
					)";

			$file_insert = "INSERT INTO `File_Table`(
											
											`IDCode`    , 
											`FileName`  ,
											`type`		,
											`Size`		, 
											`Content`) 
			VALUES (
					'$file->idcode '		, 
					'$file->file_name' 		,	
					'$file->type'			,
					'$file->size'			,
					'$file->content'		
					)";
			
		if ($conn->query($file_insert) === TRUE) {
			
				if ($conn->query($user_insert) === TRUE) {
					
					
						$block_insert = "INSERT INTO `Block_Table`(`IDCode`	) VALUES ('$row->IDCode_')";


						if ($conn->query($block_insert) === TRUE) {
							
							 echo "block reserved"."<br>";
							 echo "hurray!! Successfully uploaded!"."<br>";
							 echo "Your grade will be send to  your <br>Email address when it's ready"."<br>";
							 echo "Or Keep this ID code to query your grade"."<br>";
							 echo "ID CODE : ".$row->IDCode_."<br>";
					

						} else {
								
							 echo "Failed to update block"."<br>";
						}
						
				} else {
						
					 echo "Failed to update!"."<br>";
				}

		}
			flush();
			$conn->close();

		}
	}else{
		echo "Failed to update!"."<br>";
	}
 }



$upload_err = array(

        0=>"There is no error, the file uploaded with success",
        1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini",
        2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
        3=>"The uploaded file was only partially uploaded",
        4=>"No file was uploaded",
        6=>"Missing a temporary folder"
);



?>