<?php
SESSION_START();
if (isset($_SESSION['logged_id']))
{
	header('Location: ../mainPage/mainPage.php');
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
		<div id="web-title" ><a href="../index.html"><p>ART</p>colony</a></div>
				<div id="panel">
					<form action="loginScript.php" method="post">
						<input for="username" type="text" id="username" name="username" placeholder="USERNAME"></br></br>
						<input for="password" type="password" id="password" name="password" placeholder="PASSWORD"></br></br>
						<div class="login_button"><input type="submit" value=""></div>
					</form>
					<a href="../registration/registration.php"><input type="submit"value=""/><h2> Don't you have an account yet? JOIN NOW!</h2></a><br/>
				</div>
	</div>
</body>

</html>
