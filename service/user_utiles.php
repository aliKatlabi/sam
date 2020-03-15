<?php


// collected through form : NeptunCode , name
// using post method 

class Row{
	public  $IDCode_;
	public  $name_ 	;
	public  $NPCode_;
	public  $date_ ;
	public  $time_ ;
	public  $file_content_ ;

  function set_IDCode($v) {
     $this->IDCode = $v;
  }
  
  function set_name($v) {
     $this->name = $v;
  }
  function set_NPCode($v) {
    $this->NPCode = $v;
  }
  function set_date($v) {
    $this->date_ = $v;
  }
  function set_time($v) {
     $this->time_ = $v;
  }
  function set_file_content($tmp_name) {
     //$_FILES["file"]["tmp_name"]
		$fp = fopen($tmp_name, 'r');
		$this->file_content_ = fread($fp, filesize($_FILES["file"]["tmp_name"]));
		$this->file_content_ = addslashes($this->file_content_);
		fclose($fp);

 }
  // getters 

}

$upload_err = array(
        0=>"There is no error, the file uploaded with success",
        1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini",
        2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
        3=>"The uploaded file was only partially uploaded",
        4=>"No file was uploaded",
        6=>"Missing a temporary folder"
);


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