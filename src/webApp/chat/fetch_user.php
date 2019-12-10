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
		  $status = '<span class=""><div class="greencircle"></div></span>';
		 }
		 else
		 {
		  $status = '<span class=""><div class="redcircle"></div></span>';
		 }
		
	 $output .= '
	 <style>
		.chat_btn {
		  background-color: none;
		  font-family: AlegreyaSansThin;
		  color: white;
		  border: none;
		  padding: 5px 5px;
		  text-align: center;
		  display: inline-block;
		  font-size: 20px;
		  cursor: pointer;
		}
	</style>
	 <tr>
	  <td>'.$status.'</td>
	  <td><button type="button" class="btn start_chat chat_btn" style="" data-touserid="'.$row['id_user'].'" data-tousername="'.$row['login'].'">'  .$row['login'].'</button></td>
	  <td><p CLASS="chat_btn">'.count_unseen_message($row['id_user'], $_SESSION['id_user'], $db).'</p></td>
	 </tr>
	 ';
	}

	$output .= '</table>';

	echo $output;

?>


