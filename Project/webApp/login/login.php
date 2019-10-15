<?php
SESSION_START();
if (isset($_SESSION['logged_id'])) 
{
	header('Location: ../user/userPage.php');
	exit();
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>ARTcolony</title>
	<link rel="stylesheet" type = "text/css" href="loginStyle/loginStyle.css">

</head>
<body>
	<div id="login-container">
		<div id="web-title" ><a href="../index.html">Home</a></div>
			<div id="logo"><h1>Login</h1></div>
				<div id="panel"> 
					<form action="loginScript.php" method="post">
						<p><label for="username">Login:</label></p>
						<input type="text" id="username" name="username">
						<p><label for="password">Password:</label></p>
						<input type="password" id="password" name="password">
						<div class="przycisk_logowania"><p><input type="submit" value="Login"></p></div>
					</form>
					<div id="rej">
						<h2>Don't you have an account yet? JOIN NOW</h2>
					</div>
					<a href="../registration/registration.php"><input type="submit" value="Reg"/></a><br/>
					
				</div>
			
	
	
	</div>
<?php
	if (isset($_SESSION['bad_attempt'])) 
	{
		echo '<p>Bad login or password!</p>';
		unset($_SESSION['bad_attempt']);
	}
?>

</body>

</html>