<?php
SESSION_START();
if (!isset($_SESSION['logged_id']) && ($_SESSION['is_admin']!=='1'))
{
    header('Location: ../login/login.php');
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ARTcolony</title>
    <link rel="stylesheet" type = "text/css" href="adminStyle.css">
    <link rel="stylesheet" type = "text/css" href="../mainWebStyle/mainWebStyle.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<div id="adminHome-container" >
    <div class="admin-header col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">HOME ADMIN</div>
        <div class="logoutStyle col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <a href="../user/logout.php">Logout</a>
        </div>
    </div>
    <div class="accept-container col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="table-responsive padding-top">
            <table class="table table-striped table-dark table-hover table-sm table-text">
                <thead>
                <tr>
                    <th scope="col">media id</th>
                    <th scope="col">title</th>
                    <th scope="col">cost</th>
                    <th scope="col">is accepted</th>
                    <th scope="col">action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if($_SESSION['id_user']) {
                    $id = $_SESSION['id_user'];
                    $value=0;
                    require_once '../../connection/connectWithDB.php';
                    $result1=$db->prepare('SELECT * FROM media WHERE is_accepted = :value');
                    $result1->bindParam(':value',$value);
                    $result1->execute();
                    if($result1) {
                        foreach ($result1 as $row) {
                            $ID=$row['id_media'];
                            echo "<tr>
                                <td style='width: 10%'>" . $row['id_media'] . "</td>
                                <td style='width: 60%'>" . $row['media_title'] . "</td>
                                <td style='width: 10%'>" . $row['media_cost'] . "</td>
                                 <td style='width: 10%'>" . $row['is_accepted'] . "</td>
                                <td style='width: 20%'>
                                <a href='addMediaScript.php?id=".$ID."'><button class='btn btn-outline-success' type='button'>ADD</button></a>
                                <a href='deleteMediaScript.php?id=".$ID."'><button class='btn btn-outline-danger' type='button'>DELETE</button></a>
                                </td>";
                        }

                    }
                }
                ?>
                   <?php
            if (isset($_SESSION['bad_accept']))
            {
                echo '<div class="alert alert-danger">Can not accept</div>';
                unset($_SESSION['bad_accept']);
            }
            ?>
                </tbody></table>
        </div>

    </div>


</div>

</body>
</html>