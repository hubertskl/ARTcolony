<?php 

include_once '../../../connection/connectWithDB.php';
$s=$_GET['usearch'];

$sql    = "SELECT id_media, media_title, review_counter FROM media WHERE media_title LIKE '%$s%'";
$result = $db->query($sql);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo '
        <div id= "display_songs" class ="name"><a href = "#"  class = "song_title"' . $row['media_title'] . '" > </a>
        ';
    echo '<p>' . $row["media_title"] . '</p>';
	
    echo '<form action = "../user/reviews/reviewsScript.php?vote=' . $row["id_media"] . '" method="post" class="voting">
        <input type = "submit" name = "vote" input id="btn" class="btn" value = "Great"></input>';
    echo '<p>' . $row["review_counter"] . '</p></br></form>';
    echo '    <div id="reviews-container">
                <div id="panel" >

                        <form action= "../user/reviews/reviewsScript.php?type=' . $row["id_media"] . '" method="post" class = "form_post">
                        <textarea rows = "5" cols = "35" id="add_review" type = "text" name="review" placeholder="Insert your review here"></textarea></br></br>
                        <div class="add_button"><input type="submit" value="Send"></div>';
        
    if (isset($_SESSION['e_review'])) {
        echo '<h3>' . $_SESSION['e_review'] . '</h3>';
        unset($_SESSION['e_review']);
    }
    
    echo '
                    </form>
                    
                </div>
    </div></div>';	
}
?>

<script>
	
	$(".form_post").submit(function(e) {

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
			   
               alert('Thanks! Your review is being processed'); 
				$('textarea').val('');
           }
         });
		e.preventDefault(); // avoid to execute the actual submit of the form.

});

	$(".voting").submit(function(e) {

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
			   
               alert('Thanks! Your vote is being processed!'); 
		
           }
         });
		e.preventDefault(); // avoid to execute the actual submit of the form.

});
	
</script>