<?php
session_start();

require_once "../../../../document_data/db_conn.php";
require_once "../../../../document_data/document_data.php";
require_once "data_filter.php";
?>

<?php
	$user_name = $user_email = $user_pass = $user_gender = "";

	$user_name = filter_data($_POST['user_name']);
	$user_email = filter_data($_POST['user_email']);
	$user_pass = crypt(filter_data($_POST['user_pass']),"T51");
	$user_gender = filter_data($_POST['user_gender']);
	$user_pn = filter_data($_POST['user_phonenumber']);
	$rows = 0;
	$row_count = 0;
	
	$sql = "SELECT ".$prefix."user.user_email , ".$prefix."user.user_password
	FROM ".$prefix."user
	WHERE ".$prefix."user.user_email = \"".$user_email."\"
	OR ".$prefix."user.user_password = \"".$user_pass."\" 
	LIMIT 1;";
	
	$rows = mysqli_query($conn,$sql)or die("ERROR check " . mysqli_error($conn));
	$row_count = mysqli_num_rows($rows);
	
	echo "row_count: ". $row_count;
	
	if(!$row_count)
	{
		$sql = "INSERT INTO ".$prefix."user(accessLv_id,user_name,user_email,user_password,user_gender,user_phonenumber) VALUES
		( 2 ,\"".$user_name."\",\"".$user_email."\",\"".$user_pass."\",\"".$user_gender."\",\"".$user_pn."\")";
		
		mysqli_query($conn,$sql) or die("error:".mysqli_error($conn));
		
		mysqli_close($conn);
		Header("Location: ../../../../../?err_msg=registration was succesfull");
	}
	else	
	{
		mysqli_close($conn);
		Header("Location: ../../../../../?err_msg=email or password already exists, please try again");
	}
	
	mysqli_free_result($rows);
?>