
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
?>