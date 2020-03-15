<?php

include 'utiles.php';


// admin_submit

// getting the IDcode , grade variables from form

// checks the grade in some range OR can be done in HTML

// updating the database row matching the IDcode provided

/* Grade_table columns 

ID Code
Neptun Code
Student Name
Submitted File
Report
Date
Time  

*/

//

$conn = mysqli_connect($servername,$username,$password,$dbname);
	
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = mysqli_query($conn,"SELECT * FROM employee");
?>


<link rel="stylesheet" href="admin_style.css">


<table class = "db_table">
	<tr>
		<th>ID Code</th>
		<th>Neptun Code</th>
		<th>Student Name</th>
		<th>Grade</th>
		<th>Date</th>
		<th>Time </th>
		<th>Submitted File</th>
	</tr>
<?php
$i=0;
while($row = mysqli_fetch_array($result)) {
if($i%2==0)
$classname="even";
else
$classname="odd";
?>
<tr class="<?php if(isset($classname)) echo $classname;?>">
<td><?php echo $row["userid"]; ?></td>
<td><?php echo $row["first_name"]; ?></td>
<td><?php echo $row["last_name"]; ?></td>
<td><?php echo $row["city_name"]; ?></td>
<td><?php echo $row["email"]; ?></td>
<td><a href="update-process.php?userid=<?php echo $row["userid"]; ?>">Update</a></td>
</tr>
<?php
$i++;
}
?>
</table>



?>