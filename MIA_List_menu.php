<?php

/*
#######################################
#     e107 website system plguin      #
#     AACGC MIA List                  #
#     by M@CH!N3                      #
#     http://www.AACGC.com            #
#######################################
*/

if ($pref['mia_enable_gold'] == "1"){$gold_obj = new gold();}

//----------------------------------------------------------

$mia_title = "".$pref['mia_menutitle']."";

//----------------------------------------------------------

if ($pref['mia_enable_scrollmenu'] == "1")
{$mia_text .= "<div style='width:auto; height:".$pref['mia_scrollheight']."px; overflow:auto;'>";}
 
$ordertype = "".$pref['mia_ordertype']."";
$order = "".$pref['mia_order']."";

$sql->db_Select("aacgc_mialist", "*", "ORDER BY ".$ordertype." ".$order."","");
while($row = $sql->db_Fetch()){

if ($row['mia_id'] == "")
{$mia_text .= "<i>There Are No Members MIA at this time!</i>";}

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
{$avatar = "<img src='".e_PLUGIN."aacgc_mialist/images/default.png' width=".$pref['mia_avatar_size']."px></img>";}
else
{$useravatar = $row2[user_image];
require_once(e_HANDLER."avatar_handler.php");
$useravatar = avatar($useravatar);
$avatar = "<img src='".$useravatar."' width=".$pref['mia_avatar_size']."px></img>";}}

//----------------------------------------------------------

$mia_text .= "<center>
<div style='background-image:url(".e_PLUGIN."aacgc_mialist/images/tombstone_menu.png); width:240px; height:215px' class='indent'>
<table style='width:75%; height:85%' class=''>
<tr><td><center><font size='".$pref['mia_menufsize']."'>
<b>Since:
<br>
".$row['mia_date']."</b>
<br><br>
<a href='".e_BASE."user.php?id.".$row2['user_id']."'>
".$avatar."
<br>
<font size='".$pref['mia_menufsize']."'>".$username."</font>
</a>
</font></center></td></tr>
</table>
</div>";}
}
//----------------------------------------------------------

if ($pref['mia_enable_scrollmenu'] == "1")
{$mia_text .= "</div>";}

$ns -> tablerender($mia_title, $mia_text);

//----------------------------------------------------------

?>

