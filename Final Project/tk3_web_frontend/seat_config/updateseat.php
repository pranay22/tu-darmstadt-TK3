<?php
//updates a seat (tags) in the database
$seat_id = intval($_GET['seat_id']);
$tags = $_GET['tags'];

include("dbconnect.php");

$sql='UPDATE seats SET tags="'.$tags.'" WHERE id='.$seat_id;
mysqli_query($con,$sql);

mysqli_close($con);
?>
 
