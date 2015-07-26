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
|	Header and footer function
+------------------------------------------------
**/


//Standard Header function
function stdhead($title = "") {
    global $CURUSER, $TK3GRE, $lang, $free;

    if (!$TK3GRE['site_online'])
		//stderr('Website Down', 'Site is down for maintenance, please check back again later... thanks');
		die("Site is down for maintenance, please check back again later... thanks<br />");
	
	
	//Setting up page title
	if ($title == "")
        $title = $TK3GRE['site_name'] .(isset($_GET['tbv'])?" (".WEBSERVER_VERSION.")":'');
    else
        $title = $TK3GRE['site_name'].(isset($_GET['tbv'])?" (".WEBSERVER_VERSION.")":''). " :: " . htmlspecialchars($title);
        
	//html dtd (working)
	$htmlout = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
		\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		
		<html xmlns='http://www.w3.org/1999/xhtml'>
		<head>

			<meta name='generator' content='TK3' />
			<meta http-equiv='Content-Language' content='en-us' />
            
            <!-- ####################################################### -->
            <!-- #   TK3 Final Project    # -->
            <!-- #   Group E # -->
            <!-- ####################################################### -->
			
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
			<meta name='MSSmartTagsPreventParsing' content='TRUE' />
			
			<title>{$title}</title>
			<link rel='stylesheet' href='base_stylesheet.css' type='text/css' />
            <link rel='SHORTCUT ICON' href='favicon.ico' />
            <script type='text/javascript' src='scripts/java_klappe.js'></script>
            <script type='text/javascript' src='scripts/jquery-1.4.3.min.js'></script>
            <script type='text/javascript 'src='scripts/colorfade.js'></script>
            <script type='text/javascript' src='image-resize/jquery.js'></script>
            <script type='text/javascript' src='scripts/bookmark.js'></script>
            <script type='text/javascript' src='scripts/script.js'></script>
			<script type='text/javascript' src='scripts/tooltips.js'></script>
			<script type='text/javascript' src='scripts/jquery_marquee.js'></script>
		</head>
    
    <div class='base_around'><div class='base_content'>
    <body>
      <table width='100%' cellspacing='0' cellpadding='0' border ='0' style='background: transparent'>
      <tr>
      <td class='clear'>
      <div id='base_header_line'></div>
      <div id='base_header'>";
	
	//Adding logo (customizable)
	$htmlout .="<div id='base_logo'>
      <img src='{$TK3GRE['pic_base_url']}logo3.png' alt='' />
      </div></div>";
	$htmlout .="</td></tr>"; 
	$htmlout .="</table>";
	$htmlout .="<table class='mainouter' width='100%' border='0' cellspacing='0' cellpadding='0'>";
	
	//Menu buttons add/remove as per the need
	$htmlout .= "<!-- MENU -->
      <tr>
      <div id='base_menu'>";
      $htmlout .= "<div id='mover'><ul class='navigation'>
      <li><span class='nav'><a href='index.php'>HOME</a></span></li>
      <li><span class='nav'><a href='search.php'>SEARCH EMPTY SEAT</a></span></li>
      <li><span class='nav'><a href='group_members.php'>GROUP MEMBERS</a></span></li> 
      <li><span class='nav'><a href=\"javascript: bookmarksite('TK3', '{$TK3GRE['baseurl']}')\">BOOK-MARK</a></span></li>";
    $htmlout .= "</ul></div></div></tr>
	<!-- MENU FINISHED-->";
	$htmlout .="<tr><td align='center' class='outer' style='padding-top: 15px; padding-bottom: 20px'>";
	
	return $htmlout;
}

//Footer function
function stdfoot($stdfoot = false) {
	global $TK3GRE;
	$htmlfoot = '';
	$htmlfoot = "</div><p align='center'>
    <span class='server' title='Copyright (C) {$TK3GRE['site_name']} Group - E 2015 TU Darmstadt '>Copyright (C) {$TK3GRE['site_name']} Group - E 2015 TU Darmstadt </span></p>";
	//customizable date formatting
	$dateFormat="H:i";
    $timeNdate=gmdate($dateFormat, time());
    $htmlfoot .="</table></div><div id='footer1'>
     <div class='clearer' style=' font-family:Times New Roman;' title='TK3 - Group E'>TK3 - Group E</div>
    <div align='right' style=' font-family:Times New Roman; width: 965px; margin: -14px 0px 0pt; text-align: right;'><img style='margin-bottom: 1px;' alt='Server Time' src='{$TK3GRE['pic_base_url']}clock.png'> <a title='Server Time'>$timeNdate GMT</a></div>
    </div></div>";
	$htmlfoot .= "</td></tr>";
	$htmlfoot .= "</body></html>\n";
	return $htmlfoot;
}

//custom error display function
function stderr($heading, $text)
{
    $htmlout = stdhead();
    $htmlout .= stdmsg($heading, $text);
    $htmlout .= stdfoot();    
    print $htmlout;
    exit();
}

//custom message function block
function stdmsg($heading, $text)
{
    $htmlout = "<table class='main' width='750' border='0' cellpadding='0' cellspacing='0'>
    <tr><td class='embedded'>\n";
    if ($heading)
      $htmlout .= "<h2>$heading</h2>\n";
    $htmlout .= "<table width='100%' border='1' cellspacing='0' cellpadding='10'><tr><td class='text'>\n";
    $htmlout .= "{$text}</td></tr></table></td></tr></table>\n";
    return $htmlout;
}

//colaspable blocking system (cookie based)
function begin_block($caption = "", $caption_t, $per, $tdcls, $img = "", $title="", $center = false, $padding = 10)
	{
	global $TK3GRE;
	$htmlout = '';	
	$hide = "<img src='{$TK3GRE['pic_base_url']}minus.png' alt='Show/Hide' title='Show/Hide' border='0'/>"; 
	$show = "<img src='{$TK3GRE['pic_base_url']}plus.png' alt='Show/Hide' title='Show/Hide' border='0'/>"; 
    $htmlout .= '<script type="text/javascript" src="/scripts/jquery.js""></script>
	   <script type="text/javascript" src="scripts/jquery.cookie.js"></script>
	   <script type="text/javascript">
	   //<![CDATA[
		$(document).ready(function() {
			// the div that will be hidden/shown
			var panel = $("#box'.$caption.'");
			//the button that will toggle the panel
			var button = $("#top'.$caption.' a");
			// do you want the panel to start off collapsed or expanded?
			var initialState = "expanded"; // "expanded" OR "collapsed"
			// the class added when the panel is hidden
			var activeClass = "hidden";
			// the text of the button when the panels expanded
			var visibleHtml = "'.$hide.'";
			// the text of the button when the panels collapsed
			var hiddenHtml = "'.$show.'";

			if($.cookie("panelState'.$caption.'") == undefined) {
				$.cookie("panelState'.$caption.'", initialState);
			} 
			
			var state = $.cookie("panelState'.$caption.'");
			
			if(state == "collapsed") {
				panel.hide();
				button.html(hiddenHtml);
				button.addClass(activeClass);
			}
		   
			button.click(function(){
				if($.cookie("panelState'.$caption.'") == "expanded") {
					$.cookie("panelState'.$caption.'", "collapsed");
					button.html(hiddenHtml);
					button.addClass(activeClass);
				} else {
					$.cookie("panelState'.$caption.'", "expanded");
					button.html(visibleHtml);
					button.removeClass(activeClass);
				}
				
				panel.slideToggle("slow");
				
				return false;
			});
		});
		//]]>
	</script>';
	$htmlout .="<div id='wrap$caption'><table class='main' width='$per%' align='center' border='0' cellspacing='1' cellpadding='0'>
		<tr><td class='$tdcls'><div id='top$caption'>
    <span>$img <b title=\"$title\">".$caption_t."</b> </span><div style='float:right; margin-top: 7px; padding-right: 10px;'><a href='#' id='$caption'>$hide</a></div></div></td>
				  	</tr></table>
					<div id='box".$caption."' ><table class='main' width='$per%' align='center'  cellspacing='0' cellpadding='10' style='border-width: medium 1px 1px;'><tr>
						<td align='center' style='background: none repeat scroll 0 0 #dfe8f4; border-width: 0px 1px 1px;'>";		
						return $htmlout;
}
//block ending
function end_block() {
    return "</td></tr>
    </table></div></div><br />\n";
}

?>