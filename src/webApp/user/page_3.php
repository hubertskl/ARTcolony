

<div id="add_playlist">
	<h2>Add a new playlist:</h2><br>
	<form action="../user/music_player/addPlaylist.php" method="post" class="add_playlist" >
	<div id="input_data">
        <input type="text" name="playlist_name" placeholder= "Name of your playlist..." ><br>
	<div id="all_songs">
		<?php
			session_start();
			require_once '../../connection/connectWithDB.php';
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
	<h2>Manage your playlists:</h2><br>
	
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

</script>
