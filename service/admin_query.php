<?php

include 'utiles.php';
include 'connection_info.php';
include 'dbclass_report.php';
include 'queries_par.php';

$ok = true;

$option="";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	
	if(empty($_GET["queries"])){
		$ok = false;
		//echo "Please,specify an option to execute!";
	}else{
		
		$option = $_GET["queries"];
	
		//admin_logger($option ." option chosen!");
	}
	
	


	$query_options = array(
		
	"Grades" =>  "SELECT 	IDCode,
									NeptunCode,
									StudentName,
									Date,
									Time,
									Grade,
									FileName,
									type,
									Size,
									Content
											FROM `{$GLOBALS['report_table']}` 
											JOIN `{$GLOBALS['block_table']}`  USING (IDCode)
											JOIN `{$GLOBALS['file_table']}` 	USING (IDCode) "
	,

	"Settings" => "SELECT SubjectCode,SubjectName,min,max,deadLine,state FROM `{$GLOBALS['report_table']}`"

	);



	if($ok)
	{
		
		$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		{
			$Grades 		 = (strcmp($option,"Grades")==0)?true:false;
			$Settings		 = (strcmp($option,"Settings")==0)?true:false;
			
			$Q  = $query_options[$option];
			
			
			if($Grades){
				
				query_table($conn,$Q);
			}
			if($Settings){
				query_setting($conn,$Q);
				
			}
		}
		$conn->close();

	}else{
			
		echo "action can not be proceed!"." <br>";
		}
}




function query_setting($connect,$query){
	
	$result = $connect->query($query);

	if ($result->num_rows > 0) 
	{
		
		echo "<tr>";
		echo "<td> Subject code </td>";
		echo "<td> Subject Name </td>";	
		echo "<td> min </td>";	
		echo "<td> max </td>";	
		echo "<td> deadLine </td>";	
		echo "<td> state </td>";								
		echo "</tr>";
			
			while($row = $result->fetch_assoc())
			{
				$SubjectCode 	= $row["SubjectCode"];
				$SubjectName 	= $row["SubjectName"];
				$min 			= $row["min"];
				$max		 	= $row["max"];
				$deadLine 		= $row["deadLine"];
				$state			= $row["state"];
				
					
			
				echo "<td>" . $SubjectCode 	.	"</td>";
				echo "<td>" . $SubjectName  . 	"</td>";
				echo "<td>" . $min    		. 	"</td>";
				echo "<td>" . $max 			. 	"</td>";
				echo "<td>" . $deadLine  	. 	"</td>";
				
				if($state==1){
					echo "<td>" ."publish". 	"</td>";
					
				}else{
					echo "<td>" ."unpublish". 	"</td>";
					
				}
					echo "</tr>";
			}
		}else {
			echo "nothing published"." <br>";
	}
	
}

function query_table($connect,$query){
	
	$result = $connect->query($query);

	$empty_table = true;

	if ($result->num_rows > 0) {
		$rows = array();
		$i = 0;
		$empty_table = false;
		
		
		while($row_ = $result->fetch_assoc()) {
				
			$row  = new Report();
			$file = new DBFile();
			
			$row->set_IDCode($row_["IDCode"]); 
			$row->set_NPCode($row_["NeptunCode"]);
			$row->set_name($row_["StudentName"]);
			$row->set_date($row_["Date"]);
			$row->set_time($row_["Time"]) ;
			$row->set_grade($row_["Grade"]) ;
		
			$file->set_name($row_["FileName"]);
			$file->set_type($row_["type"]);
			$file->set_size($row_["Size"]);
			$file->set_content_q($row_["Content"]);
			
			$row->set_file($file);
			
			$rows[$i] = $row ;
			
			$i++;
			
		}
	} else {
		echo "0 results"." <br>";
	}



	if(!$empty_table){
		
		
		
		echo "<tr>";
			
		echo "<td> ID Code </td>";
		echo "<td> Neptun Code </td>";	
		echo "<td> Student Name </td>";	
		echo "<td> Grade </td>";	
		echo "<td> Date </td>";	
		echo "<td> Time  </td>";	
		echo "<td> Submitted File</td>";								
		echo "</tr>";
								
		
		for($x = 0; $x < count($rows); $x++) {
			echo "<tr>";
		
					
			if($rows[$x]->get_grade()>-1){
				
				$ftype    = $rows[$x]->get_file()->get_type();
				$fsize    = $rows[$x]->get_file()->get_size();
				$fname	  = $rows[$x]->get_file()->get_name();
				$fcontent = $rows[$x]->get_file()->get_content();
				
				$file =$rows[$x]->get_file();
			
				$tmpfname = tempnam(getcwd()."data","");
				$handle = fopen($tmpfname, "w");
				fwrite($handle, $fcontent);
				$path = stream_get_meta_data($handle)['uri'];
				$tmpfile_content = file_get_contents($path);
				fclose($handle);
			
			
				echo "<td>" . $rows[$x]->get_IDCode() .		"</td>";
				echo "<td>" . $rows[$x]->get_NPCode() . 	"</td>";
				echo "<td>" . $rows[$x]->get_name()   . 	"</td>";
				echo "<td>" . $rows[$x]->get_grade()  . 	"</td>";
				echo "<td>" . $rows[$x]->get_date()   . 	"</td>";
				echo "<td>" . $rows[$x]->get_time()   . 	"</td>";
				echo "<td>" ."<a href='service/download.php?file=".$path."&name=".$fname."'>".$fname."</a>"."</td>";
			
			}else{
				
				echo "<td>" . $rows[$x]->get_IDCode() .		 	"</td>";
				echo "<td>" . "not availabe" . 					"</td>";
				echo "<td>" . "not availabe" . 					"</td>";
				echo "<td>" . "not graded  " . 					"</td>";
				echo "<td>" . $rows[$x]->get_date() . 			"</td>";
				echo "<td>" . $rows[$x]->get_time() . 			"</td>";
				
				$ftype    = $rows[$x]->get_file()->get_type();
				$fsize    = $rows[$x]->get_file()->get_size();
				$fname	  = $rows[$x]->get_file()->get_name();
				$fcontent = $rows[$x]->get_file()->get_content();
				
				$file =$rows[$x]->get_file();
			
				$tmpfname = tempnam(getcwd()."data","");
				$handle = fopen($tmpfname, "w");
				fwrite($handle, $fcontent);
				$path = stream_get_meta_data($handle)['uri'];
				$tmpfile_content = file_get_contents($path);
				fclose($handle);
			
				echo "<td>" ."<a href='service/download.php?file=".$path."&name=".$fname."'>".$fname."</a>"."</td>";
				
			}
		
			echo "</tr>";
		   
		}
	 
	}
}
//flush();


?>