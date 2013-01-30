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
if(!getperms("P")) {
echo "";
exit;
}
require_once(e_ADMIN."auth.php");
require_once(e_HANDLER."form_handler.php"); 
require_once(e_HANDLER."file_class.php");
$rs = new form;
$fl = new e_file;
if (e_QUERY) {
        $tmp = explode('.', e_QUERY);
        $action = $tmp[0];
        $id = $tmp[1];
        unset($tmp);
}
require_once(e_HANDLER."calendar/calendar_class.php");
$cal = new DHTML_Calendar(true);
function headerjs()
{
	global $cal;
	require_once(e_HANDLER."calendar/calendar_class.php");
	$cal = new DHTML_Calendar(true);
	return $cal->load_files();
}

//-----------------------------------------------------------------------------------------------------------+
if (isset($_POST['update_mia'])) {
        $message = ($sql->db_Update("aacgc_mialist", "mia_user='".$_POST['mia_user']."', mia_date='".$_POST['mia_date']."' WHERE mia_id='".$_POST['id']."' ")) ? "Successful updated" : "Update failed";
}

if (isset($_POST['main_delete'])) {
        $delete_id = array_keys($_POST['main_delete']);
	$sql2 = new db;
    $sql2->db_Delete("aacgc_mialist", "mia_id='".$delete_id[0]."'");
	
}

if (isset($message)) {
        $ns->tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
}
//-----------------------------------------------------------------------------------------------------------+
if ($action == "") {
        $text .= $rs->form_open("post", e_SELF, "myform_".$row['mia_id']."", "", "");
        $text .= "
        <div style='text-align:center'>
        <table style='width:400px' class='fborder' cellspacing='0' cellpadding='0'>
        <tr>
        <td style='width:0%' class='forumheader3'>ID</td>
        <td style='width:50%' class='forumheader3'>User Name</td>
        <td style='width:50%' class='forumheader3'>MIA Date</td>
        <td style='width:50px' class='forumheader3'>Options</td>
       </tr>";
        $sql->db_Select("aacgc_mialist", "*", "ORDER BY mia_id ASC","");
        while($row = $sql->db_Fetch()){
        $sql2 = new db;
        $sql2->db_Select("user", "*", "WHERE user_id=".$row['mia_user']."","");
        $row2 = $sql2->db_Fetch();
        $text .= "
        <tr>
        <td style='width:' class='forumheader3'>".$row['mia_id']."</td>
        <td style='width:' class='forumheader3'>".$row2['user_name']."</td>
        <td style='width:' class='forumheader3'>".$row['mia_date']."</td>
        <td style='width:' class='forumheader3'>
        
		<a href='".e_SELF."?edit.{$row['mia_id']}'>".ADMIN_EDIT_ICON."</a>
		<input type='image' title='".LAN_DELETE."' name='main_delete[".$row['mia_id']."]' src='".ADMIN_DELETE_ICON_PATH."' onclick=\"return jsconfirm('".LAN_CONFIRMDEL." [ID: {$row['mia_id']} ]')\"/>
		</td>
        </tr>";
		}
        $text .= "
        </table>
        </div>";
        $text .= $rs->form_close();
	      $ns -> tablerender("", $text);
	      require_once(e_ADMIN."footer.php");
}
//-----------------------------------------------------------------------------------------------------------+

//-----------------------------------------------------------------------------------------------------------+

if ($action == "edit")
{
        $sql->db_Select("aacgc_mialist", "*", "WHERE mia_id=$id","");
        $row = $sql->db_Fetch();
        $sql2 = new db;
        $sql2->db_Select("user", "*", "WHERE user_id=".$row['mia_user']."","");
        $row2 = $sql2->db_Fetch();
        $sql3 = new db;
        $sql3->db_Select("user", "*");
        $rows = $sql3->db_Rows();
        for ($i=0; $i < $rows; $i++) {
        $option = $sql3->db_Fetch();
        $options .= "<option name='mia_user' value='".$option['user_id']."'>".$option['user_name']."</option>";}


if ($pref['mia_dateformat'] == "mm/dd/yyyy")
{$dateformata = "%m/%d/%Y";
$dateformatb = "m/d/Y";}
if ($pref['mia_dateformat'] == "dd/mm/yyyy")
{$dateformata = "%d/%m/%Y";
$dateformatb = "d/m/Y";}
if ($pref['mia_dateformat'] == "yyyy/mm/dd")
{$dateformata = "%Y/%m/%d";
$dateformatb = "Y/m/d";}


        $width = "width:100%";
        $text = "
        <div style='text-align:center'>
        ".$rs -> form_open("post", e_SELF, "MyForm", "", "enctype='multipart/form-data'", "")."
        <table style='".$width."' class='fborder' cellspacing='0' cellpadding='0'>
        <tr>
        <td style='width:30%; text-align:right' class='forumheader3'>User Name:</td>
        <td style='width:' class='forumheader3' colspan=2>
		<select name='mia_user' size='1' class='tbox' style='width:60%'>
                <option name='mia_user' value='".$row2['user_id']."'>".$row2['user_name']."</option>
		".$options."
        </td>
        </tr>
        <tr>
        <td style='width:30%; text-align:right' class='forumheader3'>MIA Since:</td>
        <td style='width:70%' class='forumheader3'>";

$text .= $cal->make_input_field(
           array('firstDay'       => 1, // show Monday first
                 'showsTime'      => true,
                 'showOthers'     => true,
                 'ifFormat'       => '".$dateformata."',
                 'weekNumbers'    => false,
                 'timeFormat'     => '12'),
           array('style'       => 'color: #840; background-color: #ff8; border: 1px solid #000; text-align: center',
                 'name'        => 'mia_date',
                 'value'       => date("".$dateformatb."", $time)));

$text .= "</td>
        </tr>

        <tr style='vertical-align:top'>
        <td colspan='2' style='text-align:center' class='forumheader'>
        ".$rs->form_hidden("id", "".$row['mia_id']."")."
        ".$rs -> form_button("submit", "update_mia", "Update")."
        </td>
        </tr>
        </table>
        ".$rs -> form_close()."
        </div>";
	      $ns -> tablerender("AACGC Edit MIA", $text);
	      require_once(e_ADMIN."footer.php");
}
?>