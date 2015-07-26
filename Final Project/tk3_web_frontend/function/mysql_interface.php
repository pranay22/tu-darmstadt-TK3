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
|	PHP Interface (To_be_completed)
+------------------------------------------------
**/


//SQL connection interface = selecting working db
function db_conn() {
    global $TK3GRE;
    if (!@mysql_connect($TK3GRE['mysql_host'], $TK3GRE['mysql_user'], $TK3GRE['mysql_pass'])) {
	  switch (mysql_errno()) {
		//case 1040:
		case 2002:
			if ($_SERVER['REQUEST_METHOD'] == "GET")
				die("<html><head><meta http-equiv='refresh' content=\"5 $_SERVER[REQUEST_URI]\"></head><body><table border='0' width='100%' height='100%'><tr><td><h3 align='center'>The server load is very high at the moment. Retrying, please wait...</h3></td></tr></table></body></html>");
			else
				die("Too many users. Please press the Refresh button in your browser to retry.");
        default:
    	    die("[" . mysql_errno() . "] dbconn: mysql_connect: " . mysql_error());
      }
    }
    mysql_select_db($TK3GRE['mysql_db'])
        or die('db_conn: mysql_select_db: ' . mysql_error());
}

//SQL query interface
function sql_query($query) {
    $result = mysql_query($query);
    return $result;
}

//Standard error handler
function bark($msg) {
	stderr("Error!", $msg);
}

?>