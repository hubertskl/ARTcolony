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
	
	
	$song_title = 'runforit.mp3';

						
						
		$result = $db->query("SELECT media_title FROM media WHERE file_name='runforit.mp3'");

		while ( $row = $result->fetch(PDO::FETCH_ASSOC))
		{
		
		echo $row["media_title"];
		
		} 
						
						
	
	
?>