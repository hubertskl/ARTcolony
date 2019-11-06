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
<div class="orders-container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="title-box"></div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 top-nav">
                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 title-back">
                    <a href="main-shop-page.php">BACK</a>
                </div>
                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 title-shop">ORDERS</div>
            </div>

            </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="table-responsive">
            <table class="table table-striped table-dark table-hover table-sm table-text">
                <thead>
                <tr>
                    <th scope="col">order number</th>
                    <th scope="col">title</th>
                    <th scope="col">cost</th>
                    <th scope="col">action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if($_SESSION['id_user']) {
                    $id = $_SESSION['id_user'];
                    require_once '../../../connection/connectWithDB.php';
                    $result1=$db->prepare('SELECT * FROM orders INNER JOIN users ON orders.id_user = users.id_user INNER JOIN media ON orders.id_media = media.id_media INNER JOIN purchase ON users.id_user=purchase.id_user WHERE orders.`id_user` =:id');
                    $result1->bindParam(':id',$id);
                    $result1->execute();
                     if($result1) {
                            foreach ($result1 as $row) {
                                echo "<tr>
                                <td style='width: 10%'>" . $row['id_order'] . "</td>
                                <td style='width: 60%'>" . $row['media_title'] . "</td>
                                <td style='width: 10%'>" . $row['media_cost'] . "</td>
                                <td style='width: 20%'>
                                <a href='buyScript.php?id=" . $row['id_order'] . "'><button class='btn btn-outline-success' type='button'>BUY</button></a>
                                <a href='deleteScript.php?id=" . $row['id_order'] . "'><button class='btn btn-outline-danger' type='button'>CANCEL</button></a>
                                </td>";


                            }
                         $fetchResult1 = $result1->fetch();
                         $d1 = $fetchResult1['id_order'];
                         $r1=$db->prepare('SELECT * FROM orders INNER JOIN users ON orders.id_user = users.id_user INNER JOIN media ON orders.id_media = media.id_media INNER JOIN purchase ON users.id_user=purchase.id_user WHERE id_order=:id_o');
                         $r1->bindParam(':id_o',$d1);
                         $r1->execute();
                         $r2=$r1->fetch();
                      }
                }
                ?>


                </tbody></table>
            </div>
            <?php
            if (isset($_SESSION['delete_problem']))
            {
                echo '<span style="color:red;">Problem with delete order!</span>';
                unset($_SESSION['delete_problem']);
            }
            if (isset($_SESSION['low_resources']))
            {
                echo '<span style="color:red;">You dont have enought resources to buy!</span>';
                unset($_SESSION['low_resources']);
            }
            if (isset($_SESSION['problem_delete_order']))
            {
                echo '<span style="color:red;">Cant delete order!</span>';
                unset($_SESSION['problem_delete_order']);
            }
            ?>
        </div>

        </div>
    </div>
</div>
</body>
</html>