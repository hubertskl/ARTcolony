<?php 
session_start();
require_once '../../../connection/connectWithDB.php';


if (isset($_GET['id'])) {
			$id_song = $_GET['id'];
			$_SESSION['id'] = $id_song;
			
			$song_info = $db->prepare("SELECT media.media_title, media.id_media, media.id_owner, media.media_cover, media.review_counter, users.id_user, users.login FROM media  INNER JOIN users ON users.id_user = media.id_owner WHERE id_media=:id");
			$song_info->bindParam(':id', $id_song);
			$song_info->execute();
			
			$_SESSION['song_title'] = array(); //assign all info about song  to an array, to use them at the songs's page after
			$_SESSION['song_cover'] = array(); 
			$_SESSION['song_votes'] = array(); 
			$_SESSION['song_owner'] = array(); 
			while($songs = $song_info->fetch(PDO::FETCH_ASSOC)) {
				array_push($_SESSION['song_title'],$songs['media_title']); //fill an array with content - here - info about song
				array_push($_SESSION['song_cover'],$songs['media_cover']);
				array_push($_SESSION['song_votes'],$songs['review_counter']);
				array_push($_SESSION['song_owner'],$songs['login']);
			}
			
			$song_reviews = $db->prepare("SELECT reviews.id_review, reviews.review_text, reviews.id_media, media.id_media, reviews.id_user, users.id_user, users.login FROM reviews INNER JOIN media ON media.id_media = reviews.id_media INNER JOIN users ON reviews.id_user = users.id_user WHERE media.id_media=:id");
			$song_reviews->bindParam(':id', $id_song);
			$song_reviews->execute();
			
			$_SESSION['reviews_user'] = array(); 
			$_SESSION['song_reviews'] = array(); 
			$_SESSION['review_id'] = array(); 
			while($reviews = $song_reviews->fetch(PDO::FETCH_ASSOC)) {
			array_push($_SESSION['song_reviews'],$reviews['review_text']); 
			array_push($_SESSION['reviews_user'],$reviews['login']); 
			array_push($_SESSION['review_id'],$reviews['id_user']); 
			}
			echo json_encode($_SESSION['reviews_user']);
			echo json_encode($_SESSION['review_id']);
			//header('Location: /src/webApp/mainPage/mainPage.php#page9');
}
?>

