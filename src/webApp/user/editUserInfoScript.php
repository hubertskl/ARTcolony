<?php
SESSION_START();
if (!isset($_SESSION['logged_id']))
{
    header('Location: ../login/login.php');
    exit();
}
include_once '../../connection/connectWithDB.php';
if($_SESSION['id_user']) {
$idUser = $_SESSION['id_user'];
$userquery = $db->prepare("SELECT * FROM users WHERE id_user=:id");
$userquery->bindParam(':id', $idUser);
$userquery->execute();
while ($infouser = $userquery->fetch()){

}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ARTcolony</title>
    <link rel="stylesheet" type = "text/css" href="../mainPage/mainPageStyle/mainPageStyle.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="../mainPage/script.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
    <div id="main-container">
        <div class="title-box"></div>
        <div class="menu">
            <ul>
                <li><a href="../mainPage/mainPage.php#page1">Home</a></li>
                <li><a href="../mainPage/mainPage.php#page2">Your Profile</a></li>
                <li><a href="../mainPage/mainPage.php#page3">Music Player</a></li>
                <li><a href="../mainPage/mainPage.php#page4">Reviews</a></li>
                <li><a href="shop/main-shop-page.php">Shop</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="edit-box">
            <div class="section-edit1">
            <form action="editUserScript.php" method="post" enctype="multipart/form-data">
                <span>username</span></br>
                <input for="username" type="text" id="username" name="username"></br></br>
                <span>password</span></br>
                <input for="password" type="password" id="password" name="password"></br></br>
                <span>name</span></br>
                <input for="password" type="text" id="name_e" name="name"></br></br>
                <span>family name</span></br>
                <input for="password" type="text" id="familyname_e" name="familyname"></br></br>
                <span>email</span></br>
                <input for="password" type="text" id="email_e" name="email" ></br></br>
                <label for="upload_photo">Browse your new profile photo</label></br>
                <input type="file" name="upload_photo" id="upload_photo"><br>
                <?php
                if (isset($_SESSION['this_same_password']))
                {
                    echo '<p>This same password!</p>';
                    unset($_SESSION['this_same_password']);
                }
                if (isset($_SESSION['wrong_size_of_password']))
                {
                    echo '<p>The password must contain between 3 and 25 characters!</p>';
                    unset($_SESSION['wrong_size_of_password']);
                }
                if (isset($_SESSION['wrong_size_of_email']))
                {
                    echo '<p>The email mustmust have more then 3 characters!</p>';
                    unset($_SESSION['wrong_size_of_email']);
                }
                if (isset($_SESSION['wrong_email']))
                {
                    echo '<p>Write email correct!</p>';
                    unset($_SESSION['wrong_email']);
                }
                if (isset($_SESSION['login_exist']))
                {
                    echo '<p>This login already exist!</p>';
                    unset($_SESSION['login_exist']);
                }
                if (isset($_SESSION['this_same_familyname']))
                {
                    echo '<p>This same familyname!</p>';
                    unset($_SESSION['this_same_familyname']);
                }
                if (isset($_SESSION['e_email']))
                {
                    echo '<p>There is an account with this email!</p>';
                    unset($_SESSION['e_email']);
                }}
                if(isset( $_SESSION['wrong_size_of_login'])){
                    echo '<p>The login must contain between 3 and 25 characters</p>';
                    unset($_SESSION['wrong_size_of_login']);
                }
                if (isset($_SESSION['e_upload_photo'])) {
                    echo '<p>'.$_SESSION['e_upload_photo'].'</p>';
                    unset($_SESSION['e_upload_photo']);
                }
                if (isset($_SESSION['e_upload'])) {
                    echo '<p>'.$_SESSION['e_upload'].'</p>';
                    unset($_SESSION['e_upload']);
                }
                ?>
                <div class="edit-button-submit">
                    <div class="button-submit-inside">
                    <input type="submit" value="submit">
                    </div>
                </div>
            </form>
            </div>
            <div class="section-edit2">
                <h2>Here is the place where you can change your profile data, your password and profile picture...</h2>
            </div>
        </div>


    </div>
</body>
</html>