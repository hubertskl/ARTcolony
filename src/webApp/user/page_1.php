					<div id="component">
						<div id="last-songs">
							<p class = "component">Last uploaded songs:</p><br>
							
<?php
SESSION_START();
		include_once '../../connection/connectWithDB.php';
		$sql    = "SELECT media.media_title, media.id_media, media.id_owner, users.id_user, users.name FROM media INNER JOIN users ON media.id_owner = users.id_user WHERE is_accepted = 1 ORDER BY id_media DESC LIMIT 5";
		$result = $db->query($sql);

		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			echo '<form action = "../user/music_player/addPlaylist.php?track=' . $row["id_media"] . '" method="post" class="track">
				<input type = "submit" name = "track" input id="btn" class="btn" value = " ' . $row["media_title"] . '"></input>';
			echo ' <h1> By ' . $row["name"] . '</h1></br>';
			echo '</form>';
			}?>
							
						</div>
					</div>
					
					
