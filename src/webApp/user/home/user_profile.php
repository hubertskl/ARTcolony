<?php 
session_start();
require_once '../../../connection/connectWithDB.php';



if (isset($_GET['id'])) {
			$id_user = $_GET['id'];
			$_SESSION['id'] = $id_user;
			echo $_SESSION['id'];
			
			$users_songs = $db->prepare("SELECT media_title, id_media FROM media  WHERE id_owner=:id");
			$users_songs->bindParam(':id', $id_user);
			$users_songs->execute();
			
			$_SESSION['songs_titles'] = array(); //assign all user's songs titles to an array, to use them at the user's page after
			$_SESSION['songs_id'] = array();
			while($songs = $users_songs->fetch(PDO::FETCH_ASSOC)) {
				array_push($_SESSION['songs_titles'],$songs['media_title']); //fill an array with content - here - user's songs
				array_push($_SESSION['songs_id'],$songs['id_media']);
			}
			//echo json_encode($_SESSION['songs_titles']);
			
			$users_reviews = $db->prepare("SELECT reviews.id_review, reviews.review_text, reviews.id_media, media.id_media, media.media_title FROM reviews INNER JOIN media ON  media.id_media = reviews.id_media  WHERE id_user=:id");
			$users_reviews->bindParam(':id', $id_user);
			$users_reviews->execute();
			
			$_SESSION['reviews_text'] = array();
			$_SESSION['reviews_id'] = array();
			$_SESSION['media_id'] = array();
			$_SESSION['review_media_title'] = array();
			while($reviews = $users_reviews->fetch(PDO::FETCH_ASSOC)) {
				array_push($_SESSION['reviews_text'],$reviews['review_text']);
				array_push($_SESSION['reviews_id'],$reviews['id_review']);
				array_push($_SESSION['media_id'],$reviews['id_media']);
				array_push($_SESSION['review_media_title'],$reviews['media_title']);
			}

			$users_info = $db->prepare("SELECT name, family_name, login FROM users  WHERE id_user=:id");
			$users_info->bindParam(':id', $id_user);
			$users_info->execute();
			
			$_SESSION['user_name'] = array();
			$_SESSION['user_family_name'] = array();
			$_SESSION['user_login'] = array();
			while($info = $users_info->fetch(PDO::FETCH_ASSOC)) {
				array_push($_SESSION['user_name'],$info['name']);
				array_push($_SESSION['user_family_name'],$info['family_name']);
				array_push($_SESSION['user_login'],$info['login']);
			}
			
			header('Location: /src/webApp/mainPage/mainPage.php#page6');
}
?>

