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
</head>
<body>
	<div id="userPage-container">HOME 
		<div class="name-text">
		<?php
			echo "<p> Hello ".$_SESSION['name'].' '.$_SESSION['family_name'].'!</p>'; 
		?>
		</div>

	</div>
	<div>
		<a href="../user/logout.php">Logout</a>
	</div>
</body>
</html>