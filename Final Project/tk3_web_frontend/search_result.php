<?php
/**
+------------------------------------------------
|   TK3 Final Project, Group E
|   =============================================
|   by Group E
|   Copyright (C) 2015, TU Darmstadt
|   =============================================
|	Seat Search result handler
+------------------------------------------------
**/

require_once "server_config/config.php";
require_once "function/header_footer.php";
require_once "function/mysql_interface.php";

	$HTMLOUT = "";

	//fetch roomID from 
	$room_id = 0;
	$seat_no = 0;
	$room_id = 0 + $_GET["room_id"];
	$seat_no = 0 + $_GET["seat_no"];
	
	//One time database connection
	db_conn();
	
	//Extra protection against invalid seats
	$seats = @sql_query("SELECT * FROM seats WHERE room_id=$room_id AND seat_id=$seat_no");
	$seat_info = mysql_fetch_assoc($seats) or bark("Invalid Seat or room ID");
	if (($room_id != 0) && ($seat_no != 0)){
		
		
		$r = @sql_query("SELECT * FROM rooms WHERE room_id=$room_id");
		$room = mysql_fetch_assoc($r) or bark("Invalid Room ID");
		//fetch details about room name
		$roomName = $room["room_name"];
		
		//fetch info about that particular seat
		//$seats = @sql_query("SELECT * FROM seats WHERE room_id=$room_id AND seat_id=$seat_no");
		//$seat_info = mysql_fetch_assoc($seats) or bark("Invalid Seat or room ID");
		$occupied = $seat_info["occupied"];
		$seattag = $seat_info["tags"];
		if ($occupied == 0) {
			//$occupied = "Seat is free";
			$occupied = "<img src='{$TK3GRE['pic_base_url']}yes_r.gif' />";
		}
		else {
			//$occupied = "Seat already filled up";
			$occupied = "<img src='{$TK3GRE['pic_base_url']}no_r.gif' />";
		}

		//detailed seat information
		$HTMLOUT .= begin_block("seat_search_info",$caption_t="Current Seat Information", $per=98, $tdcls="colhead5", $img="<img src='{$TK3GRE['pic_base_url']}info.png' style=' height:28px;' alt='' title='' />", $title= 'Current Seat Information');
		$HTMLOUT .="<table class='stats' border='1' cellspacing='0' cellpadding='5' align='center'>
		<tr><td class='rowhead' style='font-family:Trebuchet MS' title='Room Name'>Room Name</td><td align='center'>{$roomName}</td></tr>
		<tr><td class='rowhead' style='font-family:Trebuchet MS' title='Seat Number'>Seat Number</td><td align='center'>{$seat_no}</td></tr>
		<tr><td class='rowhead' style='font-family:Trebuchet MS' title='Seat Number'>Seat Tag</td><td align='center'>{$seattag}</td></tr>
		<tr><td class='rowhead' style='font-family:Trebuchet MS' title='Seat Number'>Seat Occupied?</td><td align='center'><b>{$occupied}</b></td></tr></tr>
		</table>";
		$HTMLOUT .= end_block();
		$HTMLOUT .="<br />";

	}
	//room not found? Show error..
	else {
		$HTMLOUT = "";
		$HTMLOUT .="<div class='notification warning2 autoWidth' style='width: 957px;'><span></span>
					<div class='text'><p style='font-size: 12px;'><strong>Warning!</strong>Invalid room ID OR seat ID. Please go back.</p>
					</div></div>";
	}

//Now, make the page
print stdhead("Current status of Seat no ". $room_id . " of Room no " . $room_id) . $HTMLOUT . stdfoot();


?>