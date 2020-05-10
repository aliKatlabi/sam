<?php


class DBFile{
	
	public  $idcode;
	public  $file_name;
	public  $content;
	public  $type;
	public  $size;
	
	
	function set_idcode($v) { $this->idcode = $v;}
	function set_name($v) { $this->file_name = $v;}
	function set_type($v) { $this->type = $v;}
	function set_size($v) { $this->size = $v;}

	function set_content($v) {
			$fp = fopen($v, 'r');
			$this->content = fread($fp, filesize($_FILES["file"]["tmp_name"]));
			$this->content = addslashes($this->content);
			fclose($fp);
			}
			
			
	function set_content_q($v) {$this->content = $v;}
	
	function get_idcode() 	{ return $this->idcode;}
	function get_name() 	{ return $this->file_name ;}
	function get_type() 	{ return $this->type ;}
	function get_size()		{ return $this->size;}

	function get_content() {return $this->content;}
			
	
}
?>