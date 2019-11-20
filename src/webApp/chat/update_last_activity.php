<?php
SESSION_START();
if (!isset($_SESSION['logged_id'])) 
{
	header('Location: ../login/login.php');
	exit();
}
	if($_SESSION['login']=='admin' && $_SESSION['is_admin']=='1')
	{
		header('Location: ../admin/adminHome.php');
	}
	
	require_once '../../connection/connectWithDB.php';
	
	$query = "
	UPDATE login_details 
	SET last_activity = now() 
	WHERE login_details_id = '".$_SESSION["login_details_id"]."'
	";

	$statement = $db->prepare($query);

	$statement->execute();

?>


