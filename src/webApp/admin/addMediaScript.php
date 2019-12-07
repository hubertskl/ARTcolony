<?php
if($_GET['id']) {
    require_once '../../connection/connectWithDB.php';
    $idMedia = $_GET['id'];
    $value = 1;
    $selectMedia=$db->prepare('SELECT * FROM media WHERE id_media=:id_m');
    $selectMedia->bindParam('id_m', $idMedia);
    $selectMedia->execute();
    $selectMediaData = $selectMedia->fetch();
    $ownerID=$selectMediaData['id_owner'];
    $mediaFileName=$selectMediaData['file_name'];
	$mediaCoverName=$selectMediaData['media_cover'];

    if($selectMedia){
        $path = "../user/uploads/$ownerID/$mediaFileName";
        $newPath ="../user/uploads/accepted_music/$mediaFileName";
		$pathCover = "../user/covers/$ownerID/$mediaCoverName";
        $newPathCover ="../user/covers/accepted_covers/$mediaCoverName";
        echo file_exists($path);
        if (file_exists($path)) {
            rename ($path,$newPath);
            $changePlace=1;
            if($changePlace=1){
                $updateMedia=$db->prepare('UPDATE media SET is_accepted=:value1 WHERE id_media=:id_m');
                $updateMedia->bindParam('value1', $value);
                $updateMedia->bindParam('id_m', $idMedia);
                $updateMedia->execute();
				
				
				$updateResources=$db->prepare('UPDATE users SET user_resources = user_resources + 200 WHERE id_user=:user');
                $updateResources->bindParam(':user', $ownerID);
                $updateResources->execute();
            }
			
			if (file_exists($pathCover)) {
				rename ($pathCover,$newPathCover);
			}
			
        }
        header('Location: adminHome.php');
        exit();
    }
}
else{
    $_SESSION['bad_accept'] = true;
    header('Location: adminHome.php');
    exit();
}

?>
