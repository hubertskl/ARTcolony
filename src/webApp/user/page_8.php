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
		<p class="song_inf2">Title: <?php echo $song_title; ?></p><br>
		<div class="edited_song_cover">
			<img id="cover" src="../user/covers/accepted_covers/<?php echo $song_cover; ?>">
		</div>
		<p class="song_inf2">Great: <?php echo $song_counter; ?></p><br>
		
	<?php

	if(isset($_SESSION['song_reviews']) && !empty($_SESSION['song_reviews'])) 
	{
		$song_reviews= $_SESSION['song_reviews'];
		$review_user = $_SESSION['reviews_user'];
		$review_id = $_SESSION['review_id'];

		foreach (array_combine($_SESSION['song_reviews'], $_SESSION['reviews_user']) as $svalue => $uvalue){
			foreach ($review_id as $rvalue){
				echo '<p class="song_inf2">Reviews: </p>';
				echo '<p class ="song_inf2" >' . $svalue . '&nbsp; &nbsp; &nbsp; <form action = "../user/home/user_profile.php?id=' . $rvalue. '" method="post" class="id_user">
					<input type = "submit" id="btn" class="btn" value = " ' . $uvalue. '" ></input> </br> </form> </p></br>';
			}
		}
	}
	else  
	{	
		echo '<p class ="songs" >' . $song_title. ' doesn`t have any review yet</p><br>';
	}
?>	
		
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

<script>
	$(".id_user").submit(function(e) {

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
			   
               window.location.href = "/src/webApp/mainPage/mainPage.php#page6"; 
		
           }
         });
		e.preventDefault(); // avoid to execute the actual submit of the form.

});
	
</script>