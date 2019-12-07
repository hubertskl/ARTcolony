<?php
if($_GET['id']) {
    require_once '../../connection/connectWithDB.php';
    $idMedia = $_GET['id'];
    $selectMedia=$db->prepare('SELECT * FROM media WHERE id_media=:id_m');
    $selectMedia->bindParam('id_m', $idMedia);
    $selectMedia->execute();
    $selectMediaData = $selectMedia->fetch();
    $ownerID=$selectMediaData['id_owner'];
    $mediaFileName=$selectMediaData['file_name'];

    if($selectMedia){
        $path = "../user/uploads/$ownerID/$mediaFileName";
        if (file_exists($path)) {
            unlink($path);
            $deletePlace=1;
            if($deletePlace=1){
                $deleteMedia=$db->prepare('UPDATE media SET is_accepted=-1 WHERE id_media=:id_m');
                $deleteMedia->bindParam('id_m', $idMedia);
                $deleteMedia->execute();
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
