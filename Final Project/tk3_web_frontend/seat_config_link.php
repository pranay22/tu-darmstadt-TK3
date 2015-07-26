<?php
/**
+------------------------------------------------
|   TK3 Final Project, Group E
|   =============================================
|   by Group E
|   Copyright (C) 2015, TU Darmstadt
|   =============================================
|	Nicer seat config linking from web-frontend. (trying)
+------------------------------------------------
**/

require_once "server_config/config.php";
require_once "function/header_footer.php";
require_once "function/mysql_interface.php";

	$HTMLOUT = "";
	$action = 0 + $_GET["action"];
	$room_id = 0 + $_GET["room_id"];
	
	    /*$ad_actions = array('index'            => 'index',
                        'adduser'         => 'adduser', 
                        'stats'           => 'stats', 
                        );*/
    
    //if( in_array($action, $ad_actions) AND file_exists( "seat_config/{$ad_actions[ $action ]}.php" ) )
    if(file_exists( "seat_config/{$action}.php"))
		require_once "seat_config/{$ad_actions[ $action ]}.php?room_id=$room_id";
    else
		require_once "seat_config/index.php";
	
	
	
	
	
	
	
?>