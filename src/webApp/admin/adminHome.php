<?php
SESSION_START();
if (!isset($_SESSION['logged_id']) && ($_SESSION['is_admin']!=='1')) 
{
	header('Location: ../login/login.php');
	exit();
}	
	echo  "adminHome" ;
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>ARTcolony</title>
</head>
<body>
	<div id="adminHome-container">HOME ADMIN
	</div>
	<div>
		<a href="../user/logout.php">Logout</a>
	</div>
</body>
</html>