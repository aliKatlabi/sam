<?php

require 'utiles.php';
include 'connection_info.php';
include 'queries_par.php';
include 'BlockChain.php';


$grade;
$idcode= "";
$ok = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if(empty($_POST["Grade"])){
		$ok = false;
		admin_logger("Grade Code is required");
	}else{
		$grade = $_POST["Grade"];
	}
	if(empty($_POST["IDCode"])){
		$ok = false;
		admin_logger("ID code is required");
	}else{
		$idcode = validate_input($_POST["IDCode"]);
		
		}
}

// TODO check the grade's interval 
// max and min can be set through a config space
// configuration can be stored in a file 
// Config can be set as a class Config
 
// Create connection

// algorithem ..
		// get hash -> isEmpty ?
		// yes : get row sequence -> prev row seq = row sequence -1 
		//		 get prev hash -> generate new block (new hash)-> validate Chain
		//		 UPDATE the row with the new hash , prev hash, grade 
		
		// No  : get row sequence -> prev row seq = row sequence -1 
		//		 get hash -> get prev hash -> generate new block based on new grade and prev hash 
		//		 validate Block -> good? if not we dont update 
		
		
		// valdation : is the new generated hash equal to the current one 
		//			 : is the prev hash is the same 
		
if($ok){
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			//die("<span> <span id='pep'></span> Connection failed: " . $conn->connect_error ."</span><br>");
			die( $conn->connect_error );
		}
		# Create our worker object.
		
	
		$block = prepareBlock($grade,$idcode ,$conn  );
		
		if($block == false ){
			admin_logger("Grade cannot be modified");
		}else{
		
		
				$seq 		= $block->get_seq(); 
				$prevh 		= $block->get_prevHash();
				$hash 		= $block->get_hash();
				$ts 		= $block->get_timeStamp();
				$nonce 		= $block->get_nonce();
		
				$update_sql = "UPDATE `{$GLOBALS['block_table']}` SET 
														Grade ='$grade',
														Sequence='$seq',
														Hash = '$hash',
														Prev_hash='$prevh',
														timeStamp ='$ts',
														nonce = '$nonce'
								WHERE IDCode = '$idcode' ";
		
		
			if ($conn->query($update_sql) === TRUE) {
				
			
				admin_logger("Record updated successfully");
				// send email 
				$email_sql = "SELECT Email FROM `{$GLOBALS['report_table']}` WHERE IDCode = '$idcode' ";
				
				$result = $conn->query($email_sql);
					
				if ($result->num_rows > 0) {
					
					while($row = $result->fetch_assoc()) {
						$to_email_address = $row["Email"];
					}
				} else {
				
					admin_logger("0 results");
				}
				
				$message = "Your Assignment has been graded , your Grade is : ".$grade;
				
				mail($to_email_address,"Grade Update",$message);
				
					admin_logger("Grade is sent by email to : " . $to_email_address);
			} else {
				admin_logger(" Error updating record: " . $conn->error);
				
			}
				
			
		}
	

		$conn->close();
		flush();
 }



?>