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
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="script.js"></script>
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
	<script src="../mainWebStyle/toggleSidebar.js"></script>

	<div id="main-container">
		
		<div id="musicSidebar" class="musicSidebar" onmouseover="toggleMusicSidebar()" onmouseout="toggleMusicSidebar()">
		
					<div id="audio-player-cont">
						<div class="logo">
							<img id="cover" src="../user/covers/accepted_covers/default.png">
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
							<div id="nextSongTitle" class="song-title"><b>Next :</b>Next song title goes here...</div>
						</div>
						<div id="playlists">
							<table id = "all_playlists_table">
								<thead>
									<tr>
										<th>Playlist name</th>
									</tr>
								</thead>
								<tbody>
								<thead>
							<?php
								$playlists_query = $db->prepare("SELECT * FROM playlists WHERE id_owner=:id");
								$playlists_query->bindParam(":id",$_SESSION['id_user']);
								$playlists_query->execute();
								
								while ($row = $playlists_query->fetch(PDO::FETCH_ASSOC)){
									echo "<tr>
										<td><a href = '../user/music_player/addPlaylist.php?playlist=" . $row['id_playlist'] . "'>" . $row['title_playlist'] . "</a></td>
										</tr>";
								}
							?>
								</thead>
								</tbody>
							</table>	
						</div>
					</div>
		
		</div>
		<div id="chatSidebar" class="chatSidebar" onmouseover="toggleChatSidebar()" onmouseout="toggleChatSidebar()">
			<div id="chat-cont">
				<div class="table-responsive">
					<h2 align="center">Online Users</h2>
					<div id="user_details"></div>
					<div id="user_model_details"></div>
				</div>
			</div>
		
		</div>
				<div class="title-box"></div>
					<div class="menu">
						<ul>
						  <li><a href="#page1">Home</a></li>
						  <li><a href="#page2">Your Profile</a></li>
						  <li><a href="#page3">Music Player</a></li>
						  <li><a href="#page4">Reviews</a></li>
						  <li><a href="../user/shop/main-shop-page.php">Shop</a></li>
						  <li><a href="../user/logout.php">Logout</a></li>
						</ul>
					</div>
					
				
				<!-- THIS IS THE COMPONENT TO BE REPLACED EACH PAGE -->
				<div id="pageContent">		
				
				
				
				</div>
				<!-- END END END END END END END END END END END END -->
				
				
					
					<script type="text/javascript">
					var songs = <?php
							
							if(isset($_SESSION['playlist_songs'])) {
								$music_array = $_SESSION['playlist_songs'];
								unset($_SESSION['playlist_songs']);
								echo json_encode($music_array);
								//loadSong();
							}
							else{
								$music = $db->query("SELECT file_name FROM media WHERE is_accepted=1");
								$music_array = array();
								while($row = $music->fetch(PDO::FETCH_ASSOC)) {
										$music_array[] = $row['file_name'];
									}
								echo json_encode($music_array);
							}
					?>;
					var display_titles = <?php
							if(isset($_SESSION['playlist_titles'])) {
								$titles_array = $_SESSION['playlist_titles'];
								unset($_SESSION['playlist_titles']);
								echo json_encode($titles_array);
							}
							else {
								$titles = $db->query("SELECT media_title FROM media WHERE is_accepted=1");
								$titles_array = array();
								while($row = $titles->fetch(PDO::FETCH_ASSOC)) {
										$titles_array[] = $row['media_title'];
									}
								echo json_encode($titles_array);
							}
					?>;
					var songTitle = document.getElementById('songTitle');
					var songSlider = document.getElementById('songSlider');
					var currentTime = document.getElementById('currentTime');
					var duration = document.getElementById('duration');
					var volumeSlider = document.getElementById('volumeSlider');
					var nextSongTitle = document.getElementById('nextSongTitle');
					var song = new Audio();
					var cover = document.getElementById('cover');
					var cover_array =
					<?php
						if(isset($_SESSION['playlist_covers'])) {
							$covers_array = $_SESSION['playlist_covers'];
							unset($_SESSION['playlist_covers']);
							echo json_encode($covers_array);
							}
						else {
							$covers = $db->query("SELECT media_cover FROM media WHERE is_accepted=1");
							$covers_array = array();
							while($row = $covers->fetch(PDO::FETCH_ASSOC)) {
								$covers_array[] = $row['media_cover'];
								}
							echo json_encode($covers_array);
						}
					?>;
					var currentSong =
					<?php
							if (isset($_SESSION['chosen_track'])) {
							$c = "songs.indexOf('".$_SESSION['chosen_track']."')";
							unset($_SESSION['chosen_track']);
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
						cover.src = "../user/covers/accepted_covers/" + cover_array[currentSong];
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

					fetch_user();
					
					setInterval(function(){
						update_last_activity();
						fetch_user();
						update_chat_history_data();
					}, 5000);
					
					function fetch_user() {
					  $.ajax({
					   url:"../chat/fetch_user.php",
					   method:"POST",
					   success:function(data){
						$('#user_details').html(data);
					   }
					  })
					 }
					 
					 function update_last_activity()
					 {
					  $.ajax({
					   url:"../chat/update_last_activity.php",
					   success:function()
					   {

					   }
					  })
					 }
					
					function make_chat_dialog_box(to_user_id, to_user_name)
					 {
					  var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" style="background-color: #111, color: #fff;" title="'+to_user_name+'">';
					  modal_content += '<div style="height:400px; background-color: #111; border:none solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
					  modal_content += fetch_user_chat_history(to_user_id);
					  modal_content += '</div>';
					  modal_content += '<div class="form-group">';
					  modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control" style="background-color: #111; color: white; border: none; width:395px; 	font-family: AlegreyaSansThin; src: url("../../../../Graphics/Fonts/AlegreyaSansSC-Thin.otf");"></textarea>';
					  modal_content += '</div><div class="form-group" align="right">';
					  modal_content+= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat chat_btn">Send</button></div></div>';
					  $('#user_model_details').html(modal_content);
					 }
					 
					$(document).on('click', '.start_chat', function(){
					  var to_user_id = $(this).data('touserid');
					  var to_user_name = $(this).data('tousername');
					  make_chat_dialog_box(to_user_id, to_user_name);
					  $("#user_dialog_"+to_user_id).dialog({
					   autoOpen:false,
					   width:400
					  });
					  $('#user_dialog_'+to_user_id).dialog('open');
					 });
					 
					 $(document).on('click', '.send_chat', function(){
					  var to_user_id = $(this).attr('id');  
					  var chat_message = $('#chat_message_'+to_user_id).val();
					  $.ajax({
					   url:"../chat/insert_chat.php",
					   method:"POST",
					   data:{to_user_id:to_user_id, chat_message:chat_message},
					   success:function(data)
					   {
						$('#chat_message_'+to_user_id).val('');
						$('#chat_history_'+to_user_id).html(data);
					   }
					  })
					 });
					
					 function fetch_user_chat_history(to_user_id)
					 {
					  $.ajax({
					   url:"../chat/fetch_user_chat_history.php",
					   method:"POST",
					   data:{to_user_id:to_user_id},
					   success:function(data){
						$('#chat_history_'+to_user_id).html(data);
					   }
					  })
					 }

					 function update_chat_history_data()
					 {
					  $('.chat_history').each(function(){
					   var to_user_id = $(this).data('touserid'); 
					   fetch_user_chat_history(to_user_id);
					  });
					 }

					 $(document).on('click', '.ui-button-icon', function(){
					  $('.user_dialog').dialog('destroy').remove();
					 });
					
					</script>
		
	
	</div>
	
	<footer class="footer"><div id="footer_text"><a href="#page7">© ARTcolony 2019 | About us and contact</a></div></footer>
	
</body>
</html>