<?php
session_start();
require_once '../../../connection/connectWithDB.php';

if (isset($_POST['playlist_name'])) {
	if (!empty($_POST['check_list']) && !empty($_POST['playlist_name'])) {
		
		$allright=true;
		
		$playlist_name = $_POST['playlist_name'];
		
		if (strlen($playlist_name) < 5 || strlen($playlist_name) > 40) {
			$allright = false;
			//$_SESSION['e_addplaylist']="The title should be from 5 to 40 characters.";
			header('Location: /src/webApp/mainPage/mainPage.php#page3');
		}
		
		$check_list = $_POST['check_list'];
		$id_user = $_SESSION['id_user'];
		
		
		try{
			$sql_addplaylist = $db->prepare("INSERT INTO playlists (title_playlist, id_owner) VALUES (:title, :id)");
			$sql_addplaylist->bindParam(':title',$playlist_name);
			$sql_addplaylist->bindParam(':id',$id_user);
			$sql_addplaylist->execute();
			
			$sql_playlistId = $db->prepare("SELECT id_playlist FROM playlists WHERE title_playlist = :title");
			$sql_playlistId->bindParam(':title', $playlist_name);
			$sql_playlistId->execute();
			
			$playlist = $sql_playlistId->fetch(PDO::FETCH_ASSOC);
			$id_playlist = $playlist['id_playlist'];
			
			
			foreach ($check_list as $value) {
				$sql_addSongs =$db->prepare("INSERT INTO playlist_positions (id_song, id_playlist) VALUES (:id_song, :id_playlist)");
				$sql_addSongs->bindParam(':id_song', $value);
				$sql_addSongs->bindParam(':id_playlist', $id_playlist);
				$sql_addSongs->execute();
			}
		}
		catch(Exception $e)
		{
					echo '<span style = "color:red;">Server error!</span>';
			echo '<br/> Info: '.$e;
		}

		header('location: /src/webApp/mainPage/mainPage.php#page3');
		
		
		} else {
			$allright = false;
			//$_SESSION['e_addplaylist']="Type the title and choose some songs from the list";
			header('Location: /src/webApp/mainPage/mainPage.php#page3');
		}
	}
	
if (isset($_GET['editplaylist'])) {
			$id_playlist = $_GET['editplaylist'];
			$_SESSION['id_playlist'] = $id_playlist;
			echo $_SESSION['id_playlist'];
			
			//echo $id_playlist;
			$songs_from_playlist = $db->prepare("SELECT media.media_title, playlist_positions.id_song FROM media INNER JOIN playlist_positions ON media.id_media=playlist_positions.id_song WHERE playlist_positions.id_playlist=:id");
			//$songs_from_playlist = $db->prepare("SELECT * FROM playlists WHERE id_playlist=:id");
			$songs_from_playlist->bindParam(':id', $id_playlist);
			$songs_from_playlist->execute();
			
			$_SESSION['songs_titles'] = array();
			$_SESSION['songs_id'] = array();
			while($songs = $songs_from_playlist->fetch(PDO::FETCH_ASSOC)) {
				array_push($_SESSION['songs_titles'],$songs['media_title']);
				array_push($_SESSION['songs_id'],$songs['id_song']);
			}
			echo json_encode($_SESSION['songs_titles']);
			echo json_encode($_SESSION['songs_id']);
			
			header('Location: /src/webApp/mainPage/mainPage.php#page5');
}

if (isset($_GET['deletesong'])) {
	$id_song = $_GET['deletesong'];
	echo $id_song;
	echo $_SESSION['id_playlist'];
	
	$delete_song = $db->prepare("DELETE FROM playlist_positions WHERE id_song = :id_s AND id_playlist = :id_p");
	$delete_song->bindParam(':id_s', $id_song);
	$delete_song->bindParam(':id_p', $_SESSION['id_playlist']);
	$delete_song->execute();
	
	header('Location: /src/webApp/mainPage/mainPage.php#page3');
	
}
	
if (isset($_POST['add_new_songs'])) {
	if (!empty($_POST['add_new_songs'])) {
		
		$allright=true;
		
		$check_list = $_POST['add_new_songs'];
		echo json_encode($check_list);
		$id_user = $_SESSION['id_user'];
		echo $id_user;
		$id_playlist = $_SESSION['id_playlist'];
		echo $id_playlist;
		
		try{
			foreach ($check_list as $value) {
				$sql_addSongs =$db->prepare("INSERT INTO playlist_positions (id_song, id_playlist) VALUES (:id_song, :id_playlist)");
				$sql_addSongs->bindParam(':id_song', $value);
				$sql_addSongs->bindParam(':id_playlist', $id_playlist);
				$sql_addSongs->execute();
			}
		}
		catch(Exception $e)
		{
					echo '<span style = "color:red;">Server error!</span>';
			echo '<br/> Info: '.$e;
		}

		header('location: /src/webApp/mainPage/mainPage.php#page3');
		
		
		} else {
			$allright = false;
			$_SESSION['e_addnewsongs']="Choose some songs from the list";
			header('Location: /src/webApp/mainPage/mainPage.php#page5');
		}
	}

if(isset($_GET['playlist'])) {
	$id_playlist = $_GET['playlist'];

	$music = $db->prepare("SELECT id_song FROM playlist_positions WHERE id_playlist=:id");
	$music->bindParam(":id", $_GET['playlist']);
	$music->execute();
								
	$id_songs = array();
	while ($row = $music->fetch(PDO::FETCH_ASSOC)){
		//echo $row['id_song'];
		array_push($id_songs, $row['id_song']);
		}
								
	//echo json_encode($id_songs);
				
	$title_array = array();
	$music_array = array();
	$cover_array = array();
	foreach($id_songs as $value) {
		$song = $db->prepare("SELECT * FROM media WHERE id_media=:id");
		$song->bindParam(":id", $value);
		$song->execute();
		while ($row = $song->fetch(PDO::FETCH_ASSOC)){
			array_push($music_array, $row['file_name']);
			array_push($title_array, $row['media_title']);
			array_push($cover_array, $row['media_cover']);
			}
		}
	$_SESSION['playlist_songs'] = $music_array;
	$_SESSION['playlist_titles'] = $title_array;
	$_SESSION['playlist_covers'] = $cover_array;
	
	//echo json_encode($_SESSION['playlist_songs']);
	//echo json_encode($_SESSION['playlist_titles']);
	header('Location: /src/webApp/mainPage/mainPage.php#page1');
}	

if (isset($_GET['deleteplaylist'])) {
	$delete_pos = $db->prepare("DELETE FROM playlist_positions WHERE id_playlist=:id");
	$delete_pos->bindParam('id', $_GET['deleteplaylist']);
	$delete_pos->execute();
	
	$delete_playlist = $db->prepare("DELETE FROM playlists WHERE id_playlist=:id");
	$delete_playlist->bindParam('id', $_GET['deleteplaylist']);
	$delete_playlist->execute();
	
	header('Location: /src/webApp/mainPage/mainPage.php#page3');
}

if (isset($_GET['track'])) {
	$get_track = $db->prepare("SELECT file_name FROM media WHERE id_media=:id");
	$get_track->bindParam('id', $_GET['track']);
	$get_track->execute();
	
	while($row = $get_track->fetch(PDO::FETCH_ASSOC)){
		$file_name = $row['file_name'];
	}
	
	$_SESSION['chosen_track'] = $file_name;
	
	header('Location: /src/webApp/mainPage/mainPage.php#page2');
}

if (isset($_GET['editsong'])) {
	$song_id = $_GET['editsong'];
	$get_song = $db->prepare("SELECT * FROM media WHERE id_media=:id");
	$get_song->bindParam('id', $song_id);
	$get_song->execute();
	
	$song_info = array();
	while ($row = $get_song->fetch(PDO::FETCH_ASSOC)){
		array_push($song_info, $row['id_media']);
		array_push($song_info, $row['media_title']);
		array_push($song_info, $row['media_cover']);
		array_push($song_info, $row['review_counter']);
		}
		
	$song_reviews = $db->prepare("SELECT reviews.id_review, reviews.review_text, reviews.id_media, media.id_media, reviews.id_user, users.id_user, users.login FROM reviews INNER JOIN media ON media.id_media = reviews.id_media INNER JOIN users ON reviews.id_user = users.id_user WHERE media.id_media=:id");
	$song_reviews->bindParam(':id', $song_id);
	$song_reviews->execute();
	
	$_SESSION['reviews_user'] = array(); 
	$_SESSION['song_reviews'] = array(); 
	$_SESSION['review_id'] = array(); 
	while($reviews = $song_reviews->fetch(PDO::FETCH_ASSOC)) {
	array_push($_SESSION['song_reviews'],$reviews['review_text']); 
	array_push($_SESSION['reviews_user'],$reviews['login']); 
	array_push($_SESSION['review_id'],$reviews['id_user']); 
	}
	echo json_encode($_SESSION['review_id']);
	$_SESSION['song_info'] = $song_info;
	header('Location: /src/webApp/mainPage/mainPage.php#page8');
}

if(isset($_POST['upload'])){
	$id_song = $_SESSION['song_info'][0];
	
	$uploadOk = 1;
	
	if($_FILES["upload_cover"]['size'] != 0) {
		$path_cover = "../covers/accepted_covers";
	}

	if($_FILES["upload_cover"]['size'] != 0) { 
		$target_dir_cover = "../covers/accepted_covers/";
		$file_name_cover = basename($_FILES["upload_cover"]["name"]);
		$target_file_cover = $target_dir_cover . basename($_FILES["upload_cover"]["name"]);
		$uploadOk = 1;
		$imageFileType_cover = strtolower(pathinfo($target_file_cover,PATHINFO_EXTENSION));
		echo 'lol';
	}
	
	// Check title
	if(strlen($_POST['new_song_title'])<1) {
		$_SESSION['e_upload'] = 'Title of your masterpiece should have 5 - 30 characters!';
		$uploadOk = 0;
	}
	else {
		$new_song_title = $_POST['new_song_title'];
	}
	
	if($_FILES["upload_cover"]['size'] != 0) { 
		if($imageFileType_cover != "jpg" && $imageFileType_cover != "png" && $imageFileType_cover != "bmp"
		&& $imageFileType_cover != "gif" ) {
			$_SESSION['e_upload'] = 'Cover needs to have .jpg, .png, .bmp or .gif extension!';
			$uploadOk = 0;
		}
	}
	
	if ($uploadOk == 0)
		{
		$_SESSION['e_upload'] = 'Something went wrong, try again later!';
		// if everything is ok, try to upload file
		}
	else {
		$title=$db->prepare("UPDATE media SET media_title = :title WHERE id_media=:media");
		$title->bindParam(':title', $new_song_title);
		$title->bindParam(':media', $id_song);
		$title->execute();
		
		
		if (move_uploaded_file($_FILES["upload_cover"]["tmp_name"], $target_file_cover)){
			$update = $db->prepare("UPDATE media SET media_cover = :cover WHERE id_media=:media");
			$update->bindParam(':cover', $file_name_cover);
			$update->bindParam(':media', $id_song);
			$update->execute();			
			
		}
	}
	header('Location: ../../mainPage/mainPage.php#page3');
}

?>