

<?php
session_start();
require_once '../../connection/connectWithDB.php';
echo'<div id = "song_info">';
echo'<div id = "song_title_cover">';
if(isset($_SESSION['song_title'])) {
	
	$title= $_SESSION['song_title'][0];
	echo '<p class ="song_title_cover" >' . $title . '</p></br>';
}

if(isset($_SESSION['song_cover'])) {
	
	$cover= $_SESSION['song_cover'][0];
} 
?>	
	<div class="songs_covers">
            <img class="songs_covers_style"
                 src="../user/covers/accepted_covers/<?php echo $cover; ?>"  alt="user_photo">
                    </div>
<?php
echo '</div>';
echo'<div id = "song_spec">';
if(isset($_SESSION['song_owner'])) {
	
	$owner= $_SESSION['song_owner'][0];
	echo '<p class ="song_inf2" >Song uploaded by &nbsp; &nbsp; &nbsp;</p><p class ="song_inf" >' . $owner . '</p></br>';
}

if(isset($_SESSION['song_votes'])) {
	
	$votes= $_SESSION['song_votes'][0];
	echo '<p class ="song_inf2" > This song gained &nbsp; &nbsp; &nbsp;</p><p class ="song_inf" >' . $votes . ' votes </p></br>';
} 


if(isset($_SESSION['song_reviews']) && !empty($_SESSION['song_reviews'])) {
	echo '<p class ="song_inf_rev" >' . $title. ' reviews</p><br>';
	$song_reviews= $_SESSION['song_reviews'];
	$review_user = $_SESSION['reviews_user'];

	foreach (array_combine($song_reviews, $review_user) as $uvalue => $svalue){
		echo '<p class ="song_inf2" >' . $svalue . '</p></br><p class ="song_inf" >'.  $uvalue  . ' </p></br>';
	}
}

else  {	
	echo '<p class ="song_inf" >' . $title. ' doesn`t have any review yet</p><br>';
}


echo '</div>';	
echo '</div>';		
?>
	
