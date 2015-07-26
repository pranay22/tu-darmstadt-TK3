<?php
//adds a seat to the database
$room = intval($_GET['room']);
$seat_nr = intval($_GET['seat_nr']);
//$tags = $_GET['tags'];

include("dbconnect.php");

$sql="INSERT INTO seats (room_id, seat_id, tags, occupied) VALUES (".$room.','.$seat_nr.',"'.$tags.'",0)';
mysqli_query($con,$sql);

$seat_id = mysqli_insert_id($con);

$sql_cam="INSERT INTO seat_cam_pos (seat_id,p0_x,p0_y,p1_x,p1_y,p2_x,p2_y,p3_x,p3_y) VALUES (".$seat_id.",".intval($_GET['p0x']).",".intval($_GET['p0y']).",".intval($_GET['p1x']).",".intval($_GET['p1y']).",".intval($_GET['p2x']).",".intval($_GET['p2y']).",".intval($_GET['p3x']).",".intval($_GET['p3y']).")";
mysqli_query($con,$sql_cam);

mysqli_close($con);

echo $seat_id;
?>
