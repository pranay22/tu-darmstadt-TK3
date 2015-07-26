<?php
  //connects to the database, connection can be accessed in variable $con-

  include("../server_config/config.php");

  $con = mysqli_connect($TK3GRE['mysql_host'],$TK3GRE['mysql_user'],$TK3GRE['mysql_pass'],$TK3GRE['mysql_db']);
  if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
    die('Could not connect: ' . mysqli_error($con));
  }
?>
