
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

	$secret_key = 'WS-SERVICE-KEY';
    $secret_iv = 'WS-SERVICE-VALUE';
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
	
	function encrypt ($msg, $key){
		$secret_key = 'WS-SERVICE-KEY';
		$secret_iv = 'WS-SERVICE-VALUE';
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		$msg = base64_encode(openssl_encrypt($msg, 'AES-128-CBC', $key, 0, $iv));
		return $msg;
	};
	
	function decrypt ($msg, $key){
		$secret_key = 'WS-SERVICE-KEY';
		$secret_iv = 'WS-SERVICE-VALUE';
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		$msg = openssl_decrypt(base64_decode($msg), 'AES-128-CBC', $key, 0, $iv);
		return $msg;
	};
	
	function hashword($msg, $salt){
		$msg = crypt($msg, '$1$' . $salt . '$');
		return $msg;
	};
	
	function protect($msg){
		$msg = mysql_real_escape_msg(trim(strip_tags(addslashes($msg))));
		return $msg;
	};	

function fetch_user_chat_history($from_user_id, $to_user_id, $db)
	{
		$key = md5('message');
	 $query = "
	 SELECT * FROM chat_message 
	 WHERE (from_user_id = '".$from_user_id."' 
	 AND to_user_id = '".$to_user_id."') 
	 OR (from_user_id = '".$to_user_id."' 
	 AND to_user_id = '".$from_user_id."') 
	 ORDER BY timestamp DESC;
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
	   <li><p>'.$user_name.' - '.decrypt($row["chat_message"], $key).'</p></li>
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