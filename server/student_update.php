<?php
$servername = "mysql.caesar.elte.hu";
$username = "alikatlabi";
$password = "WimgnHENWgITEhxr";
$dbname = "alikatlabi";


$NPCode = $_POST["NeptunCode"];
$name =  $_POST["name"];

$date = date("Y/d/m");
$time = date("h:i:s");


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO `Grade_Table`(`ID Code`, `Neptun Code`, `Student Name` , `Date` ,`Time`) 
VALUES ('4$3234R', '$NPCode' , '$name' , '$date' ,'$time')";

if ($conn->query($sql) === TRUE) {
    
    //echo "New record created successfully";
	header("Location: http://alikatlabi.web.elte.hu/Thesis_project/ ");

	
	exit();
} else {
	
    //echo "Error: " . $sql . "<br>" . $conn->error;
	header("Location: http://alikatlabi.web.elte.hu/Thesis_project/ ");
	
	
	exit();
}

$conn->close();

function phpAlert($msg) {
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}

?>