<div id="songs_manager">
	<h1>Manage your songs</h1><br>
	<div id="all_songs">
	<?php
		session_start();
		require_once '../../connection/connectWithDB.php';
		$id_user = $_SESSION['id_user'];
		$all_songs = $db->prepare("SELECT * FROM media WHERE id_owner=:id AND is_accepted=1");
		$all_songs->bindParam(':id', $id_user);
		$all_songs->execute();
	
	while ($row = $all_songs->fetch(PDO::FETCH_ASSOC)) {
	
    echo '<form action = "../user/music_player/addPlaylist.php?editsong=' . $row["id_media"] . '" method="post" class="editsong">
        <input type = "submit" name = "editsong" input id="btn" class="btn" value = " ' . $row["media_title"] . '"></input>';
    
    echo '</form>';	}?>
	</div>
</div>

<div id="songs_status">
	<h1>Status of your songs</h1><br>
	<?php
	$waiting_songs = $db->prepare('SELECT * FROM media WHERE is_accepted = 0 and id_owner=:id');
	$waiting_songs->bindParam(':id', $_SESSION['id_user']);
	$waiting_songs->execute();
	$declined_songs = $db->prepare('SELECT * FROM media WHERE is_accepted = -1 and id_owner=:id');
	$declined_songs->bindParam(':id', $_SESSION['id_user']);
	$declined_songs->execute();
	echo '<div id="scroll">';
	while($row = $waiting_songs->fetch(PDO::FETCH_ASSOC)) {
		echo '<h2>' . $row['media_title'] . '</h2> <p class="songs" style="color:green;"> waiting for approval </p><br>';
	}
	while($row = $declined_songs->fetch(PDO::FETCH_ASSOC)) {
		echo '<h2>' . $row['media_title'] . '</h2> <p class="songs" style="color:red;"> declined </p><br>';
	}
	echo '</div>';
	?>
</div>

<div id="add_playlist">
	<h1>Add a new playlist</h1><br>
	<form action="../user/music_player/addPlaylist.php" method="post" class="add_playlist" >
	<div id="input_data">
        <input type="text" name="playlist_name" placeholder= "Name of your playlist..." ><br>
	<div id="all_songs">
		<?php
			$all_songs = $db->prepare('SELECT * FROM media WHERE is_accepted = 1');
			$all_songs->execute();
			while($row = $all_songs->fetch(PDO::FETCH_ASSOC)) {
				echo "<input type='checkbox' name='check_list[]' value='" . $row['id_media'] . "'>" . $row['media_title'] . "<br>";
				}
		?>
	</div>
	</div>
	<div class="add_button"><input type="submit" name="submit" value="Submit"></div>
    </form><br>
	<?php
	if(isset($_SESSION['e_addplaylist']))
		{
		echo '<h3>'.$_SESSION['e_addplaylist'].'</h3>';
		unset($_SESSION['e_addplaylist']);
		}
	?>
</div>
<div id="all_playlists">
	<h1>Manage your playlists:</h1><br>
	<div id="all_songs">
	<?php
		$id_user = $_SESSION['id_user'];
		$all_playlists = $db->prepare("SELECT * FROM playlists WHERE id_owner=:id");
		$all_playlists->bindParam(':id', $id_user);
		$all_playlists->execute();
	
	while ($row = $all_playlists->fetch(PDO::FETCH_ASSOC)) {
	
    echo '<form action = "../user/music_player/addPlaylist.php?editplaylist=' . $row["id_playlist"] . '" method="post" class="editplaylist">
        <input type = "submit" name = "editplaylist" input id="btn" class="btn" value = " ' . $row["title_playlist"] . '"></input>';
    
    echo '</form>';	}?>
	</div>
		
</div>

<script>
	
	$(".add_playlist").submit(function(e) {

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
			   
               alert('Your new playlist will be added to your library!'); 
           }
         });
		e.preventDefault(); // avoid to execute the actual submit of the form.

});

	$(".editplaylist").submit(function(e) {

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
			   
              // alert('Thanks! Your review is being processed'); 
			   window.location.href = "/src/webApp/mainPage/mainPage.php#page5";
           }
         });
		e.preventDefault(); // avoid to execute the actual submit of the form.


});


$(".editsong").submit(function(e) {

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
			   
              // alert('Thanks! Your review is being processed'); 
			   window.location.href = "/src/webApp/mainPage/mainPage.php#page8";
           }
         });
		e.preventDefault(); // avoid to execute the actual submit of the form.


});

</script>
