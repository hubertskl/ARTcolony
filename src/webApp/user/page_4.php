<div id= "songs">
     
		<p class = "songs"> Here, you can search a song and add a review or vote.</br>You will receive 300 points for writing a review and 10 points for voting. </br>Remember: one song = one review </br> Proper length of your review should be between 3 and 500 characters, enjoy!</p></br>
		<input type="text" id = "search" placeholder= "Search for..." >

<br>
<div id="feedback"></div>

	<script type="text/javascript" src="../user/reviews/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src = "../user/reviews/custom.js"></script>
	
</div>
    
<div id = "recent">
    <p class = "recent"> Recent reviews </p></br>
	
<?php
SESSION_START();
		include_once '../../connection/connectWithDB.php';
		$sql    = "SELECT reviews.id_review, media.media_title, reviews.review_text, media.id_media, reviews.id_media, reviews.id_user, users.id_user, users.name FROM media INNER JOIN reviews ON media.id_media = reviews.id_media INNER JOIN users ON reviews.id_user= users.id_user ORDER BY id_review DESC LIMIT 5";
		$result = $db->query($sql);

		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			echo '<h2>' . $row["media_title"] . ' </h2>';
			echo ' <h1 class="right"> <form action = "../user/home/user_profile.php?id=' . $row["id_user"]. '" method="post" class="id_user">
					<input type = "submit" id="btn" class="btn" value = " ' . $row["name"]. '" ></input> </br> </form> </p></br></h1></br>';
			echo ' <p>' . $row["review_text"] . '</p></br>';
			
			
		}
?>

</div>

<script>
	$(".id_user").submit(function(e) {

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
			   
               window.location.href = "/src/webApp/mainPage/mainPage.php#page6"; 
		
           }
         });
		e.preventDefault();

});
	
</script>	