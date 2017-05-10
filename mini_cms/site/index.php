<?php
	header("Pragma: no-cache");//disable web automatic content cashing
	session_start();//starting session
?>
<?php
echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";

include_once "site_struct/document_data/document_data.php";

$prefix = "re2213";

if(!isset($_SESSION['access_level']))
{
	$_SESSION['access_level'] = 3;
	$_SESSION['user_name'] = "none";
	$_SESSION['user_email'] = "none";
}


if(!isset($_GET["menu_id"]))
	$_SESSION["menu_id"] = 1;//setting menu selection session id
else
	$_SESSION["menu_id"] = $_GET["menu_id"];


include_once "site_struct/lib_incl.php";

echo "</head>";

echo "<body onload = \"init_func()\">";
include_once "site_struct/mobile_screen/absolute_menu.php";//include absolute menu structure (phone menu)
		

echo "  <div class = \"containment\" >";
		
include_once "site_struct/data_struct.php";//include site data structure
		
echo "  </div>";
echo "</body>";
echo "</html>";

?>