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

    if($selectMedia){
        $path = "../user/uploads/$ownerID/$mediaFileName";
        $newPath ="../user/uploads/accepted_music/$mediaFileName";
        echo file_exists($path);
        if (file_exists($path)) {
            rename ($path,$newPath);
            $changePlace=1;
            if($changePlace=1){
                $updateMedia=$db->prepare('UPDATE media SET is_accepted=:value1 WHERE id_media=:id_m');
                $updateMedia->bindParam('value1', $value);
                $updateMedia->bindParam('id_m', $idMedia);
                $updateMedia->execute();
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
