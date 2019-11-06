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
	<link rel="stylesheet" type = "text/css" href="registrationStyle/afterRegistrationStyle.css">

</head>
<body>
		<div id="web-title" ><a href="../index.html" class = "home"><p>ART</p>colony</a></div>
	<div id="container">
	
	
		<div class="name-text">
		<p>Welcome to ARTcolony! </br>We are glad you've joined our community. </p></br> 
		</div>
	
	</div>
	
	<div id = "user_sign_in"><p>Please </p><a href="../login/login.php" class = "sign_in">&nbsp sign in &nbsp</a><p> now to get inspired by music!</p></div>
	

</body>

</html>