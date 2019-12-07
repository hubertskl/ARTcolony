

<?php
session_start();
require_once '../../connection/connectWithDB.php';
echo'<div id = "info"> <div id = "user_name" class = "user_name">';
if(isset($_SESSION['user_login'])) {
	$user_login= $_SESSION['user_login'][0];
	$user_pictrue= $_SESSION['user_pic'][0];
	$user_id= $_SESSION['user_id'][0];
	echo '<p class ="user_login" >' . $user_login . ' &nbsp;</p>';
?>	
	<div class="users_photos">
            <img class="users_photos_style"
                 src="../user/uploads/<?php echo $user_id; ?>/user_photo/<?php echo $user_pictrue; ?>"  alt="user_photo">
                    </div>
<?php

}
echo '</div>';
if(isset($_SESSION['user_name'])) {
	$user_name= $_SESSION['user_name'][0];
}

if(isset($_SESSION['reviews_text']) && !empty($_SESSION['reviews_text'])) {
	$reviews_text= $_SESSION['reviews_text'];
	$review_media_title = $_SESSION['review_media_title'];
	$user_name= $_SESSION['user_name'][0];
	echo '<p class ="user_name" >' . $user_name . ' `s reviews:</p><br>';
	
	foreach (array_combine($_SESSION['reviews_text'], $_SESSION['review_media_title']) as $tvalue => $mvalue){
		echo '<h2>' . $mvalue . '&nbsp; &nbsp; &nbsp;'.  $tvalue  . ' </h2></br>';
	}
}

else  {	
	$user_name= $_SESSION['user_name'][0];
	echo '<p class ="user_name" >' . $user_name . ' hasn`t upload any review yet</p><br>';
}
echo '</div>';


if(isset($_SESSION['songs_titles']) && !empty($_SESSION['songs_titles'])) {
	
	$songs_titles= $_SESSION['songs_titles'];
	echo '<div id = "users_songs">';
	
	if(isset($_SESSION['user_name'])) {
	$user_name= $_SESSION['user_name'][0];
	echo '<p class ="user_name" >' . $user_name . ' `s songs:</p><br>';
}
	
	foreach($songs_titles as $value) {
		
		echo '<h2>' . $value . ' </h2></br>';	
	}
	echo '</div>';
	
} 

else  {	
	echo '<div id = "users_songs">';
	$user_name= $_SESSION['user_name'][0];
	echo '<p class ="user_name" >' . $user_name . ' hasn`t upload any song yet</p><br>';
	echo '</div>';
}
		
?>
			
