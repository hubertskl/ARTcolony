<?php
	session_start();
	require_once '../../connection/connectWithDB.php';
	
	$id = 28;
	
	$music = $db->prepare("SELECT id_song FROM playlist_positions WHERE id_playlist=:id");
	$music->bindParam(":id", $id);
	$music->execute();
	
	$id_songs = array();
	while ($row = $music->fetch(PDO::FETCH_ASSOC)){
		echo $row['id_song'];
		array_push($id_songs, $row['id_song']);
	}
	
	echo json_encode($id_songs);
	
	$all = array();
	foreach($id_songs as $value) {
		$song = $db->prepare("SELECT file_name FROM media WHERE id_media=:id");
		$song->bindParam(":id", $value);
		$song->execute();
		while ($row = $song->fetch(PDO::FETCH_ASSOC)){
			array_push($all, $row['file_name']);
	}
	}
	
	echo json_encode($all);
	
	$music1 = $db->query("SELECT file_name FROM media");
	$music_array = array();
	while($row = $music1->fetch(PDO::FETCH_ASSOC)) {
		$music_array[] = $row['file_name'];
	}
	
	echo json_encode($music_array);
	
?>
