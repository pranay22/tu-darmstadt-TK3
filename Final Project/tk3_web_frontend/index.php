<?php
/**
+------------------------------------------------
|   TK3 Final Project, Group E
|   =============================================
|   by Group E
|   Copyright (C) 2015, TU Darmstadt
|   =============================================
|   SVN: --
|   Licence Info: --
+------------------------------------------------
|	Index page
+------------------------------------------------
**/

require_once "server_config/config.php";
require_once "function/header_footer.php";
require_once "function/mysql_interface.php";

	$HTMLOUT = "";
	//detect and store browser type
	//$browser = $_SERVER['HTTP_USER_AGENT'];
	
	//database connection function
	db_conn();
	//Fetch Room details from database..
	$rooms = @sql_query("SELECT * FROM rooms ORDER BY room_id ASC");
	$HTMLOUT .= begin_block("Room_Status",$caption_t="Room Status", $per=98, $tdcls="colhead5", $img="<img src='{$TK3GRE['pic_base_url']}status.png' style=' height:28px;' alt='' title='' />", $title= 'Room stats');
	if (mysql_num_rows($rooms) > 0) {
		//make table design
		$HTMLOUT .= "<table width='100%' cellspacing='0' cellpadding='5'><tr> 
        <td class=\"colhead3\"style='text-align:center;' title='Room ID'><b>Room ID</b></td> 
		<td class=\"colhead3\"style='text-align:center;' title='Room Name'><b>Room Name</b></td>
        <td class=\"colhead3\"style='text-align:center;' title='Room Type'><b>Room Type</b></td> 
		<td class=\"colhead3\"style='text-align:center;' title='Room Address'><b>Room Address</b></td> 
        <td class=\"colhead3\"style='text-align:center;' title='Number of Seats'><b>Number of Seats</b></td>
		<td class=\"colhead3\"style='text-align:center;' title='Room Details'><b>Room Details</b></td></tr>";
		//populate table
		while ($room = mysql_fetch_assoc($rooms)) {
			$roomID = $room["room_id"];
			$roomName = $room["room_name"];
			$roomType = $room["type"];
			$roomAddress = $room["room_address"];
			$no_of_seats = $room["no_of_seats"];
			$room_details= "<span class='btn' title='Details for room $roomID'><a href='room_stat.php?room_id=$roomID' title='Details for room $roomID'><font color=#FFFFFF>Details for room $roomID</font></a></span>";
			$HTMLOUT .= "<tr>
						<td style='text-align:center;' title='$roomID'><b>{$roomID}</b></td>
						<td style='text-align:center;' title='$roomName'><b>{$roomName}</b></td>
						<td style='text-align:center;' title='$roomType'>{$roomType}</td>
						<td style='text-align:center;' title='$roomAddress'>{$roomAddress}</td>
						<td style='text-align:center;' title='$no_of_seats'>{$no_of_seats}</td>
						<td style='text-align:center;'>{$room_details}</td></tr>";
		}
		$HTMLOUT .="</table>";
	}
	else {
		$HTMLOUT .= "No Seat info found";
	}
	//status of Server
	$HTMLOUT .= end_block();
	
	
	//Acknowledgement
    $HTMLOUT .= begin_block("Acknowledgement",$caption_t='Acknowledgement', $per=98, $tdcls="colhead5", $img="<img src='{$TK3GRE['pic_base_url']}dis.png' style=' height:28px;' alt='' title='' />", $title='Acknowledgement');
	$HTMLOUT .="<marquee behavior='scroll' scrollamount='4' direction='left' width='930'><fonr class='big'>
	We would like to thank TK3 -  Ubiquitous / Mobile Computing group for providing our group, the opportunity to work on this final project.</font></marquee>";
    $HTMLOUT .= end_block();
	
	$HTMLOUT .="<br />";
	
//Now, make the page
print stdhead('Home') . $HTMLOUT . stdfoot();
?>