<?php
  //deletes a seat from the database
  $seat_id = intval($_GET['seat_id']);

  include("dbconnect.php");

  $sql_del="DELETE FROM seat_cam_pos WHERE seat_id =".$seat_id;
  mysqli_query($con,$sql_del);

  $sql_check="SELECT * FROM seat_cam_pos WHERE seat_id =".$seat_id;
  $result = mysqli_query($con,$sql_check);

  if (!mysqli_fetch_array($result)) {
    $sql_del_seat="DELETE FROM seats WHERE id =".$seat_id;
    mysqli_query($con,$sql_del_seat);
  }

  mysqli_close($con);
?>
