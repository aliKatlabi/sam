<?php

// utiles : contains global variables and useful functions  



$servername = "mysql.caesar.elte.hu";
$username = "alikatlabi";
$password = "WimgnHENWgITEhxr";
$dbname = "alikatlabi";

$home_page = 'http://alikatlabi.web.elte.hu/Thesis_project/';



function validate_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}



?>