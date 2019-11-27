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
	SELECT * FROM users 
	WHERE id_user != '".$_SESSION['id_user']."'
	";

	$statement = $db->prepare($query);

	$statement->execute();

	$result = $statement->fetchAll();

	$output = '
	<table class="">
	 <tr>
	  <td></td>
	  <td></td>
	  <td></td>
	 </tr>
	';

	foreach($result as $row)
	{
		 $status = '';
		 $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
		 $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
		 $user_last_activity = fetch_user_last_activity($row['id_user'], $db);
		 if($user_last_activity > $current_timestamp)
		 {
		  $status = '<span class="">Online</span>';
		 }
		 else
		 {
		  $status = '<span class="">Offline</span>';
		 }
		
	 $output .= '
	 
	 <tr>
	  <td><p>'.$row['login'].' '.count_unseen_message($row['id_user'], $_SESSION['id_user'], $db).'</td>
	  <td><p>'.$status.'</p></td>
	  <td><button type="button" class="btn start_chat" style="button" data-touserid="'.$row['id_user'].'" data-tousername="'.$row['login'].'">Start Chat</button></td>
	 </tr>
	 ';
	}

	$output .= '</table>';

	echo $output;

?>


