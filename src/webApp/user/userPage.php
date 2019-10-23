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
	
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>ARTcolony</title>
	<link rel="stylesheet" type = "text/css" href="userStyle/userStyle.css">
</head>
<body>
				<div class="title-box"></div>
					<div class="menu">
					<ul>
					  <li><a href="../mainPage/mainPage.php">Home</a></li>
					  <li><a href="#player">Music Player</a></li>
					  <li><a href="#reviews">Reviews</a></li>
					  <li><a href="#shop">Shop</a></li>
					  <li><a href="../user/logout.php">Logout</a></li>
					</ul>
				</div>
		

</body>
</html>