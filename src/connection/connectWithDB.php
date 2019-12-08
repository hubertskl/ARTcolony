
<?php
$config = require_once 'confing.php';
try{
    $db=new PDO("mysql:host={$config['host']};dbname={$config['database']};charset=utf8", $config['user'],$config['password'],[
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);


}catch(PDOException $error){
    echo $error->getMessage();
    exit('Database error');
}
function fetch_user_last_activity($id_user, $db)
{
	 $query = "
	 SELECT * FROM login_details 
	 WHERE id_user = '$id_user' 
	 ORDER BY last_activity DESC 
	 LIMIT 1
	 ";
	 $statement = $db->prepare($query);
	 $statement->execute();
	 $result = $statement->fetchAll();
	 foreach($result as $row)
	 {
	  return $row['last_activity'];
	 }
}

function fetch_user_chat_history($from_user_id, $to_user_id, $db)
	{
	 $query = "
	 SELECT * FROM chat_message 
	 WHERE (from_user_id = '".$from_user_id."' 
	 AND to_user_id = '".$to_user_id."') 
	 OR (from_user_id = '".$to_user_id."' 
	 AND to_user_id = '".$from_user_id."') 
	 ORDER BY timestamp 
	 ";
	 $statement = $db->prepare($query);
	 $statement->execute();
	 $result = $statement->fetchAll();
	 $output = '<ul class="list-unstyled">';
	 foreach($result as $row)
	 {
	  $user_name = '';
	  if($row["from_user_id"] == $from_user_id)
	  {
	   $user_name = '<b class="text-success">You</b>';
	  }
	  else
	  {
	   $user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $db).'</b>';
	  }
	  $output .= '
	  <ul>
	   <li><p>'.$user_name.' - '.$row["chat_message"].'</p></li>
		<li><p><div align="right" style="color: #616161; font-family: AlegreyaSansThin; src: url("../../../../Graphics/Fonts/AlegreyaSansSC-Thin.otf""> - <small>'.$row['timestamp'].'</small></div></p></li>
		</ul>
	  ';
	 }
	 $output .= '</ul>';
	 $query = "
	 UPDATE chat_message 
	 SET status = '0' 
	 WHERE from_user_id = '".$to_user_id."' 
	 AND to_user_id = '".$from_user_id."' 
	 AND status = '1'
	 ";
	 $statement = $db->prepare($query);
	 $statement->execute();
	 return $output;
	}

function get_user_name($id_user, $db)
{
 $query = "SELECT login FROM users WHERE id_user = '$id_user'";
 $statement = $db->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['login'];
 }
}

function count_unseen_message($from_user_id, $to_user_id, $db)
{
 $query = "
 SELECT * FROM chat_message 
 WHERE from_user_id = '$from_user_id' 
 AND to_user_id = '$to_user_id' 
 AND status = '1'
 ";
 $statement = $db->prepare($query);
 $statement->execute();
 $count = $statement->rowCount();
 $output = '';
 if($count > 0)
 {
  $output = '<span class="label label-success">'.$count.'</span>';
 }
 return $output;
}
?>