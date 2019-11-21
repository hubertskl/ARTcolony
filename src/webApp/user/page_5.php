
<div id="edited_playlist">
	<?php
		session_start();
		require_once '../../connection/connectWithDB.php';
	?>

	<h2>Songs of chosen playlists:</h2>
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
					echo "<tr>
							<td>" . $valuename . "</td>
							<td><a href = '../user/music_player/addPlaylist.php?deletesong=" . $valueid . "'>Delete</a></td>
						</tr>";
				}
			?>
		</thead>
		</tbody>
	</table>
</div>	
	
<div id="add_playlist">
	<h2>Add some new songs:</h2><br>
	<form action="../user/music_player/addPlaylist.php" method="post" id="add_playlist" >
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
	<button type="submit" name="add" input id="btn" class="btn">Add next songs</button>
    </form><br>
	<?php
	if(isset($_SESSION['e_addnewsongs']))
		{
		echo '<h3>'.$_SESSION['e_addnewsongs'].'</h3>';
		unset($_SESSION['e_addnewsongs']);
		}
	?>
</div>