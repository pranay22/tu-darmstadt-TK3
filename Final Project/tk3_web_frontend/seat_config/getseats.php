<?php
//gets all seats in a room from the database and returns them as JSON string
$room = intval($_GET['room']);

include("dbconnect.php");

$sql="SELECT * FROM seats WHERE room_id = ".$room;
$result = mysqli_query($con,$sql);

echo "[";
while ($row = mysqli_fetch_array($result)) {
    $seat_sql="SELECT * FROM seat_cam_pos WHERE seat_id = ".$row['id'];
    $seat_pos = mysqli_query($con,$seat_sql);
    $seat_pos_data = mysqli_fetch_array($seat_pos);
    
    if ($seat_pos_data) {
      if ($first) {
        echo ",";
      }
      $first = 42;
    
      echo "{";
      
      echo '"seat_id":'.$row['id'].","; 
      echo '"seat_nr":'.$row['seat_id'].","; 
      echo '"tags":"'.$row['tags'].'",';
      echo '"quad":[';
      echo '{"x":'.$seat_pos_data['p0_x'].',"y":'.$seat_pos_data['p0_y']."}";
      echo ',{"x":'.$seat_pos_data['p1_x'].',"y":'.$seat_pos_data['p1_y']."}";
      echo ',{"x":'.$seat_pos_data['p2_x'].',"y":'.$seat_pos_data['p2_y']."}";
      echo ',{"x":'.$seat_pos_data['p3_x'].',"y":'.$seat_pos_data['p3_y']."}";
      echo "]";
      
      echo "}";
    }
}
echo "]";

mysqli_close($con);
?>
