<div id="add_new_songs">
	<h2>Add some new songs:</h2><br>
	<form action="../user/music_player/addPlaylist.php" method="post" class="add_song" >
	<div id="input_data">
	<div id="all_songs">
		<?php
			require_once '../../connection/connectWithDB.php';
			$all_songs = $db->prepare('SELECT * FROM media WHERE is_accepted = 1');
			$all_songs->execute();
			while($row = $all_songs->fetch(PDO::FETCH_ASSOC)) {
				echo "<input type='checkbox' name='add_new_songs[]' value='" . $row['id_media'] . "'>" . $row['media_title'] . "<br>";
				}
		?>
	</div>
	</div>
	<div class="add_button"><input type="submit" name="add" input id="btn" value="Add songs" class="btn"></div>
    </form><br>
	<?php
	if(isset($_SESSION['e_addnewsongs']))
		{
		echo '<h3>'.$_SESSION['e_addnewsongs'].'</h3>';
		unset($_SESSION['e_addnewsongs']);
		}
	?>
</div>

<div id="edited_playlist">
	<?php
		session_start();
		require_once '../../connection/connectWithDB.php';
	?>
	<h2><?php
		$title = $db->prepare("SELECT title_playlist FROM playlists WHERE id_playlist=:id");
		$title->bindParam(':id',$_SESSION['id_playlist']);
		$title->execute();
		
		$title_name = $title->fetch(PDO::FETCH_ASSOC);
		echo "Your playlist: " . $title_name['title_playlist'];
	?></h2>
	<table id = "edited_playlists_table">
		<thead>
			<tr>
				<th>Songs of this playlist:</th>
				<th>Action:</th>
			</tr>
		</thead>
		<tbody>
		<thead>
			<?php
				foreach (array_combine($_SESSION['songs_titles'], $_SESSION['songs_id']) as $valuename => $valueid) {
					echo '<tr>
							<td>' . $valuename . '</td>';
					echo '<td><form action = "../user/music_player/addPlaylist.php?deletesong=' . $valueid . '" method="post" class="deletesong">
						<input type = "submit" name = "deletesong" input id="btn" class="btn" value = "Delete"></input>';
					
					echo '</form></td>';		
				}
			?>
		</thead>
		</tbody>
	</table>
	<br>
	
	<?php
	echo ' <form action = "../user/music_player/addPlaylist.php?deleteplaylist=' . $_SESSION['id_playlist'] . '" method="post" class="deleteplaylist">';
	echo '<input type = "submit" name = "deleteplaylist" input id="btn" class="btn" value = "Delete this playlist"></input><h3>
	Warning! This deletes your playlist permanently!
	</h3>';
	echo '</form>';	
	?>
	
</div>	

<script>
	
	$(".deletesong").submit(function(e) {

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
			   
               alert('Your song will be deleted!'); 
			   window.location.href = "/src/webApp/mainPage/mainPage.php#page5";
           }
         });
		e.preventDefault(); // avoid to execute the actual submit of the form.

	});

	$(".add_song").submit(function(e) {

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
			   
               alert('Your song will be added to this playlist!'); 
			   //window.location.href = "/src/webApp/mainPage/mainPage.php#page5";
           }
         });
		e.preventDefault(); // avoid to execute the actual submit of the form.

	});
	
	$(".deleteplaylist").submit(function(e) {

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
			   
               confirm('Are you sure? We need to reload to apply those changes.'); 
			   window.location.href = "/src/webApp/mainPage/mainPage.php#page3";
           }
         });
	});

</script>
