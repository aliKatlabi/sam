<?php

// default config 


class Config{
	public  $subjectCode="";
	public  $subjectName="";
	public  $grade_max=100;
	public  $grade_min=0;
	public  $deadline="";
	public  $state=0;
	
	//setters 
	function __construct() {} 
	function set_subjectCode($v)			{		$this->subjectCode 	= $v;}
	function set_subjectName($v)			{		$this->subjectName 	= $v;}
	function set_grade_max($v)				{		$this->grade_max 	= $v;}
	function set_grade_min($v)				{ 		$this->grade_min 	= $v;}
	function set_deadline($v) 				{		$this->deadline 	= $v;}
	function set_state($v) 				{		$this->state 		= $v;}
	
	
  // getters 
	function get_subjectCode()				{	return	$this->subjectCode;}
	function get_subjectName()				{	return	$this->subjectName ;}
	function get_grade_max()				{	return	$this->grade_max ;}
	function get_grade_min()				{ 	return	$this->grade_min ;}
	function get_deadline() 				{	return	$this->deadline;}
	function get_state() 					{	return	$this->state;}
	
}



?>