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
<div class="shop-container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="title-box"></div>
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
                //$mediaBox = $selectQuery->fetch();

                while($mediaBox = $selectQuery->fetch()) {
                    $mediaID=$mediaBox['id_media'];
                    ?>
                    <div class="card-box col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
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
                echo '<div class="alert alert-danger">You have this media in your orders!</div>';
                unset($_SESSION['bad_shop']);
            }
            if (isset($_SESSION['bad_media_bought']))
            {
                echo '<span style="color:red;">You have this media!</span>';
                unset($_SESSION['bad_media_bought']);
            }
            ?>

        </div>
    </div>

</div>
</body>
</html>