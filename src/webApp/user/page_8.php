<div id="edited_song">
<h2>About your song</h2>
	<?php
		session_start();
		require_once '../../connection/connectWithDB.php';
		
		$id_song = $_SESSION['song_info'][0];
		$song_title = $_SESSION['song_info'][1];
		$song_cover = $_SESSION['song_info'][2];
		$song_counter = $_SESSION['song_info'][3];
		//unset($_SESSION['song_info']);
		?>
		<br>
		<p class="songs">Title: <?php echo $song_title; ?></p><br>
		<div class="edited_song_cover">
			<img id="cover" src="../user/covers/accepted_covers/<?php echo $song_cover; ?>">
		</div>
		<p class="songs">Great: <?php echo $song_counter; ?></p><br>
</div>

<div id="edit_song">
<h2>Edit your song</h2><br>
<p class="songs">Your title should have 5 - 30 characters.
You can choose a new cover of your song, but it is not required(.jpg, .png, .bmp or .gif).
Cover needs to be less than 15MB!
						</p><br>
	<div id="upload_form">
		<form action="../user/music_player/addPlaylist.php" method="post" enctype="multipart/form-data">
			<input type="text" name="new_song_title" id="new_song_title" value= "<?php echo $song_title; ?>"><br><br>
			<label for="upload_cover">Browse your cover...</label>
			<input type="file" name="upload_cover" id="upload_cover"><br><br>
			<input type="submit" value="Submit" name="upload" id="submit_music" class="submit_music">
		</form><br>
		
</div><br>
</div>
