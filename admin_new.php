<?php

/*
#######################################
#     e107 website system plguin      #
#     AACGC MIA List                  #
#     by M@CH!N3                      #
#     http://www.AACGC.com            #
#######################################
*/


require_once("../../class2.php");
if (!defined('e107_INIT'))
{exit;}
if(!getperms("P")){
header("location:".e_BASE."index.php");
exit;}

require_once(e_ADMIN."auth.php");
require_once(e_HANDLER."form_handler.php"); 
require_once(e_HANDLER."file_class.php");
require_once(e_HANDLER."calendar/calendar_class.php");
$rs = new form;
$fl = new e_file;
$cal = new DHTML_Calendar(true);
function headerjs()
{
	global $cal;
	require_once(e_HANDLER."calendar/calendar_class.php");
	$cal = new DHTML_Calendar(true);
	return $cal->load_files();
}
$offset = +0;
$time = time()  + ($offset * 60 * 60);
//-------------------------------------------------------------------------------------------------------------------

if ($_POST['miatodb'] == '1') {
$newmia = $_POST['mia_user'];
$newmiadate = $_POST['mia_date'];
$reason = "";
$newok = "";
if ($newmia == ""){
$newok = "0";
$reason = "No User Selected";}
else 
{$newok = "1";}
If ($newok == "0"){
 	$newtext = "
 	<center>
	".$reason."
	</center>
 	</b>
	";
$ns->tablerender("MIA List", $newtext);}
If ($newok == "1"){
$sql->db_Insert("aacgc_mialist", "NULL, '".$newmia."', '".$newmiadate."'") or die(mysql_error());
$ns->tablerender("", "<center><b>MIA User Added</b></center>");}}

//-------------------------------------------------------------------------------------------------------------------

$plugin_text .= "
<form method='POST' action='admin_new.php'>
<br>
<center>
<table style='width:400px' class='fborder' cellspacing='0' cellpadding='0'>
<tr>
		<td style='width:25%; text-align:right' class='forumheader3'>User:</td>
		<td style='width:75%' class='forumheader3'>
		<select name='mia_user' size='1' class='tbox' style='width:200px'>";
	        $sql->db_Select("user", "user_id, user_name", "ORDER BY user_name ASC","");
    		    while($row = $sql->db_Fetch()){
    		    $usern = $row[user_name];
    		    $userid = $row[user_id];

$plugin_text .= "<option name='mia_user' value='".$userid."'>".$usern."</option>";}

if ($pref['mia_dateformat'] == "mm/dd/yyyy")
{$dateformata = "%m/%d/%Y";
$dateformatb = "m/d/Y";}
if ($pref['mia_dateformat'] == "dd/mm/yyyy")
{$dateformata = "%d/%m/%Y";
$dateformatb = "d/m/Y";}
if ($pref['mia_dateformat'] == "yyyy/mm/dd")
{$dateformata = "%Y/%m/%d";
$dateformatb = "Y/m/d";}

 $plugin_text .= "</td></tr>
        <tr>
        <td style='width:%; text-align:right' class='forumheader3'>MIA Since:</td><td style='width:' class='forumheader3'>";

$plugin_text .= $cal->make_input_field(
           array('firstDay'       => 1, // show Monday first
                 'showsTime'      => true,
                 'showOthers'     => true,
                 'ifFormat'       => '".$dateformata."',
                 'weekNumbers'    => false,
                 'timeFormat'     => '12'),
           array('style'       => 'color: #840; background-color: #ff8; border: 1px solid #000; text-align: center',
                 'name'        => 'mia_date',
                 'value'       => date("".$dateformatb."", $time)));
					
$plugin_text .="</td>
        </tr>
        <tr>
        <td colspan='2' style='text-align:center' class='forumheader'>
		<input type='hidden' name='miatodb' value='1'>
		<input class='button' type='submit' value='Add MIA User' style='width:150px'>
		</td>
        </tr>
        </table></form>";


$ns->tablerender("Add To MIA List", $plugin_text);


require_once(e_ADMIN . 'footer.php');

?>



