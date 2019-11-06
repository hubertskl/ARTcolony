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
	
	require_once '../../connection/connectWithDB.php';
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>ARTcolony</title>
	<link rel="stylesheet" type = "text/css" href="mainPageStyle/mainPageStyle.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript" src="script.js"></script>
</head>
<body>
	<script src="../mainWebStyle/toggleSidebar.js"></script>

	<div id="main-container">
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 box">
		<div id="musicSidebar" class="musicSidebar" onmouseover="toggleMusicSidebar()" onmouseout="toggleMusicSidebar()">
		
					<div class="audio-player-cont">
						<div class="logo">
							<img src="../user/music_player/audio-player.png" />
						</div>
						<div class="player">
							<div id="songTitle" class="song-title">My Song title will go here My Song title will go here My Song title will go here</div>
							<input id="songSlider" class="song-slider" type="range" min="0" step="1" onchange="seekSong()" />
							<div>
								<div id="currentTime" class="current-time">00:00</div>
								<div id="duration" class="duration">00:00</div>
							</div>
							<div class="controllers">
								<img src="../user/music_player/previous.png" width="30px" onclick="previous();" />
								<img src="../user/music_player/play.png" width="40px" onclick="playOrPauseSong(this);" />
								<img src="../user/music_player/next.png" width="30px" onclick="next();" />
								<img src="../user/music_player/volume-down.png" width="15px" />
								<input id="volumeSlider" class="volume-slider" type="range" min="0" max="1" step="0.01" onchange="adjustVolume()" />
								<img src="../user/music_player/volume-up.png" width="15px" style="margin-left:2px;" />
							</div>
							<div id="nextSongTitle" class="song-title"><b>Za chwilę :</b>Next song title goes here...</div>
						</div>
					</div>
		
		</div>
		<div id="chatSidebar" class="chatSidebar" onmouseover="toggleChatSidebar()" onmouseout="toggleChatSidebar()">
			</div>
				<div class="title-box"></div>
					<div class="menu">
						<ul>
						  <li><a href="#page1">Home</a></li>
						  <li><a href="#page2">Your Profile</a></li>
						  <li><a href="#player">Music Player</a></li>
						  <li><a href="#reviews">Reviews</a></li>
						  <li><a href="../user/shop/main-shop-page.php">Shop</a></li>
						  <li><a href="../user/logout.php">Logout</a></li>
						</ul>
					</div>
				
				<!-- THIS IS THE COMPONENT TO BE REPLACED EACH PAGE -->
				<div id="pageContent">
				
				
				
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
				<!-- END END END END END END END END END END END END -->
				
				
					
					<script type="text/javascript">
					var songs = <?php
							$music = $db->query("SELECT file_name FROM media");
							$music_array = array();
							while($row = $music->fetch(PDO::FETCH_ASSOC)) {
									$music_array[] = $row['file_name'];
								}
							echo json_encode($music_array);
					?>;
					var display_titles = <?php
							$titles = $db->query("SELECT media_title FROM media");
							$titles_array = array();
							while($row = $titles->fetch(PDO::FETCH_ASSOC)) {
									$titles_array[] = $row['media_title'];
								}
							echo json_encode($titles_array);
					?>;
					var songTitle = document.getElementById('songTitle');
					var songSlider = document.getElementById('songSlider');
					var currentTime = document.getElementById('currentTime');
					var duration = document.getElementById('duration');
					var volumeSlider = document.getElementById('volumeSlider');
					var nextSongTitle = document.getElementById('nextSongTitle');
					var song = new Audio();
					var currentSong =
					<?php
							if (isset($_GET['track'])) {
								$c = "songs.indexOf('".$_GET['track']."')";
								echo $c;
							}
							else {
								$c = 0;
								echo $c;
							}
					?>;
					window.onload = firstStart;
					function loadSong () {
						song.src = "../user/uploads/accepted_music/" + songs[currentSong];
						songTitle.textContent = display_titles[currentSong];
						nextSongTitle.innerHTML = "<b>Next: </b>" + display_titles[currentSong + 1 % songs.length];
						song.playbackRate = 1;
						song.volume = volumeSlider.value;
						song.play();
						setTimeout(showDuration, 1000);
					}
					setInterval(updateSongSlider, 1000);
					function updateSongSlider () {
						var c = Math.round(song.currentTime);
						songSlider.value = c;
						currentTime.textContent = convertTime(c);
						if(song.ended){
							next();
						}
					}
					function convertTime (secs) {
						var min = Math.floor(secs/60);
						var sec = secs % 60;
						min = (min < 10) ? "0" + min : min;
						sec = (sec < 10) ? "0" + sec : sec;
						return (min + ":" + sec);
					}
					function showDuration () {
						var d = Math.floor(song.duration);
						songSlider.setAttribute("max", d);
						duration.textContent = convertTime(d);
					}
					function playOrPauseSong (img) {
						song.playbackRate = 1;
						if(song.paused){
							song.play();
							img.src = "../user/music_player/pause.png";
						}else{
							song.pause();
							img.src = "../user/music_player/play.png";
						}
					}
					function next(){
						currentSong = currentSong + 1 % songs.length;
						loadSong();
					}
					function previous () {
						currentSong--;
						currentSong = (currentSong < 0) ? songs.length - 1 : currentSong;
						loadSong();
					}
					function seekSong () {
						song.currentTime = songSlider.value;
						currentTime.textContent = convertTime(song.currentTime);
					}
					function adjustVolume () {
						song.volume = volumeSlider.value;
					}
					function firstStart () {
						loadSong();
						song.pause();
					}
					
					</script>
		</div>
	</div>
</body>
</html>