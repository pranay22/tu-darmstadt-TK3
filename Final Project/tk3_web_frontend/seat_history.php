<?php
/**
+------------------------------------------------
|   TK3 Final Project, Group E
|   =============================================
|   by Group E
|   Copyright (C) 2015, TU Darmstadt
|   =============================================
|	Per seat history page
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

//if all are valid, go head
if (($room_id != 0) && ($seat_no != 0)){
	db_conn();
	
	$r = @sql_query("SELECT * FROM rooms WHERE room_id=$room_id");
	$room = mysql_fetch_assoc($r) or bark("Invalid Room ID");
	//fetch details 
	$roomName = $room["room_name"];
	
	//detailed seat information
	$HTMLOUT .= begin_block("s_info",$caption_t="Seat Information", $per=98, $tdcls="colhead5", $img="<img src='{$TK3GRE['pic_base_url']}info.png' style=' height:28px;' alt='' title='' />", $title= 'Seat Information');
	$HTMLOUT .="<table class='stats' border='1' cellspacing='0' cellpadding='5' align='center'>
	<tr><td class='rowhead' style='font-family:Trebuchet MS' title='Room Name'>Room Name</td><td align='center'>{$roomName}</td></tr>
	<tr><td class='rowhead' style='font-family:Trebuchet MS' title='Seat Number'>Seat Number</td><td align='center'>{$seat_no}</td></tr></tr>
	</table>";
	$HTMLOUT .= end_block();
	$HTMLOUT .="<br />";
	
	//Fetch seat history details from database..
	$histories = @sql_query("SELECT * FROM history WHERE room_id=$room_id AND seat_id=$seat_no");
	if (mysql_num_rows($histories) > 0) {
		while ($history = mysql_fetch_assoc($histories)) {
			//recording historical data
			$recorded_status = $history["occupied"];
			$recorded_timestamp = $history["times"];
		}
	}
	//seat status of each room, no details..
	//$output = shell_exec('python ../Statistics/main.py -room_id={$room_id} -seat_id={$seat_no}');
	$output = shell_exec("python ../Statistics/main.py -room_id='$room_id' -seat_id='$seat_no'");
	//$output = shell_exec('python ../Statistics/main.py -room_id={$room_id} -seat_id={$seat_no} 2>&1');
	//$output = shell_exec("python ../Statistics/main.py -room_id='$room_id' -seat_id='$seat_no'  2>&1");
	if($output == NULL){
		$output = "ERROR!";
	}
	$HTMLOUT .= begin_block("Seat_History",$caption_t="Predicted Seat Status", $per=98, $tdcls="colhead5", $img="<img src='{$TK3GRE['pic_base_url']}status.png' style=' height:28px;' alt='' title='' />", $title= 'Predicted Seat Status');
	$HTMLOUT .= "According to prediction algorithm, predicted status of the seat at this point of time is ::  ";
	$HTMLOUT .= $output;
	//$HTMLOUT .= "It will show the history of seat of that particular room..";
	$HTMLOUT .= end_block();
	$HTMLOUT .="<br />";
}
//If something is wrong or does not exists, throw error
else{
	$HTMLOUT = "";
	$HTMLOUT .="<div class='notification warning2 autoWidth' style='width: 957px;'><span></span>
         <div class='text'><p style='font-size: 12px;'><strong>Warning!</strong>Invalid room ID OR seat ID. Please go back.</p>
         </div>
        </div>";
}

//Now, make the page
print stdhead("Seat history for Seat no ". $room_id . " of Room no " . $room_id) . $HTMLOUT . stdfoot();

?>
