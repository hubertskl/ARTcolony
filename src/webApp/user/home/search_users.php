<?php 

include_once '../../../connection/connectWithDB.php';
$u=$_GET['usearch'];
$sql    = "SELECT id_user, login, name FROM users WHERE name OR login LIKE '%$u%' AND id_user !=1";
$result = $db->query($sql);
echo '<div id = "users_content">';
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
   
	  echo '<form action = "../user/home/user_profile.php?id=' . $row["id_user"] . '" method="post" class="id_user">
        <input type = "submit" id="btn" class="btn" value = " ' . $row["login"] . '" ></input> </br> </form>';
    
}
echo '</div>';
?>
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
		e.preventDefault(); // avoid to execute the actual submit of the form.

});
	
</script>


