<?php
SESSION_START();
if (!isset($_SESSION['logged_id'])) 
{
	header('Location: ../login/login.php');
	exit();
}
	if($_SESSION['login']=='admin' && $_SESSION['is_admin']=='1')
	{
		header('Location: ../admin/adminHome.php');
	}
	
	require_once '../../connection/connectWithDB.php';
	
	$id = $_SESSION['id_user'];
	$path = "uploads/$id";
	if (!file_exists($path)) {
		mkdir($path, 0777, true);
		}
		
	/* cover feature */
	if($_FILES["upload_cover"]['size'] != 0) {
		$path_cover = "covers/$id";
		if (!file_exists($path_cover)) {
			mkdir($path_cover, 0777, true);
			}
	}
	/* cf */
		
	$target_dir = "uploads/$id/";
	$file_name = basename($_FILES["upload_music"]["name"]);
	$target_file = $target_dir . basename($_FILES["upload_music"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	
	/* cover feature */
	if($_FILES["upload_cover"]['size'] != 0) { 
		$target_dir_cover = "covers/$id/";
		$file_name_cover = basename($_FILES["upload_cover"]["name"]);
		$target_file_cover = $target_dir_cover . basename($_FILES["upload_cover"]["name"]);
		$uploadOk = 1;
		$imageFileType_cover = strtolower(pathinfo($target_file_cover,PATHINFO_EXTENSION));
	}
	/* cf */
	
	// Check title
	if(strlen($_POST['song_title'])<1) {
		$_SESSION['e_upload'] = 'Title of your masterpiece should have 5 - 30 characters!';
		$uploadOk = 0;
	}
	else {
		$song_title = $_POST['song_title'];
	}
	
	// Check
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["upload_music"]["tmp_name"]);
		if($check !== false) {
			$uploadOk = 1;
		} else {
			$_SESSION['e_upload'] = 'File needs to be less than 15MB!';
			$uploadOk = 0;
		}
	}
	
	// Check if file already exists
	if (file_exists($target_file)) {
		$_SESSION['e_upload'] = 'Song with this name already exists in your library!';
		$uploadOk = 0;
	}
	if($_FILES["upload_cover"]['size'] != 0) { 
		if (file_exists($target_file_cover)) {
			$_SESSION['e_upload'] = 'Cover with this name already exists in your library!';
			$uploadOk = 0;
		}
	}
	// Allow certain file formats
	if($imageFileType != "mp3" && $imageFileType != "wav" && $imageFileType != "aac"
	&& $imageFileType != "flac" ) {
		$_SESSION['e_upload'] = 'File needs to have .mp3, .wav, .aac or .flac extension!';
		$uploadOk = 0;
	}
	if($_FILES["upload_cover"]['size'] != 0) { 
		if($imageFileType_cover != "jpg" && $imageFileType_cover != "png" && $imageFileType_cover != "bmp"
		&& $imageFileType_cover != "gif" ) {
			$_SESSION['e_upload'] = 'Cover needs to have .jpg, .png, .bmp or .gif extension!';
			$uploadOk = 0;
		}
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0)
		{
		$_SESSION['e_upload'] = 'Something went wrong, try again later!';
		// if everything is ok, try to upload file
		}
	else {
			if (move_uploaded_file($_FILES["upload_music"]["tmp_name"], $target_file))
			{
				$_SESSION['s_upload'] = 'Your song was transferred successfuly!';
				$everything_ok = true;
				try {
						if ($everything_ok==true) {
							if($_FILES["upload_cover"]['size'] == 0) {
							
							// those values are only for now - to be changed
							$cost = 100;
							$cover = 'default.png';
							$accepted = 0;
							$review_counter = 0;
							// -----
							
							$ready_music = $db->prepare("INSERT INTO media (media_title, media_cost, media_cover, id_owner, is_accepted, review_counter, file_name) VALUES(:title, :cost, :cover, :id, :accepted, :counter, :file)");
							$ready_music->bindParam(':title', $song_title);
							$ready_music->bindParam(':cost', $cost);
							$ready_music->bindParam(':cover', $cover);
							$ready_music->bindParam(':id', $id);
							$ready_music->bindParam(':accepted', $accepted);
							$ready_music->bindParam(':counter', $review_counter);
							$ready_music->bindParam(':file', $file_name);
							$ready_music->execute();
							}
							else {
								if (move_uploaded_file($_FILES["upload_cover"]["tmp_name"], $target_file_cover)){
										// those values are only for now - to be changed
									$cost = 100;
									$cover = $file_name_cover;
									$accepted = 0;
									$review_counter = 0;
									// -----
									
									$ready_music = $db->prepare("INSERT INTO media (media_title, media_cost, media_cover, id_owner, is_accepted, review_counter, file_name) VALUES(:title, :cost, :cover, :id, :accepted, :counter, :file)");
									$ready_music->bindParam(':title', $song_title);
									$ready_music->bindParam(':cost', $cost);
									$ready_music->bindParam(':cover', $cover);
									$ready_music->bindParam(':id', $id);
									$ready_music->bindParam(':accepted', $accepted);
									$ready_music->bindParam(':counter', $review_counter);
									$ready_music->bindParam(':file', $file_name);
									$ready_music->execute();
								}
							}
						}
				}
				catch(Exception $e) {
					echo 'Server error!';
				}
				header('Location: ../mainPage/mainPage.php#page2');
			}
		else
			{
				$_SESSION['e_upload'] = 'Something went wrong, try again later!';
				header('Location: ../mainPage/mainPage.php#page2');
			}
	}
	header('Location: ../mainPage/mainPage.php#page2');
?>