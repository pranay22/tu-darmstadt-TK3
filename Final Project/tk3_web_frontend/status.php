<?php
/**
+------------------------------------------------
|   TK3 Final Project, Group E
|   =============================================
|   by Group E
|   Copyright (C) 2015, TU Darmstadt
|   =============================================
|   Description of page
+------------------------------------------------
**/

require_once "server_config/config.php";
require_once "function/header_footer.php";

$HTMLOUT = "";

$HTMLOUT .="<div class='notification warning2 autoWidth' style='width: 957px;'><span></span>
         <div class='text'><p style='font-size: 12px;'><strong>Warning!</strong>It appears as though you are running Internet Explorer, this site was <b>NOT</b> intended to be viewed with internet explorer and chances are it will not look right and may not even function correctly.
         You should consider downloading a real browser, Firefox from <a href='http://www.mozilla.com/firefox'><font color=#BB7070><b>HERE</b></font></a>. <strong>Get a SAFER browser !</strong></p>
         </div>
        </div>";

//Now generate page
print stdhead('Status') . $HTMLOUT . stdfoot();
?>