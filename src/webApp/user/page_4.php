	<div id= "songs">
<form action="page_4.php" method="post" id="search" >
	<div id="input-data">
        <input type="text" name="search_data" placeholder= "Search for..." ></div>
    </form>

			<?php		
	session_start();
		include_once '../../connection/connectWithDB.php';
		$sql = "SELECT id_media, media_title, review_counter FROM media ORDER BY id_media LIMIT 5";
		$result = $db->query($sql);

		while ( $row = $result->fetch(PDO::FETCH_ASSOC))
		{
		echo'
		<div id= "display_songs" class ="name"><a href = "#"  class = "song_title"'.$row['media_title'].'" > </a>
		';
		echo '<p>'.$row["media_title"].'</p>';
		echo'<a href = "../user/reviews/reviewsScript.php?vote='.$row["id_media"].'">
		<button type = "submit" name = "vote" input id="btn" class="btn">Great</button></a>';
		echo'

		<p>'.$row["review_counter"].'</p></br>';
		echo '	<div id="reviews-container">
				<div id="panel" >

						<form action= "../user/reviews/reviewsScript.php?type='.$row["id_media"].'" method="post">
						<textarea rows = "5" cols = "35" id="review" type = "text" name="review" placeholder="Insert your review here"></textarea></br></br>
						<div class="add_button"><input type="submit" value="Send"></div>';
						
						
						if(isset($_SESSION['e_review']))
						{
							echo '<h3>'.$_SESSION['e_review'].'</h3>';
							unset($_SESSION['e_review']);
						}

		echo'
					</form>
					
				</div>
	</div></div>';
		} 
		
		?>
	</div>
	
	<div id = "recent">
	<p> Recent reviews </p></br>
	<?php		

		include_once '../../connection/connectWithDB.php';
		$sql = "SELECT reviews.id_review, media.media_title, reviews.review_text, media.id_media, reviews.id_media FROM media INNER JOIN reviews ON media.id_media = reviews.id_media ORDER BY id_review DESC LIMIT 5";
		$result = $db->query($sql);

		while ( $row = $result->fetch(PDO::FETCH_ASSOC))
		{
			echo '<h2>'.$row["media_title"].' </h2>';
			echo' <p>'.$row["review_text"].'</p></br>';
			
			} 
		
		?>

</div>