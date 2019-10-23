<?php 
	SESSION_START();
	
	require_once '../../connection/connectWithDB.php';
if (!isset($_SESSION['logged_id'])) {
	
	if (isset($_POST['username'])) {
		
		$login = filter_input(INPUT_POST, 'username');
		$passwordPost = filter_input(INPUT_POST, 'password');
		
		//echo $login . " " .$password;
		
		$userQuery = $db->prepare('SELECT id_user, login, password, name, family_name, email, is_admin FROM users WHERE login = :login');
		$userQuery->bindValue(':login', $login, PDO::PARAM_STR);
		$userQuery->execute();
		//echo $userQuery->rowCount();
		$user = $userQuery->fetch();
		if (password_verify($passwordPost, $user['password'])) {

			$_SESSION['logged_id'] = $user['id_user'];
			//$id1=$user['id_uzytkownika'];
			//$q2=$db->prepare('SELECT * FROM uzytkownicy WHERE id_uzytkownika= :id1');
			//$q2->bindValue(':id1', $id1, PDO::)

			$_SESSION['id_user']=$user['id_user'];
			$name=$user['name'];
			$_SESSION['password']=$user['password'];
			
			$_SESSION['login']=$user['login'];
			
			$_SESSION['name']=$user['name'];
			$_SESSION['email']=$user['email'];
			$_SESSION['family_name']=$user['family_name'];
			//is admin
			$_SESSION['is_admin']=$user['is_admin'];
			
			unset($_SESSION['bad_attempt']);
			
			header('Location: ../mainPage/mainPage.php');
		} else {
			$_SESSION['bad_attempt'] = true;
			header('Location: login.php');
			exit();
		}
			
	} else {
		
		header('Location: login.php');
		exit();
	}
}
//$usersQuery = $db->query('SELECT * FROM uzytkownicy');
//$users = $usersQuery->fetchAll();
//print_r($users);
?>