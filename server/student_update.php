<?php
$servername = "mysql.caesar.elte.hu";
$username = "alikatlabi";
$password = "WimgnHENWgITEhxr";
$dbname = "alikatlabi";


// collected through form : NeptunCode , name
// using post method 

class Row{
	public  $IDCode ="" ;
	public  $name ="";
	public  $NPCode="";
	public  $date_ ="";
	public  $time_ ="";
	

  function set_IDCode($v) {
     $this->IDCode = $v;
  }
  
  function set_name($v) {
     $this->name = $v;
  }
  function set_NPCode($v) {
    $this->NPCode = $v;
  }
  function set_date_($v) {
    $this->date_ = $v;
  }
  function set_time_($v) {
     $this->time_ = $v;
  }
  
  // getters 
  function get_IDCode() {
     return $this->IDCode;
  }
  
  function get_name() {
     return $this->name ;
  }
  function get_NPCode() {
    return $this->NPCode ;
  }
  function get_date_() {
    return $this->date_ ;
  }
  function get_time_() {
    return $this->time_ ;
  }
}

$row = new Row();



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
	$row->set_date_(date("Y/d/m"));
	$row->set_time_(date("h:i:s"));

}


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO `Grade_Table`(`ID Code`, `Neptun Code`, `Student Name` , `Date` ,`Time`) 
VALUES (
		'$row->IDCode' 		, 
		'$row->NPCode' 		,	
		'$row->name'		,
		'$row->date_'		,
		'$row->time_'	
		)";

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

function validate_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function phpAlert($msg) {
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}


?>