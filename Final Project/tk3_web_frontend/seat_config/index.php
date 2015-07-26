<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>TK 3 Final Project seat configuration</title>
</head>
  <body>
    <?php
      //connect to database to get webcam image address and set it as canvas background
      $room = intval($_GET['room_id']);
      include("dbconnect.php");
      $sql="SELECT * FROM rooms WHERE room_id = ".$room;
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result);
    
      echo "<canvas id=\"webcamCanvas\" width=\"640\" height=\"480\" style=\"background-image:url('http://";
      echo $row['tcp_info'];
      echo "');\">Your browser does not support the HTML5 canvas tag.</canvas>";
    ?>
    
    <form>
      <button type="button" id="edit_btn" style="display:none">
        Edit places
      </button>
      
      <div id="editInputs">
        <button type="button" id="new_places">
          Draw new places
        </button>
        <div id="placeSelectedInputs" style="display:none">
          <button type="button" id="del_btn">
            Delete selected place
          </button>
          <label for="tag_edit">
            tags
          </label>
          <input id="tag_edit">
        </div>
      </div>
    </form>
    <script language="JavaScript" src="./seat_config.js"></script>
  </body>
</html>