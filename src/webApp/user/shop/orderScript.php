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
if($_GET['id'])
{
    $orderMedia_id = $_GET['id'];
    $userID=$_SESSION['id_user'];

     require_once '../../../connection/connectWithDB.php';
    //check1
    $result1=$db->prepare('SELECT * FROM orders WHERE id_user=:user1 AND id_media=:mediaID');
    $result1->bindValue(':user1', $userID, PDO::PARAM_STR);
    $result1->bindValue(':mediaID', $orderMedia_id, PDO::PARAM_STR);
    $result1->execute();

    $numbers1=$result1->rowCount();
    if($numbers1<1) {
        //check1
        $result2=$db->prepare('SELECT * FROM bought_media WHERE id_user=:user1 AND id_media=:mediaID');
        $result2->bindValue(':user1', $userID, PDO::PARAM_STR);
        $result2->bindValue(':mediaID', $orderMedia_id, PDO::PARAM_STR);
        $result2->execute();

        $numbers2=$result2->rowCount();
        if ( $numbers2<1) {

            $result5 = $db->prepare("INSERT INTO orders (id_user, id_media) VALUES (:id_userOrder,:id_mediaOrder)");
            $result5->bindParam(':id_userOrder', $userID);
            $result5->bindParam(':id_mediaOrder', $orderMedia_id);

            $result5->execute();

            if ($result5) {

                $res1 = $db->prepare('SELECT * FROM orders WHERE id_user=:id1');
                $res1->bindParam(':id1', $userID);
                $res1->execute();

                $orderNumber = $res1->rowCount();
                if ($orderNumber > 1) {
                    $result6 = $db->prepare('SELECT SUM(media_cost) AS sum1 FROM media INNER JOIN orders ON orders.id_media=media.id_media WHERE orders.id_user=:id');
                    $result6->bindParam(':id', $userID);
                    $result6->execute();
                    foreach ($result6 as $row) {
                        $mainSum = $row['sum1'];
                    }
                    $res2 = $db->prepare("UPDATE purchase SET sum=:sum1 WHERE id_user=:id2");
                    $res2->bindParam(':sum1', $mainSum);
                    $res2->bindParam(':id2', $userID);
                    $res2->execute();
                } else {

                    $res3 = $db->prepare('SELECT media_cost FROM media WHERE id_media=:id_m');
                    $res3->bindParam(':id_m', $orderMedia_id);
                    $res3->execute();
                    $data = $res3->fetch();

                    $newSum = $data['media_cost'];

                    $res4 = $db->prepare('INSERT INTO purchase (id_user, sum) VALUES (:id_u, :sum2)');
                    $res4->bindParam(':id_u', $userID);
                    $res4->bindParam(':sum2', $newSum);
                    $res4->execute();

                    header('Location: main-shop-page.php');
                    exit();

                }

            }

            header('Location: main-shop-page.php');
            exit();
    }
        else{
            $_SESSION['bad_media_bought'] = true;
            header('Location: main-shop-page.php');
            exit();
        }
    }
    else{
        $_SESSION['bad_shop'] = true;
        header('Location: main-shop-page.php');
        exit();
    }




}


?>
