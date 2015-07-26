<?php
/**
+------------------------------------------------
|   TK3 Final Project, Group E
|   =============================================
|   by Group E
|   Copyright (C) 2015, TU Darmstadt
|   =============================================
|	Room Status details page
+------------------------------------------------
**/

require_once "server_config/config.php";
require_once "function/header_footer.php";
require_once "function/mysql_interface.php";

$HTMLOUT = "";

//fetch roomID from 
$room_id = 0;
$room_id = 0 + $_GET["room_id"];

if ($room_id != 0){
	db_conn();
	//Fetch Room details from database..
	$r = @sql_query("SELECT * FROM rooms WHERE room_id=$room_id");
	$room = mysql_fetch_assoc($r) or bark("Invalid Room ID");

	//fetch details 
	$roomName = $room["room_name"];
	$roomAddress = $room["room_address"];
	$noOfSeats = $room["no_of_seats"];
	$roomType = $room["type"];
	$seat_conf_btn = "<span class='btn'><a href='seat_config/index.php?room_id=$room_id'><font color=#FFFFFF>Seat Config for room $room_id</font></a></span>";
	
	//Don't know whether this will work or not.
	$seat_conf_with_design = "<span class='btn'><a href='seat_config_link.php?action=index?room_id=$room_id'><font color=#FFFFFF>Seat Config for room $room_id  (Nicer version)</font></a></span>";
	
	//More info about the rooms:: (Name, Type, Address)
	$HTMLOUT .= begin_block("r_info",$caption_t="Room Information", $per=98, $tdcls="colhead5", $img="<img src='{$TK3GRE['pic_base_url']}info.png' style=' height:28px;' alt='' title='' />", $title= 'Room Information');
	$HTMLOUT .="<table class='stats' border='1' cellspacing='0' cellpadding='5' align='center'>
	<tr><td class='rowhead' style='font-family:Trebuchet MS' title='Room Name'>Room Name</td><td align='center'>{$roomName}</td></tr>
    <tr><td class='rowhead' style='font-family:Trebuchet MS' title='Room Type'>Room Type</td><td align='center'>{$roomType}</td></tr>
    <tr><td class='rowhead' style='font-family:Trebuchet MS' title='Room Address'>Room Address <img src='{$TK3GRE['pic_base_url']}address.png' width='25' height='25' alt=''></td><td align='center'>{$roomAddress}</td></tr>
	<tr><td class='rowhead' style='font-family:Trebuchet MS' title='Seat Config'>Seat Config</td><td align='center'>{$seat_conf_btn}</td></tr>
	</table>";
	$HTMLOUT .= end_block();
	$HTMLOUT .="<br />";
	
	//fetch seat details...
	$seats = @sql_query("SELECT * FROM seats WHERE room_id=$room_id ORDER BY seat_id ASC");
	//$seat = mysql_fetch_assoc($r) or bark("Invalid Room ID");
	
	//seat status of each room, no details..
	$HTMLOUT .= begin_block("seat_info",$caption_t="Seat Information", $per=98, $tdcls="colhead5", $img="<img src='{$TK3GRE['pic_base_url']}status.png' style=' height:28px;' alt='' title='' />", $title= 'Seat Information'); 
	//seat info data..
	if (mysql_num_rows($seats) > 0) {
		//make table design
		$HTMLOUT .= "<table width='100%' cellspacing='0' cellpadding='5'><tr> 
        <td class=\"colhead3\"style='text-align:center;'><b>Seat Number</b></td> 
		<td class=\"colhead3\"style='text-align:center;'><b>Seat Tag</b></td>
        <td class=\"colhead3\"style='text-align:center;'><b>Current Status</b></td> 
        <td class=\"colhead3\"style='text-align:center;'><b>History</b></td></tr>";
		//populate table
		while ($seat = mysql_fetch_assoc($seats)) {
			$seatID = $seat["seat_id"];
			$occupied = $seat["occupied"];
			if ($occupied == 0){
				$current_stat_text = "Empty/Free to sit";
			}
			else
				$current_stat_text = "Filled up";
			$seattag = $seat["tags"];
			$seat_history = "<span class='btn'><a href='seat_history.php?room_id=$room_id&amp;seat_no=$seatID'><font color=#FFFFFF>History for seat $seatID</font></a></span>";
			//$seat_history = "<a href='seat_history.php?room_id=$room_id&amp;seat_no=$seatID'>Details for seat $seatID</a>\n"; 
			$HTMLOUT .= "<tr>
						<td style='text-align:center;'><b>{$seatID}</b></td>
						<td style='text-align:center;'><b>{$seattag}</b></td>
						<td style='text-align:center;'>{$current_stat_text}</td>
						<td style='text-align:center;'>{$seat_history}</td></tr>";
		}
		$HTMLOUT .="</table>";
	}
	else {
		$HTMLOUT .= "No Seat info found";
	}
	$HTMLOUT .= end_block();
	$HTMLOUT .="<br />";
}
//something wrong, room does not exist? Show error msg
else{
	$HTMLOUT = "";
	$HTMLOUT .="<div class='notification error2 autoWidth' style='width: 957px;'><span></span>
         <div class='text'><p style='font-size: 12px;'><strong>Error!</strong>Invalid room ID. Please go back.</p>
         </div>
        </div>";
}

//Now, make the page
print stdhead("Room Details for ". $roomName) . $HTMLOUT . stdfoot();

?>
