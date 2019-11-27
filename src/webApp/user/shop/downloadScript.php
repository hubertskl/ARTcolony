<?php
SESSION_START();
if (!isset($_SESSION['logged_id']))
{
    header('Location: ../login/login.php');
    exit();
}
if($_GET['id']){
    $_SESSION['Empty_file'] = false;
    $mediaID = $_GET['id'];
    require_once '../../../connection/connectWithDB.php';
    $selectQuery = $db->prepare('SELECT * FROM media WHERE id_media=:id');
    $selectQuery->bindParam(':id', $mediaID);
    $selectQuery->execute();
    $mediainfo = $selectQuery->fetch();
    echo $mediainfo['file_name'];

    $filename=$mediainfo['file_name'];
    $path = '../uploads/accepted_music/';
    $f=$filename;
    $file = "../uploads/accepted_music/$f";
    echo $file;
    if (file_exists($file)) {
        $filetype=filetype($file);

        $filename=basename($file);

        header ("Content-Type: ".$filetype);

        header ("Content-Length: ".filesize($file));

        header ("Content-Disposition: attachment; filename=".$filename);

        readfile($file);
        header('Location: main-shop-page.php');
         exit();

    }
    else{
        $_SESSION['Empty_file'] = true;
        header('Location: main-shop-page.php');
        exit();
    }

}

?>
