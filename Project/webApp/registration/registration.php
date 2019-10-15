<?php

	SESSION_START();
	
	if(isset($_POST['email']))
	{
		$wszystko_ok=true;
		
			if(isset($_POST['name']))
			{
				$name=$_POST['name'];
			}
			if(isset($_POST['family_name']))
			{
				$surname=$_POST['family_name'];
			}
		$username=$_POST['username'];

		if((strlen($username)<3)||(strlen($username)>25))
		{
			$wszystko_ok=false;
			$_SESSION['e_username']="Login must have more chars";
		}
		
		if(ctype_alnum($username)==false)
		{
			$wszystko_ok=false;
			$_SESSION['e_username']="only letters and numbers";
		}
		
		$email=$_POST['email'];
		$email2=filter_var($email, FILTER_SANITIZE_EMAIL);  
		
		if((filter_var($email2,FILTER_SANITIZE_EMAIL)==false) || ($email2!=$email))
		{
			$wszystko_ok=false;
			$_SESSION['e_email']="Invalid email";
		}
		
		$password1=$_POST['password1'];
		$password2=$_POST['password2'];
		
		if((strlen($password1)<3)||(strlen($password1)>25))
		{
			$wszystko_ok=false;
			$_SESSION['e_password1']="The password must contain between 3 and 25 characters";
		}
		if($password1!=$password2)
		{
			$wszystko_ok=false;
			$_SESSION['e_password2']="Passwords do not match";
		}
		
		$passwordhash = password_hash($password1, PASSWORD_DEFAULT); 
		
		
		if(!isset($_POST['regulamin']))
		{
			$wszystko_ok=false;
			$_SESSION['e_regulamin']="You must accept the regulations";
		}
		
		
		
			try{
				require_once '../../connection/connectWithDB.php';
				
				$qu1=$db->prepare('SELECT id_user FROM users WHERE email=:email1');
				$qu1->bindValue(':email1', $email, PDO::PARAM_STR);
				$qu1->execute();
		
				$mailNumber=$qu1->rowCount();
				
				if($mailNumber>0)
				{
					$wszystko_ok=false;
					$_SESSION['e_email']="There is an account with this email";
				}
				//
				$rezultat1 = $db->prepare('SELECT id_user FROM users WHERE login=:username1');
				$rezultat1->bindValue(':username1', $username, PDO::PARAM_STR);
				$rezultat1->execute();
				
				$ilosc_usern = $rezultat1->rowCount();
				if($ilosc_usern>0)
				{
					$wszystko_ok=false;
					$_SESSION['e_username']="This username is taken"
				}
				if($wszystko_ok==true)
				{
					
					$result5=$db->prepare("INSERT INTO users (login, password, name, family_name, email) VALUES (:username,:password,:name,:family_name,:email)"); 
					
					$result5->bindParam(':username',$username);
					$result5->bindParam(':password',$passwordhash);
					$result5->bindParam(':name',$name);
					$result5->bindParam(':family_name',$surname);
					$result5->bindParam(':email',$email);
					
					
					
					$result5->execute();
					
					
						$_SESSION['successful_registration']=true;
						
						header('Location: afterRegistration.php');
				
				}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd servera!</span>';
			echo '<br />Info: '.$e;
		}
			
		
	}

?>


<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>ARTcolony</title>
	<link rel="stylesheet" type = "text/css" href="css/fontello.css">

</head>
<body>
	<div id="container">
		<div id="page-title"><a  href="../index.html">Home</a><br><br>
			<a href="../login/login.php">Login</a>
		</div>
		
			<div id="logo"><h1>Register</h1></div>
				<div id="panel"> 
					<form method="POST">
					<p><label for="username">Login:</label></p>
					<input type="text" id="username" name="username">
					<?php
						if(isset($_SESSION['e_username']))
						{
							echo '<div class="error">'.$_SESSION['e_username'].'</div>';
							unset($_SESSION['e_username']);
						}
					?>
					<p>Name: </p>
					<input type="text" id="name1" name="name">
					<p>Family name: </p>
					<input type="text" id="family_name" name="family name">
					<p>e-mail: </p>
					<input type="text" id="email" name="email">
					<?php
						if(isset($_SESSION['e_email']))
						{
							echo '<div class="error">'.$_SESSION['e_email'].'</div>';
							unset($_SESSION['e_email']);
						}
					?>
					<p><label for="password">Password:</label></p>
					<input type="password" id="password1" name="password1">
					<?php
						if(isset($_SESSION['e_password1']))
						{
							echo '<div class="error">'.$_SESSION['e_password1'].'</div>';
							unset($_SESSION['e_password1']);
						}
					?>
					<p><label for="password">Repeat password:</label></p>
					<input type="password" id="password2" name="password2"></br></br>
					<?php
						if(isset($_SESSION['e_password2']))
						{
							echo '<div class="error">'.$_SESSION['e_password2'].'</div>';
							unset($_SESSION['e_password2']);
						}
					?>
					<label>
					<input type="checkbox" name="regulamin" /> I accept the conditions
					</label>
					<?php
						if(isset($_SESSION['e_regulamin']))
						{
							echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
							unset($_SESSION['e_regulamin']);
						}
					?>
					<div class="login-button"><p><input type="submit" value="Register"></p></div>
					</form>
				</div>
	
	
	</div>


</body>

</html>