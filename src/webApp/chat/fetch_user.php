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
		  background-color: #111;
		  font-family: Lemon;
		  src: url("../../../../Graphics/Fonts/Lemon Tuesday.otf");
		  color: white;
		  border: none;
		  padding: 10px 20px;
		  text-align: center;
		  display: inline-block;
		  font-size: 20px;
		  margin: 4px 2px;
		  cursor: pointer;
		}
	</style>
	 <tr>
	  <td><p>'.$status.'</p></td>
	  <td><p>'  .$row['login'].'</p></td>
	  <td><p>'.count_unseen_message($row['id_user'], $_SESSION['id_user'], $db).'</p></td>
	  <td><button type="button" class="btn start_chat chat_btn" style="" data-touserid="'.$row['id_user'].'" data-tousername="'.$row['login'].'">Chat</button></td>
	 </tr>
	 ';
	}

	$output .= '</table>';

	echo $output;

?>


