<?php
SESSION_START();
if (!isset($_SESSION['logged_id']))
{
    header('Location: ../login/login.php');
    exit();
}
if($_SESSION['login']=='admin' && $_SESSION['is_admin']=='1')
{
    header('Location: ../../admin/adminHome.php');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ARTcolony</title>
    <!--STYLE-->
    <link rel="stylesheet" type="text/css" href="../../mainWebStyle/mainWebStyle.css">
    <link rel="stylesheet" type="text/css" href="shop-style/shopStyle.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<div id="main-shop-container" class="shop-container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="title-box"></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 resource-nav">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 resource-nav-item">your resources:
                <?php
                if($_SESSION['id_user']) {
                    $id = $_SESSION['id_user'];
                    require_once '../../../connection/connectWithDB.php';
                    $resultResource=$db->prepare('SELECT * FROM users WHERE  id_user=:id');
                    $resultResource->bindParam(':id',$id);
                    $resultResource->execute();
                    $userResources = $resultResource->fetch();
                    echo $userResources['user_resources'];
                }
                ?>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 main-top-nav">
                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 title-back">
                    <a href="../../mainPage/mainPage.php#page1">BACK</a>
                </div>
                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 title-shop">SHOP</div>
                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 title-order">
                    <a href="userOrders.php">ORDERS</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="row">
                <?php
                if(isset($_SESSION['logged_id'])){
                require_once '../../../connection/connectWithDB.php';
                $userID=$_SESSION['id_user'];
                $acceptedValue=1;
                $selectQuery = $db->prepare('SELECT * FROM media WHERE id_owner <> :user_id AND is_accepted=:accValue'); /* "<>" means in sql !=*/
                $selectQuery->bindParam(':user_id', $userID);
                $selectQuery->bindParam(':accValue', $acceptedValue);
                $selectQuery->execute();

                while($mediaBox = $selectQuery->fetch()) {
                    $mediaID=$mediaBox['id_media'];
                    ?>
                    <div class="card-box col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                    <div class="card">
                      <!-- <img class="card-img-top" src="<?php echo $mediaBox['media_cover']; ?>" alt="<?php echo $mediaBox['media_title']; ?>">-->
                        <div class="card-body">
                            <h5 class="card-title">Title: <?php echo $mediaBox['media_title']; ?></h5>
                            <h6 class="card-title">Price: <?php echo $mediaBox['media_cost'];?></h6>
                            <!--<p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of
                                the card's content.</p>-->
                            <div class="card-button-style">
                              <a class="btn btn-outline-secondary add-button-style" href="orderScript.php?id=<?php echo $mediaID ?>">add</a>
                            </div>
                        </div>
                    </div>
                    </div><?php }} ?>
            </div>
            <?php
            if (isset($_SESSION['bad_shop']))
            {
                echo '<div class="alert alert-danger alert-dismissible fade show">You have this media in your orders!
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                unset($_SESSION['bad_shop']);
            }
            if (isset($_SESSION['bad_media_bought']))
            {
                echo '<div class="alert alert-danger alert-dismissible fade show">You have this media!
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                unset($_SESSION['bad_media_bought']);
            }
            if (isset($_SESSION['Empty_file'])) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">administrator has not 
                        accepted the song yet or is not in the folder
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                unset($_SESSION['Empty_file']);
            }

            ?>
        </div>
        <div id="download-music-container" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 resource-nav">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 resource-item">
                    <span>Here you can download your music files</span>
                </div>
            </div>
            <div class="row">
                <?php
                if(isset($_SESSION['logged_id'])){
                    require_once '../../../connection/connectWithDB.php';
                    $idUser=$_SESSION['id_user'];
                    $valueAccepted=1;
                    $selectQueryAllmedia = $db->prepare('SELECT * FROM media WHERE id_owner=:user_id AND is_accepted=:accValue');
                    $selectQueryAllmedia->bindParam(':user_id', $idUser);
                    $selectQueryAllmedia->bindParam(':accValue', $valueAccepted);

                    $selectQueryAllmedia->execute();

                    while($mediaBoxDownload = $selectQueryAllmedia->fetch()) {
                        $mediaIDdownload=$mediaBoxDownload['id_media'];
                        ?>
                        <div class="card-box col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                        <div class="card">
                            <!-- <img class="card-img-top" src="<?php echo $mediaBoxDownload['media_cover']; ?>" alt="<?php echo $mediaBoxDownload['media_title']; ?>">-->
                            <div class="card-body">
                                <h5 class="card-title">Title: <?php echo $mediaBoxDownload['media_title']; ?></h5>
                                <div class="card-button-style">
                                    <a class="btn btn-outline-secondary add-button-style" href="downloadScript.php?id=<?php echo $mediaIDdownload ?>">download</a>
                                </div>
                            </div>
                        </div>
                        </div><?php }
                    $selectBoughtMedia = $db->prepare('SELECT * FROM bought_media WHERE id_user=:user_id ');
                    $selectBoughtMedia->bindParam(':user_id', $idUser);
                    $selectBoughtMedia->execute();
                    $mediaBoxBoughtDownload = $selectBoughtMedia->fetch();
                    $mediaIDBoughtdownload=$mediaBoxBoughtDownload['id_media'];

                    $selectInfoBoughtMedia=$db->prepare('SELECT * FROM media WHERE id_media=:media_id ');
                    $selectInfoBoughtMedia->bindParam(':media_id', $mediaIDBoughtdownload);
                    $selectInfoBoughtMedia->execute();
                     while($infoMedia=$selectInfoBoughtMedia->fetch()) {
                      $newIDMedia = $infoMedia['id_media'];
                         ?>
                        <div class="card-box col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
                            <div class="card">
                                <!-- <img class="card-img-top" src="<?php echo $infoMedia['media_cover']; ?>" alt="<?php echo $infoMedia['media_title']; ?>">-->
                                <div class="card-body">
                                    <h5 class="card-title">Title: <?php echo $infoMedia['media_title']; ?></h5>
                                    <div class="card-button-style">
                                        <a class="btn btn-outline-secondary add-button-style" href="downloadScript.php?id=<?php echo $newIDMedia ?>">download</a>
                                    </div>
                                </div>
                            </div>
                        </div><?php
                        }
                        } ?>
            </div>

        </div>

    </div>

</div>
</body>
</html>