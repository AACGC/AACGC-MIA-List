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
require_once(HEADERF);

if ($pref['mia_enable_gold'] == "1"){$gold_obj = new gold();}

//----------------------------------------------------------

$title = "Members Missing In Action";

//----------------------------------------------------------

$text .= "<center><div style='background-image:url(".e_PLUGIN."aacgc_mialist/images/tombstone_big.png); width:490px; height:575px' class='indent'><center>

<div style='width:325px; height:350px; overflow:auto; margin:90px'>

<table style='width:100%' class=''>";
 
$ordertype = "".$pref['mia_ordertype']."";
$order = "".$pref['mia_order']."";

$sql->db_Select("aacgc_mialist", "*", "ORDER BY ".$ordertype." ".$order."","");
while($row = $sql->db_Fetch()){

if ($row['mia_id'] == "")
{$text .= "<tr><td><i>There Are No Members MIA at this time!</i></td></tr>";}

else 

{$sql2 = new db;
$sql2->db_Select("user", "*", "user_id='".intval($row['mia_user'])."'");
$row2 = $sql2->db_Fetch();

if ($pref['mia_enable_gold'] == "1")
{$username = "<b>".$gold_obj->show_orb($row2['user_id'])."</b>";}
else
{$username = "<b>".$row2['user_name']."</b>";}

if ($pref['mia_enable_avatar'] == "1"){
if ($row2['user_image'] == "")
{$avatar = "<img src='".e_PLUGIN."aacgc_mialist/images/default.png' width=15px, height=15px></img>";}
else
{$useravatar = $row2[user_image];
require_once(e_HANDLER."avatar_handler.php");
$useravatar = avatar($useravatar);
$avatar = "<img src='".$useravatar."' width=15px, height=15px></img>";}}

//----------------------------------------------------------

$text .= "<tr>
<td class='indent' style='text-align:left'><a href='".e_BASE."user.php?id.".$row2['user_id']."'>".$avatar." ".$username."</a></td>
<td style='text-align:left' class='indent'><font size='1'>".$row['mia_date']."</font></td>
</tr>";}

}
//----------------------------------------------------------

$text .= "</table></div></center></div></center>";


//--#AACGC Plugin Copyright&reg; - DO NOT REMOVE BELOW THIS LINE
require(e_PLUGIN . 'aacgc_mialist/plugin.php');
$text .= "<br><br><br><br><br><br><br>
<a href='http://www.aacgc.com' target='_blank'><font size='1'>".$eplug_name." V".$eplug_version."  &reg;</font></a>";
//--------------------------------------------------------------

$ns -> tablerender($title, $text);

//----------------------------------------------------------

require_once(FOOTERF);

?>

