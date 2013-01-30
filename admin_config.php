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
if (!getperms("P"))
{header("location:" . e_HTTP . "index.php");
exit;}
require_once(e_ADMIN . "auth.php");
if (!defined('ADMIN_WIDTH'))
{define(ADMIN_WIDTH, "width:100%;");}

if (e_QUERY == "update")
{
    $pref['mia_menutitle'] = $_POST['mia_menutitle'];
    $pref['mia_avatar_size'] = $_POST['mia_avatar_size'];
    $pref['mia_ordertype'] = $_POST['mia_ordertype'];
    $pref['mia_order'] = $_POST['mia_order'];
    $pref['mia_scrollheight'] = $_POST['mia_scrollheight'];
    $pref['mia_menufsize'] = $_POST['mia_menufsize'];
    $pref['mia_dateformat'] = $_POST['mia_dateformat'];


if (isset($_POST['mia_enable_gold'])) 
{$pref['mia_enable_gold'] = 1;}
else
{$pref['mia_enable_gold'] = 0;}

if (isset($_POST['mia_enable_avatar'])) 
{$pref['mia_enable_avatar'] = 1;}
else
{$pref['mia_enable_avatar'] = 0;}

if (isset($_POST['mia_enable_scrollmenu'])) 
{$pref['mia_enable_scrollmenu'] = 1;}
else
{$pref['mia_enable_scrollmenu'] = 0;}

    save_prefs();
    $led_msgtext = "Settings Saved";
}

$admin_title = "AACGC MIA List (Settings)";
//--------------------------------------------------------------------


$text .= "
<form method='post' action='" . e_SELF . "?update' id='confadvmedsys'>
	<table style='" . ADMIN_WIDTH . "' class='fborder'>

		<tr>
			<td colspan='3' class='fcaption'><b>Main Settings:</b></td>
		</tr>
		<tr>
                <td style='width:30%' class='forumheader3'>Order MIA Users By:</td>
     <td style='width:' class=''>
<select name='mia_ordertype' size='1' class='tbox' style='width:50%'>
<option name='mia_ordertype' value='".$pref['mia_ordertype']."'>".$pref['mia_ordertype']."</option>
<option name='mia_ordertype' value='mia_id'>MIA ID</option>
<option name='mia_ordertype' value='mia_date'>MIA Date</option>
<option name='mia_ordertype' value='mia_user'>User ID</option>
    </td><td style='width:' class=''>
<select name='mia_order' size='1' class='tbox' style='width:50%'>
<option name='mia_order' value='".$pref['mia_order']."'>".$pref['mia_order']."</option>
<option name='mia_order' value='DESC'>DESC</option>
<option name='mia_order' value='ASC'>ASC</option>
               </td>
		<tr>
		<tr>
                <td style='width:30%' class='forumheader3'>Date Format:</td>
     <td style='width:' class=''>
<select name='mia_dateformat' size='1' class='tbox' style='width:50%'>
<option name='mia_dateformat' value='".$pref['mia_dateformat']."'>".$pref['mia_dateformat']."</option>
<option name='mia_dateformat' value='mm/dd/yyyy'>mm/dd/yyyy</option>
<option name='mia_dateformat' value='dd/mm/yyyy'>dd/mm/yyyy</option>
<option name='mia_dateformat' value='yyyy/mm/dd'>yyyy/mm/dd</option>
    </td>
		<tr>


           <tr>
                <td style='width:30%' class='forumheader3'>Show User's Avatar:</td>
		        <td colspan=2 class='forumheader3'>".($pref['mia_enable_avatar'] == 1 ? "<input type='checkbox' name='mia_enable_avatar' value='1' checked='checked' />" : "<input type='checkbox' name='mia_enable_avatar' value='0' />")."</td>
	        </tr>



		<tr>
			<td colspan='3' class='fcaption'><b>Menu Settings:</b></td>
		</tr>
		<tr>
			<td style='width:30%' class='forumheader3'>Menu Title:</td>
			<td colspan='2'  class='forumheader3'><input class='tbox' type='text' size='60' name='mia_menutitle' value='".$tp->toFORM($pref['mia_menutitle'])."' /></td>
		</tr>
		<tr>
			<td style='width:30%' class='forumheader3'>Menu Font Size:</td>
			<td colspan='2'  class='forumheader3'><input class='tbox' type='text' size='10' name='mia_menufsize' value='".$tp->toFORM($pref['mia_menufsize'])."' />px</td>
		</tr>
		<tr>
			<td style='width:30%' class='forumheader3'>User Avatar Size:(only adjusts avatar size on menu, page avatar is auto set.)</td>
			<td colspan='2'  class='forumheader3'><input class='tbox' type='text' size='10' name='mia_avatar_size' value='" . $tp->toFORM($pref['mia_avatar_size'])."' />px  (If enabled above)</td>
		</tr>
           <tr>
                <td style='width:30%' class='forumheader3'>Enable Scrolling on Menu:</td>
		        <td colspan=2 class='forumheader3'>".($pref['mia_enable_scrollmenu'] == 1 ? "<input type='checkbox' name='mia_enable_scrollmenu' value='1' checked='checked' />" : "<input type='checkbox' name='mia_enable_scrollmenu' value='0' />")."</td>
	        </tr>
		<tr>
			<td style='width:30%' class='forumheader3'>Menu Scrolling Height:</td>
			<td colspan='2'  class='forumheader3'><input class='tbox' type='text' size='10' name='mia_scrollheight' value='" . $tp->toFORM($pref['mia_scrollheight'])."' />px  (If scrolling enabled above)</td>
		</tr>





		<tr>
			<td colspan='3' class='fcaption'><b>Extra Settings:</b></td>
		</tr>
                <tr>
		        <td style='width:30%' class='forumheader3'>Enable Gold System Support:</td>
		        <td colspan=2 class='forumheader3'>".($pref['mia_enable_gold'] == 1 ? "<input type='checkbox' name='mia_enable_gold' value='1' checked='checked' />" : "<input type='checkbox' name='mia_enable_gold' value='0' />")."(shows orbs as usernames, must have gold sytem 4.x and gold orbs 1.x installed)</td>
	        </tr>



                <tr>
			<td colspan='3' class='fcaption' style='text-align: left;'><input type='submit' name='update' value='Save Settings' class='button' /></td>
		</tr>





</table>
</form>";





$ns->tablerender($admin_title, $text);
require_once(e_ADMIN . "footer.php");
?>

