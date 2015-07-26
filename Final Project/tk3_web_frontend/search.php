<?php
/**
+------------------------------------------------
|   TK3 Final Project, Group E
|   =============================================
|   by Group E
|   Copyright (C) 2015, TU Darmstadt
|   =============================================
|	Room Search function
+------------------------------------------------
**/

require_once "server_config/config.php";
require_once "function/header_footer.php";
require_once "function/mysql_interface.php";

	$HTMLOUT = "";
	//Initializing database connection
	db_conn();
	
	$HTMLOUT .= "<table class='bottom' border='0' cellspacing='0' cellpadding='0'><tr><td class='embedded'>
	<form method='get' action='search_result.php'><b>Seat Number:</b> 
	<input type='text' class='search1' id='searchinput' name='seat_no' autocomplete='off' style='width: 240px;'  onkeypress='return noenter(event.keyCode);' value='' />
 	 in  ";
	$in = 1;
	
	//Fetch Room details from database..
	//make the existing room dropdown list
	$rooms = @sql_query("SELECT * FROM rooms ORDER BY room_id ASC");
	$HTMLOUT .= "<select name='room_id'>";
	if (mysql_num_rows($rooms) > 0) {
		while ($room = mysql_fetch_assoc($rooms)) {
			$roomID = $room["room_id"];
			$roomName = $room["room_name"];
			$HTMLOUT .="<option value=$roomID".($in == '1' ? ' selected' : '').">$roomName</option>";
		}
	}
	$HTMLOUT .= "</select>";
	$HTMLOUT .= "<input type='submit' value='Search' class='btn' />";
	$HTMLOUT .="</td></tr></table>";
	
	
//Now, make the page
print stdhead('Seat Searching') . $HTMLOUT . stdfoot();
?>