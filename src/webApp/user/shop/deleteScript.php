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


    $deleteOrder=$db->prepare("DELETE FROM orders WHERE id_order=:id");
    $deleteOrder->bindParam(':id',$idOrder);
    $deleteOrder->execute();

    if($deleteOrder){

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

            header('Location: userOrders.php');
            exit();

        }else {
            $deletePurchase=$db->prepare("DELETE FROM purchase WHERE id_user=:id");
            $deletePurchase->bindParam(':id',$userID);
            $deletePurchase->execute();
            echo "No data";
        }

        header('Location: userOrders.php');
        exit();
    }
    else{
        $_SESSION['problem_delete_order'] = true;
        header('Location: userOrders.php');
        exit();
    }


}
?>
