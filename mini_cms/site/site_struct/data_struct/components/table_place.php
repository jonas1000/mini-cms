<?php

echo "<div>";
echo "<h2>Reserve Table</h2>";
echo "</div>";

$sql = "
SELECT ".$prefix."resPos.resPos_id , ".$prefix."resPos.resPos_title
FROM ".$prefix."resPos;";
	
$res_pos_rows = mysqli_query($conn, $sql) or die("ERROR 12" . mysqli_error($conn));

//$res_table_row = mysqli_fetch_array($res_table_rows, MYSQLI_ASSOC);

	
echo "<div>";

foreach ($res_pos_rows as $res_pos_row => $res_pos_data)
{
	echo "<div>";
	
	echo "<div>";
	echo "<h4>".$res_pos_data['resPos_title']."</h4>";
	echo "</div>";
		
	echo "<div>";
		
	$sql = "SELECT ".$prefix."Dtable.Dtable_id, ".$prefix."Dtable.Dtable_capacity, ".$prefix."resPos.resPos_title
	FROM ".$prefix."Dtable, ".$prefix."resPos
	WHERE NOT EXISTS (SELECT ".$prefix."resDate.Dtable_id 
											FROM ".$prefix."resDate, ".$prefix."reservation 
											WHERE ".$prefix."resDate.Dtable_id = ".$prefix."Dtable.Dtable_id 
											AND (".$prefix."reservation.reservation_id = ".$prefix."resDate.reservation_id 
											AND ".$prefix."reservation.reservation_date = \"".$_POST['res_date']."\"))
	AND ".$prefix."Dtable.resPos_id = ".$res_pos_data['resPos_id']."
	AND ".$prefix."Dtable.resPos_id = ".$prefix."resPos.resPos_id
	AND ".$prefix."Dtable.Dtable_blocked = FALSE;";

	$res_table_rows = mysqli_query($conn, $sql) or die("ERROR 13 " . mysqli_error($conn));
	
	foreach($res_table_rows as $res_table_row => $res_table_data)
	{
		echo "<div id=\"table_".$res_table_data['Dtable_id']."\" onClick=\"selectTable(this.id)\">";
		echo "<input type=\"hidden\" value=\"0\">";
		echo "<h5>Table ".$res_table_data['Dtable_id']."</h5>";
		echo "</div>";
	}
	echo "</div>";
	echo "</div>";	
}

$input->set_type("hidden");
$input->set_id("table_list");
$input->set_value("");
$input->set_name("res_table_list");
$input->set_readonly();
//$input->set_required();

$input->display();

$input->clear_data();

echo "</div>";

?>