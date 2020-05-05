<?php

include "class_config.php";
include 'connection_info.php';
include 'utiles.php';



$setting = new Config();


$ok = true;

$option="";
$deadline = true;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if(empty($_POST["options"])){
		$ok = false;
		admin_logger("Please,specify an option to execute!");
	}else{
		
		$option = $_POST["options"];
		admin_logger($option ." option chosen!");
	}
	
	if(empty($_POST["subjectname"])){
		
		$setting->set_subjectName("default");
	}else{
	
		$setting->set_subjectName($_POST["subjectname"]);
		admin_logger("subject name: ".$_POST["subjectname"] );
	}
	if(empty($_POST["subjectcode"])){
		$ok = false;
	
	}else{
	
		$setting->set_subjectCode($_POST["subjectcode"]);
		admin_logger("code: ".$_POST["subjectcode"] );
	}
	
	if(empty($_POST["maxgrade"])){
	
		$setting->set_grade_max(100);
		
	}else{
		$setting->set_grade_max($_POST["maxgrade"]);
		admin_logger("maximum grade: ".$_POST["maxgrade"] ." chosen!");
	}
	if(empty($_POST["mingrade"])){
		
		$setting->set_grade_min(0);
	}else{
	
		$setting->set_grade_min($_POST["mingrade"]);
		admin_logger("minimum grade: ".$_POST["mingrade"] ." chosen!");
		}
	if(empty($_POST["deadline"])){
		
		$deadline = false;

		
	}else{
	
		$setting->set_deadline($_POST["deadline"]);
		admin_logger("deadlin : ".$_POST["deadline"] ." is to be set!");
	}
	
	
	
////////////////////////////////////////////////////////

$query_options = array(

		"save" => "INSERT INTO `{$GLOBALS['submission_table']}`(					`SubjectCode`	, 
																	`SubjectName`	,
																	`min`			,
																	`max`			, 
																	`deadLine`		) 
					VALUES (
							'$setting->subjectCode'	     	, 
							'$setting->subjectName' 		,	
							'$setting->grade_min'			,
							'$setting->grade_max'			,
							'$setting->deadline'
							)"
,

		"update" => "UPDATE `{$GLOBALS['submission_table']}` 
					 
					SET 
						SubjectName =	'$setting->subjectName' 			,	
						min 		=	'$setting->grade_min'				,
						max 		=	'$setting->grade_max'				,
						deadLine 	=	'$setting->deadline'	
					
					WHERE SubjectCode = '$setting->subjectCode' "
,

		"delete" => " DELETE FROM `{$GLOBALS['submission_table']}`
							WHERE SubjectCode = '$setting->subjectCode'"
,
					
					

		"publish" => "UPDATE `{$GLOBALS['submission_table']}` 
					 
					 SET 
						state = 1
						
					 WHERE SubjectCode = '$setting->subjectCode' "

,
		"unpublish" => "UPDATE `{$GLOBALS['submission_table']}` 
								 SET 
									state = 0
									
								 WHERE SubjectCode = '$setting->subjectCode' "
,
		"query" => "SELECT SubjectCode FROM `{$GLOBALS['submission_table']}` WHERE SubjectCode = '$setting->subjectCode' "


);

////////////////////////////////////////////////////////



if($ok){
		
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
	
		execute($conn,$option,$query_options,$setting->subjectCode);
		
		$conn->close();

	}else{
		
		admin_logger("action can not be proceed!");
		}

}



function execute($connect, $op , $qops , $subCode){

	//$sql_option = $qops[$op];
	$sql_option = $qops[$op];
	
	$save 		 = (strcmp($op,"save")==0)?true:false;
	$delete		 = (strcmp($op,"delete")==0)?true:false;
	$update 	 = (strcmp($op,"update")==0)?true:false;
	$publish	 = (strcmp($op,"publish")==0)?true:false;
	$unpublish   = (strcmp($op,"unpublish")==0)?true:false;
	$query  	 = (strcmp($op,"query")==0)?true:false;
	
	if($save){
		
		if ($connect->query($sql_option) === TRUE) {
			
			if(!$deadLine){
				admin_logger("no deadline set!");
			}
			admin_logger("setting saved!");
			
		} else {
			admin_logger("unable to save! ". $connect->error );
		}
	}
	if($update){
		$ex = subjectnameexist($connect, $subCode);
		
		 if($ex){
			 if ($connect->query($sql_option) === TRUE) {
				if(!$deadLine){
				admin_logger("no deadline set!");
			}
				admin_logger("setting updated!");
			
			} else {
				admin_logger("unable to update! ". $connect->error );
			}
		 }else{
			admin_logger("setting does not exist !");
			admin_logger("use save option first!");
			 
		 }
		
	}
	
	if($delete){
		
		if ($connect->query($sql_option) === TRUE) {
			
			admin_logger("setting deleted!");
			
		} else {
			admin_logger("unable to deleted! ". $connect->error );
		}
	}
	
	if($publish){
		$ex = subjectnameexist($connect, $subCode);
		
		if($ex)
		{
			if ($connect->query($sql_option) === TRUE)
			{
				
				admin_logger("setting published!");
				
			} else {
				admin_logger("unable to update! ". $connect->error );
			}
		 }else{
			admin_logger("setting does not exist !");
			admin_logger("use save option first!");
			 
		 }
	}
	if($unpublish){
	
		$ex = subjectnameexist($connect, $subCode);
		if($ex){
			if ($connect->query($sql_option) === TRUE) {
				
				admin_logger("setting retracted!");
				
			} else {
				admin_logger("unable to retract! ". $connect->error );
			}
			
		}else{
			admin_logger("setting does not exist !");
			admin_logger("use save option first!");
			 
		 }
	}

	
}


function subjectnameexist($c,$code){
	
	$info_sql = "SELECT SubjectName FROM `{$GLOBALS['submission_table']}` WHERE SubjectCode='$code'";

	
	$result = $c->query($info_sql);


	if ($result->num_rows > 0) {
		return true;
		
	} else {
		return false;
	}
}
	

?>