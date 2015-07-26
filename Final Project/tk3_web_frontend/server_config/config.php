<?php
/**
+------------------------------------------------
|   TK3 Final Project, Group E
|   =============================================
|   by Group E
|   Copyright (C) 2015, TU Darmstadt
|   =============================================
|	Server Configuration Stuffs
+------------------------------------------------
**/

error_reporting(E_ALL);

/* Compare php version for date/time stuff etc! */
	if (version_compare(PHP_VERSION, "5.1.0RC1", ">="))
		date_default_timezone_set('Europe/London');
	
define('TIME_NOW', time());
//Time config (to_be_used_later))
$TK3GRE['time_adjust'] =  0;
$TK3GRE['time_offset'] = '0'; 
$TK3GRE['time_use_relative'] = 1;
$TK3GRE['time_use_relative_format'] = '{--}, h:i A';
$TK3GRE['time_joined'] = 'j-F y';
$TK3GRE['time_short'] = 'jS F Y - h:i A';
$TK3GRE['time_long'] = 'M j Y, h:i A';
$TK3GRE['time_tiny'] = '';
$TK3GRE['time_date'] = '';

// MySQL DB config
$TK3GRE['mysql_host'] = "localhost";
$TK3GRE['mysql_user'] = "tk3";
$TK3GRE['mysql_pass'] = "tk3";
$TK3GRE['mysql_db']   = "tk3_final_project";

//Defning root path for webserver
if ( strtoupper( substr(PHP_OS, 0, 3) ) == 'WIN' )
  {
    $file_path = str_replace( "\\", "/", dirname(__FILE__) );
    $file_path = str_replace( "/server_config", "", $file_path );
  }
  else
  {
    $file_path = dirname(__FILE__);
    $file_path = str_replace( "/server_config", "", $file_path );
  }
define('ROOT_PATH', $file_path);

//Base-URL Setup
if ($_SERVER["HTTP_HOST"] == "127.0.0.1")
  $_SERVER["HTTP_HOST"] = $_SERVER["SERVER_NAME"];
$TK3GRE['baseurl'] = "http://" . $_SERVER["HTTP_HOST"]."/tk3_web_frontend";

//Base image URL setup
$TK3GRE['pic_base_url'] = $TK3GRE['baseurl']."/images/";

//Name of the site
$TK3GRE['site_name'] = "TK3 Final Project";


//Site Online/offline switch
// 1 = Online, 0 = offline
$TK3GRE['site_online'] = 1;


define ('WEBSERVER_VERSION','TK3_GROUP-E_1.0');

?>