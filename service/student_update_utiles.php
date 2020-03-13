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
	public  $file = "";

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
  function set_file($v) {
     
	 $this->file = $v;
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

$upload_err = array(
        0=>"There is no error, the file uploaded with success",
        1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini",
        2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
        3=>"The uploaded file was only partially uploaded",
        4=>"No file was uploaded",
        6=>"Missing a temporary folder"
);

function validate_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function phpAlert($msg) {
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}

function update_row($primaryKey , $column_name , $value_to_update) {

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



 $sql = "UPDATE `Grade_Table`
	SET
		 $column_name =  $value_to_update
	WHERE 
		Neptun Code = $primaryKey";

if ($conn->query($sql) === TRUE) {
    
    echo "New record updated successfully";
	
	header("Location: http://alikatlabi.web.elte.hu/Thesis_project/ ");

	exit();
} else {
	
    echo "Error: " . $sql . "<br>" . $conn->error;

	header("Location: http://alikatlabi.web.elte.hu/Thesis_project/ ");
	
	
	exit();
}

$conn->close();

}



?>