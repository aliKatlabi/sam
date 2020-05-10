<?php

include "dbclass_file.php";

// collected through form : NeptunCode , name
// using post method 

class Report{
	
	public  $IDCode_;
	public  $NPCode_;
	public  $name_ 	;
	public  $date_ ;
	public  $time_ ;
	public  $email_;
	public  $grade_;
	public  $file_ ;
	
	//public  $seq_;
	//public  $hash_;
	//public  $prevhash_;
	
	function __construct() {
		
	
	  }
/* 	function __construct($row) {
		
	
		$this->file_   = 	$row->file_;
		$this->IDCode_ = 	$row->IDCode_;
		$this->NPCode_ =	$row->NPCode_;
		$this->name_   =	$row->name_;
		$this->date_   =	$row->date_;
		$this->time_   =	$row->time_;
		$this->grade_  =	$row->grade_;
		
	  }  */
	  
	  function set_IDCode($v)	{		$this->IDCode_ 	= $v;}
	  function set_name($v)		{ 		$this->name_ 	= $v;}
	  function set_NPCode($v) 	{		$this->NPCode_ 	= $v;}
	  function set_date($v)		{		$this->date_ 	= $v;}
	  function set_time($v) 	{ 		$this->time_ 	= $v;}
	  function set_email($v) 	{ 		$this->email_	= $v;}
	  function set_grade($v) 	{ 		$this->grade_	= $v;}
	  function set_file($file) 	{ 		$this->file_	= $file;}
	 
	  
  // getters 
	
	  function get_IDCode()	{	return	$this->IDCode_;}
	  function get_name()	{ 	return	$this->name_ ;}
	  function get_NPCode() {	return	$this->NPCode_;}
	  function get_date()	{	return	$this->date_ ;}
	  function get_time() 	{ 	return	$this->time_ ;}
	  function get_email() 	{ 	return	$this->email_;}
	  function get_grade() 	{ 	return	$this->grade_;}
	  function get_file() 	{ 	return	$this->file_;}
  
}






?>