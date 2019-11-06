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

if($_SESSION['id_user']) {

    require_once '../../../connection/connectWithDB.php';
    $idOrder = $_GET['id'];//order
    $userID=$_SESSION['id_user'];//user
    $selectQueryUser = $db->prepare('SELECT * FROM orders INNER JOIN users ON orders.id_user = users.id_user INNER JOIN media ON orders.id_media = media.id_media INNER JOIN purchase ON users.id_user=purchase.id_user WHERE orders.`id_user` =:id');
    $selectQueryUser->bindParam(':id',$userID);
    $selectQueryUser->execute();

    $userToOrder = $selectQueryUser->fetch();

    $thisMedia = $userToOrder['id_media'];
    $price = $userToOrder['media_cost'];
    $resources = $userToOrder['user_resources'];
    if($resources>=$price){

        $res4 = $db->prepare('INSERT INTO bought_media (id_user, id_media) VALUES (:id_u, :id_m)');
        $res4->bindParam(':id_u', $userID);
        $res4->bindParam(':id_m', $thisMedia);
        $res4->execute();

        $resourceAfterBuy = $resources - $price;

        $queryResources=$db->prepare('UPDATE users SET user_resources=:resourceNew WHERE id_user=:id2');
        $queryResources->bindParam(':resourceNew',$resourceAfterBuy);
        $queryResources->bindParam(':id2',$userID);
        $queryResources->execute();

        if($res4){
            $result5=$db->prepare("DELETE FROM orders WHERE id_order = :id2");
            $result5->bindParam(':id2',$idOrder);
            $result5->execute();

            if($result5){
                $res1=$db->prepare('SELECT * FROM orders WHERE id_user=:id1');
                $res1->bindParam(':id1',$userID);
                $res1->execute();

                $ordersNumber=$res1->rowCount();
                if($ordersNumber>1){
                    $result6=$db->prepare('SELECT SUM(media_cost) AS sum1 FROM media INNER JOIN orders ON media.id_media=orders.id_media WHERE orders.id_user=:id');
                    $result6->bindParam(':id',$userID);
                    $result6->execute();

                    foreach($result6 as $row)
                    {
                        $sum1=$row['sum1'];
                    }

                    $res2=$db->prepare("UPDATE purchase SET sum=:sum1 WHERE id_user=:id2");
                    $res2->bindParam(':sum1', $sum1);
                    $res2->bindParam(':id2',$userID);
                    $res2->execute();
                }elseif($ordersNumber==1) {

                    $row1=$res1->fetch();
                    $idOneOrder=$row1['id_order'];
                    $idOneUser=$row1['id_user'];
                    $idOneMedia=$row1['id_media'];


                    $res3=$db->prepare('SELECT media_cost FROM media WHERE id_media=:id_m');
                    $res3->bindParam(':id_m', $idOneMedia);
                    $res3->execute();
                    $data = $res3->fetch();

                    $newPrice=$data['media_cost'];

                    $res4=$db->prepare('UPDATE purchase SET sum=:sum1 WHERE id_user = :id1');
                    $res4->bindParam(':id1', $idOneUser);
                    $res4->bindParam(':sum1', $newPrice);
                    $res4->execute();

                    header('Location:userOrders.php');
                    exit();

                }else {
                    $deletePurchase=$db->prepare("DELETE FROM purchase WHERE id_user=:id");
                    $deletePurchase->bindParam(':id',$userID);
                    $deletePurchase->execute();
                    echo "No data";
                }
            }
            header('Location: userOrders.php');
            exit();
        } else{
            $_SESSION['delete_problem'] = true;
            header('Location: userOrders.php');
            exit();
        }
        header('Location: main-shop-page.php');
        exit();
    } else{
        $_SESSION['low_resources'] = true;
        header('Location: userOrders.php');
        exit();
    }
}
?>
