<?php

/*
#######################################
#     e107 website system plguin      #
#     AACGC MIA List                  #
#     by M@CH!N3                      #
#     http://www.AACGC.com            #
#######################################
*/



$eplug_name = "AACGC MIA List";
$eplug_version = "1.4";
$eplug_author = "M@CH!N3";
$eplug_url = "http://www.aacgc.com";
$eplug_email = "admin@aacgc.com";
$eplug_description = "Select Members of your clan/community that are missing in action.Gold Orbs supported";
$eplug_compatible = "";
$eplug_readme = "";
$eplug_compliant = FALSE;
$eplug_module = FALSE;
$eplug_status = TRUE;
$eplug_latest = TRUE;


$eplug_folder      = "aacgc_mialist";

$eplug_menu_name   = "AACGC_MIA_List";

$eplug_conffile    = "admin_main.php";

$eplug_logo        = "logo.png";
$eplug_icon        = e_PLUGIN."aacgc_mialist/images/icon_32.png";
$eplug_icon_small  = e_PLUGIN."aacgc_mialist/images/icon_16.png";
$eplug_caption     = "AACGC MIA List";  

$eplug_prefs = array(
"mia_menutitle" => "Members MIA",
"mia_enable_gold" => "0",
"mia_enable_avatar" => "1",
"mia_avatar_size" => "50",
"mia_ordertype" => "mia_id",
"mia_order" => "DESC",
"mia_enable_scrollmenu" => "1",
"mia_scrollheight" => "225",
"mia_menufsize" => "2",
"mia_dateformat" => "mm/dd/yyyy",
);

$eplug_table_names = array("aacgc_mialist");

$eplug_tables = array(

"CREATE TABLE ".MPREFIX."aacgc_mialist(mia_id int(11) NOT NULL auto_increment,mia_user varchar(50) NOT NULL,mia_date text NOT NULL,PRIMARY KEY  (mia_id)) ENGINE=MyISAM;");


$eplug_link      = TRUE;
$eplug_link_name = "MIA List";
$eplug_link_url  = "".e_PLUGIN."aacgc_mialist/MIA_List.php";

$eplug_done = "Install Complete";
$eplug_upgrade_done = "Upgrade Complete";

$upgrade_alter_tables = "";
$upgrade_remove_prefs = "";
$upgrade_add_prefs = array(
"mia_menutitle" => "Members MIA",
"mia_enable_gold" => "0",
"mia_enable_avatar" => "1",
"mia_avatar_size" => "50",
"mia_ordertype" => "mia_id",
"mia_order" => "DESC",
"mia_enable_scrollmenu" => "1",
"mia_scrollheight" => "225",
"mia_menufsize" => "2",
"mia_dateformat" => "mm/dd/yyyy",
);


?>
