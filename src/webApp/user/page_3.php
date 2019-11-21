

<div id="add_playlist">
	<h2>Add a new playlist:</h2><br>
	<form action="../user/music_player/addPlaylist.php" method="post" id="add_playlist" >
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
	<button type="submit" name="submit" input id="btn" class="btn">Add playlist</button>
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
	?>
	
	<table id = "all_playlists_table">
		<thead>
			<tr>
				<th>Playlist name</th>
			</tr>
		</thead>
		<tbody>
		<thead>
			<?php
				while ($row = $all_playlists->fetch(PDO::FETCH_ASSOC)) {
					echo "<tr>
							<td><a href = '../user/music_player/addPlaylist.php?editplaylist=" . $row['id_playlist'] . "'>" . $row['title_playlist'] . "</a></td>
						</tr>";
				}
			?>
		</thead>
		</tbody>
	</table>	
</div>

