<?php
include_once "site_struct/data_struct/components/lib/lib_class/button_class.php";

echo "<div>";
echo "<h2>Reserve Table</h2>";
echo "</div>";

$table_input = new input();

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
		AND re2213_Dtable.resPos_id = re2213_resPos.resPos_id;;";

	$res_table_rows = mysqli_query($conn, $sql) or die("ERROR 13 " . mysqli_error($conn));
	
	foreach($res_table_rows as $res_table_row => $res_table_data)
	{	
		$table_input->set_type("hidden");
		$table_input->set_readonly();
		$table_input->set_value($res_table_data['Dtable_id']);
		
		echo "<div>";
		echo "<h5>Table ".$res_table_data['Dtable_id']."</h5>";
		echo $table_input->display();
		echo "</div>";
		$table_input->clear_data();
	}
	echo "</div>";
	echo "</div>";		
}
$table_input->set_type("hidden");
$table_input->set_name("res_table_list");
$table_input->set_readonly();
$table_input->display();

echo "</div>";
?>