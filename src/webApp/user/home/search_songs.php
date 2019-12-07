<?php 

include_once '../../../connection/connectWithDB.php';
$m=$_GET['usearch'];
$sql    = "SELECT id_media, media_title FROM media WHERE media_title LIKE '%$m%' AND is_accepted =1";
$result = $db->query($sql);
echo '<div id = "users_content">';
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
   
	  echo '<form action = "../user/home/song_profile.php?id=' . $row["id_media"] . '" method="post" class="id_song">
        <input type = "submit" id="btn" class="btn" value = " ' . $row["media_title"] . '" ></input> </br> </form>';
    
}
echo '</div>';
?>

<script>
	$(".id_song").submit(function(e) {

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
			   
               window.location.href = "/src/webApp/mainPage/mainPage.php#page9"; 
		
           }
         });
		e.preventDefault(); // avoid to execute the actual submit of the form.

});
	
</script>


