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
|	Group Members
+------------------------------------------------
**/

require_once "server_config/config.php";
require_once "function/header_footer.php";
require_once "function/mysql_interface.php";

$HTMLOUT = "";
//Group members
$HTMLOUT .= begin_block("group_members",$caption_t='Group Members', $per=98, $tdcls="colhead5", $img="<img src='{$TK3GRE['pic_base_url']}dis.png' style=' height:28px;' alt='' title='' />", $title='Group Members');
$HTMLOUT .="<table cellspacing='0' cellpadding='5'><tr>
			<td class=\"colhead3\"style='text-align:center;' title='No.'><b>No.</b></td> 
			<td class=\"colhead3\"style='text-align:center;' title='Name'><b>Name</b></td></tr>";
$HTMLOUT .= "<tr><td style='text-align:center;'><b>1. </b></td>
				<td style='text-align:center;'><b>Carsten Gerald Bruns</b></td></tr>";
$HTMLOUT .= "<tr><td style='text-align:center;'><b>2. </b></td>
				<td style='text-align:center;'><b>Christoph Storm</b></td></tr>";
$HTMLOUT .= "<tr><td style='text-align:center;'><b>3. </b></td>
				<td style='text-align:center;'><b>Daniel Handau</b></td></tr>";
$HTMLOUT .= "<tr><td style='text-align:center;'><b>4. </b></td>
				<td style='text-align:center;'><b>Jan Thomas Sturm</b></td></tr>";
$HTMLOUT .= "<tr><td style='text-align:center;'><b>5. </b></td>
				<td style='text-align:center;'><b>Pranay Sarkar</b></td></tr>";
$HTMLOUT .="</table>";
$HTMLOUT .= end_block();


//Now, make the page
print stdhead('Group Members') . $HTMLOUT . stdfoot();
?>