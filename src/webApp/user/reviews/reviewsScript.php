<?php

SESSION_START();
include_once '../../../connection/connectWithDB.php';
if (isset($_POST['review'])) {
    $allright = true;
    $review   = $_POST['review'];
	$user = $_SESSION["id_user"];
	
    if ((strlen($review) < 3)) {
        $allright = false;
        $_SESSION['e_review'] = "If you want to add new review, this field cannot be empty! </br>Proper length of your review should be between 3 and 500 characters";
        header('Location: /src/webApp/mainPage/mainPage.php#page4');
    }
    
    if ((strlen($review) > 500)) {
        $allright = false;
        $_SESSION['e_review'] = "We are sorry, but this review is too long. </br>Proper length of your review should be between 3 and 500 characters";
        header('Location: /src/webApp/mainPage/mainPage.php#page4');
    }
    
    $id_media = $_GET['type'];
    
	
	$if_review = $db->prepare("SELECT * FROM reviews WHERE id_media = :id_media AND id_user = :user");
	$if_review->bindParam(':id_media', $id_media);
	$if_review->bindParam(':user', $user);
    $if_review->execute();
	
	
	
    try {
        require_once '../../../connection/connectWithDB.php';
        if($if_review->rowCount() == 0)
		{
        if ($allright == true) {
            
            $result = $db->prepare("INSERT INTO reviews (review_text, id_media, id_user) VALUES (:review,:id_media,:user)");
            $result->bindParam(':review', $review);
            $result->bindParam(':id_media', $id_media);
			$result->bindParam(':user', $user);
            $result->execute();
			
			$add_resources = $db->prepare("UPDATE users SET user_resources = user_resources + 100 WHERE id_user = :user");
			$add_resources->bindParam(':user', $user);
            $add_resources->execute();
			
            
            
            $_SESSION['review_added'] = true;
            
            header('Location: /src/webApp/mainPage/mainPage.php#page4');
            
        }
		}
		else {
			
		}
    }
    catch (Exception $e) {
        echo '<span style="color:red;">Server ERROR!</span>';
        echo '<br />Info: ' . $e;
    }
}


if (isset($_GET['vote'])) {
    $id_media = $_GET['vote'];
    $alright  = true;
    $user = $_SESSION["id_user"];
	
	$if_voted = $db->prepare("SELECT * FROM votes WHERE id_media = :id_media AND id_user = :user");
	$if_voted->bindParam(':id_media', $id_media);
	$if_voted->bindParam(':user', $user);
    $if_voted->execute();

    try {
		if($if_voted->rowCount() == 0)
		{
        if ($alright == true) {
            $vote = $db->prepare("UPDATE media SET review_counter = review_counter + 1 WHERE id_media = :id_media");
            $vote->bindParam(':id_media', $id_media);
            $vote->execute();
			
			$result = $db->prepare("INSERT INTO votes (id_media, id_user) VALUES (:id_media,:user)");
            $result->bindParam(':id_media', $id_media);
			$result->bindParam(':user', $user);
            $result->execute();
			
			$add_resources = $db->prepare("UPDATE users SET user_resources = user_resources + 10 WHERE id_user = :user");
			$add_resources->bindParam(':user', $user);
            $add_resources->execute();
			
			
            header('location: /src/webApp/mainPage/mainPage.php#page4');
        }
		}
        
    }
    catch (Exception $e) {
        echo '<span style = "color:red;">Server error!</span>';
        echo '<br/> Info: ' . $e;
    }
}

?>
