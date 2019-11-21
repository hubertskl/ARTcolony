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
    
    try {
        require_once '../../../connection/connectWithDB.php';
        
        if ($allright == true) {
            
            $result = $db->prepare("INSERT INTO reviews (review_text, id_media, id_user) VALUES (:review,:id_media,:user)");
            $result->bindParam(':review', $review);
            $result->bindParam(':id_media', $id_media);
			$result->bindParam(':user', $user);
            $result->execute();
            
            
            $_SESSION['review_added'] = true;
            
            header('Location: /src/webApp/mainPage/mainPage.php#page4');
            
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
    
    try {
        if ($alright == true) {
            $vote = $db->prepare("UPDATE media SET review_counter = review_counter + 1 WHERE id_media = :id_media");
            $vote->bindParam(':id_media', $id_media);
            $vote->execute();
            header('location: /src/webApp/mainPage/mainPage.php#page4');
        }
        
    }
    catch (Exception $e) {
        echo '<span style = "color:red;">Server error!</span>';
        echo '<br/> Info: ' . $e;
    }
}

?>
