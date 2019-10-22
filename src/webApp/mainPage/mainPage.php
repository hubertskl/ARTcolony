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
	<link rel="stylesheet" type = "text/css" href="mainPageStyle/mainPageStyle.css">
</head>
<body>
	<script src="mainPageStyle/toggleSidebar.js"></script>
	
	<div id="main-container">
		<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 box">
			<div id="musicSidebar" class="musicSidebar" onmouseover="toggleMusicSidebar()" onmouseout="toggleMusicSidebar()">
			</div>
			<div id="chatSidebar" class="chatSidebar" onmouseover="toggleChatSidebar()" onmouseout="toggleChatSidebar()">
			</div>
				<div class="title-box"></div>
				<div class="menu">
					<ul>
					  <li><a href="#profile">Your Profile</a></li>
					  <li><a href="#player">Music Player</a></li>
					  <li><a href="#reviews">Reviews</a></li>
					  <li><a href="#shop">Shop</a></li>
                        <li><a href="../user/logout.php">Logout</a></li>
					</ul>
				</div>
				<div style="clear:both"></div>
				
				<div class="component">
					<div id="last-songs">
						<h2>Last uploaded songs:</h2>
					</div>
				</div>
				<div class="component">
					<div id="last-reviews">
						<h2>Last reviews:</h2>
					</div>
				</div>
				
		</div>
	</div>
</body>
</html>