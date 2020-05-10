<?php

include 'connection_info.php';

$info_sql = "SELECT SubjectName,min,max,deadLine,state FROM `{$GLOBALS['submission_table']}`";

		
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
		die(" Connection failed: " . $conn->connect_error );
	}else{
		
		$result = $conn->query($info_sql);

		if ($result->num_rows > 0) {
			
			while($row = $result->fetch_assoc())
			{
				
				$state			= $row["state"];
				
				if($state==1){
					
					$SubjectName 	= $row["SubjectName"];
					$min 			= $row["min"];
					$max		 	= $row["max"];
					$deadLine 		= $row["deadLine"];
					
					$message = "> Assignment of Subject : ".$SubjectName."  should be submitted before: "
					.$deadLine." --- maximum grade is : ".$max."  minimum is : ".$min."<br>";
								
					echo $message;
				
				}
		
			}
		}else {
			echo "nothing published"." <br>";
	}
}

$conn->close();


?>