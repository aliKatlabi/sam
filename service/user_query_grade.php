<?php

include 'dbclass_report.php';
include 'utiles.php';
include 'connection_info.php';
include 'queries_par.php';


$ERR = false;
$idcoderr="";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if(empty($_POST["idcode"])){
		$ERR = true;
		$idcoderr = " ID code is required"."<br>";
	}else{
		$idcode = validate_input($_POST["idcode"]);
		
	}
}


if($ERR){
	echo "not sucessful query <br>".$idcoderr;
	
	
}else{
	
	$user_query_grade = "SELECT Grade FROM `Block_Table` WHERE IDCode = '$idcode' ";
	
	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die(" Connection failed: " . $conn->connect_error );
	}else{
		
		$result = $conn->query($user_query_grade);

		if ($result->num_rows > 0) {
						
			while($row = $result->fetch_assoc())
			{
				$grade = $row["Grade"];
				if($grade==-1){
					
					echo "Has not been graded .."."<br>";
				}else{
					
					echo "Your Grade is : ".$grade." <br>";
				}
			}
		}else {
			echo "There is no grade .. <br>try to reach the supervisor"." <br>";
		}
	}
	
	
				
	$conn->close();
}



?>