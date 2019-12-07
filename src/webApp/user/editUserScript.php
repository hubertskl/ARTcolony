<?php
SESSION_START();
if (isset($_SESSION['logged_id'])) {
    $idUser=$_SESSION['id_user'];
    $loginPost = filter_input(INPUT_POST, 'username');
    $passwordPost = filter_input(INPUT_POST, 'password');
    $namePost = filter_input(INPUT_POST, 'name');
    $familynamePost=filter_input(INPUT_POST, 'familyname');
    $emailPost=filter_input(INPUT_POST, 'email');
    $uploadPhoto = 1;
    $allright=true;
    require_once '../../connection/connectWithDB.php';

    $userquery = $db->prepare("SELECT * FROM users WHERE id_user=:id");
    $userquery->bindParam(':id', $idUser);
    $userquery->execute();
    $infouser = $userquery->fetch();
        $UserID=$infouser['id_user'];
        $oldname=$infouser['name'];
        $oldfamilyname=$infouser['family_name'];
        $oldpassword=$infouser['password'];
        $oldlogin=$infouser['login'];
        $oldemail=$infouser['email'];


    //check login
    if(isset($loginPost)){
        if(strlen($loginPost)>0){
            if($loginPost!==$oldlogin){
            if((strlen($loginPost)>3)&&(strlen($loginPost)<25)) {
                if (ctype_alnum($loginPost)==true) {
                    $numberOfnewLogin = $db->prepare("SELECT * FROM users WHERE login=:newlogin");
                    $numberOfnewLogin->bindParam(':newlogin', $loginPost);
                    $numberOfnewLogin->execute();

                    $numberOfthisLogin = $numberOfnewLogin->rowCount();
                    if ($numberOfthisLogin > 0) {
                        $_SESSION['login_exist'] = true;
                    } else {
                        $updatelogin = $db->prepare("UPDATE users SET login=:newlogin WHERE id_user=:id2");
                        $updatelogin->bindParam(':newlogin', $loginPost);
                        $updatelogin->bindParam(':id2', $UserID);
                        $updatelogin->execute();
                    }}}
            else{
                $allright=false;
                $_SESSION['wrong_size_of_login'] = true;
            }
        }
        }
    }
    if(isset($passwordPost)){
        if(strlen($passwordPost)>0) {
            if ((strlen($passwordPost) > 3) && (strlen($passwordPost) < 25)) {
                if ($oldpassword == $passwordPost) {
                    $_SESSION['this_same_password'] = true;
                    $allright = false;
                }
                $pass_hash = password_hash($passwordPost, PASSWORD_DEFAULT);
                $updatepassword = $db->prepare("UPDATE users SET password=:newpass WHERE id_user=:id2");
                $updatepassword->bindParam(':newpass', $pass_hash);
                $updatepassword->bindParam(':id2', $UserID);
                $updatepassword->execute();

            } else {
                $_SESSION['wrong_size_of_password'] = true;
                $allright = false;
            }
        }
    }
    if(isset($namePost)) {
        if(strlen($namePost)>0){
            if ($namePost !== $oldname) {
                $newNameQuery = $db->prepare("UPDATE users SET name=:newName WHERE id_user=:id2");
                $newNameQuery->bindParam(':newName', $namePost);
                $newNameQuery->bindParam(':id2',$UserID);
                $newNameQuery->execute();

            }else{
                $_SESSION['this_same_name'] = true;
                $allright=false;
            }
        }
    }
    if(isset($familynamePost)) {
        if(strlen($familynamePost)>0){
            if ($familynamePost !== $oldfamilyname) {
                $newFamilynameQuery = $db->prepare("UPDATE users SET family_name=:newFamilyName WHERE id_user=:id2");
                $newFamilynameQuery->bindParam(':newFamilyName', $familynamePost);
                $newFamilynameQuery->bindParam(':id2',$UserID);
                $newFamilynameQuery->execute();

            }else{
                $allright=false;
                $_SESSION['this_same_familyname'] = true;
            }
        }
    }
    if(isset($emailPost)) {
        if (strlen($emailPost) > 0) {
            if ((strlen($emailPost) > 3)) {
                if ($emailPost !== $oldemail) {
                    $email2 = filter_var($emailPost, FILTER_SANITIZE_EMAIL);
                    if ((filter_var($email2, FILTER_VALIDATE_EMAIL) == true)) {
                        $qu1 = $db->prepare('SELECT id_user FROM users WHERE email=:email1');
                        $qu1->bindValue(':email1', $emailPost, PDO::PARAM_STR);
                        $qu1->execute();

                        $mailNumber = $qu1->rowCount();
                        if ($mailNumber > 0) {
                            $allright = false;
                            $_SESSION['e_email'] = true;
                        } else {
                            $newEmailQuery = $db->prepare("UPDATE users SET email=:newEmail WHERE id_user=:id2");
                            $newEmailQuery->bindParam(':newEmail', $emailPost);
                            $newEmailQuery->bindParam(':id2', $UserID);
                            $newEmailQuery->execute();
                        }
                    }
                    else{
                        $allright = false;
                        $_SESSION['wrong_email'] = true;
                    }
                } else {
                    $allright = false;
                    $_SESSION['wrong_size_of_email'] = true;
                }
            }
        }
    }

    if($_FILES["upload_photo"]['size'] != 0){

            $target_dir_cover = "uploads/$idUser/user_photo/";
            $file_name_cover = basename($_FILES["upload_photo"]["name"]);
            $target_file_cover = $target_dir_cover . basename($_FILES["upload_photo"]["name"]);

            $imageFileType_cover = strtolower(pathinfo($target_file_cover,PATHINFO_EXTENSION));

            if (file_exists($target_file_cover)) {
                $_SESSION['e_upload_photo'] = 'Photo with this name already exists in your library!';
                $uploadPhoto = 0;
            }

        if($_FILES["upload_photo"]['size'] != 0) {
            if($imageFileType_cover != "jpg" && $imageFileType_cover != "png" && $imageFileType_cover != "bmp"
                && $imageFileType_cover != "gif" ) {
                $_SESSION['e_upload'] = 'Photo needs to have .jpg, .png, .bmp or .gif extension!';
                $uploadPhoto = 0;
            }
        }
        if( $uploadPhoto == 1){
            move_uploaded_file($_FILES["upload_photo"]["tmp_name"], $target_file_cover);

                $newPhotoQuery = $db->prepare("UPDATE users SET user_photo=:photo WHERE id_user=:id2");
                $newPhotoQuery->bindParam(':photo', $file_name_cover);
                $newPhotoQuery->bindParam(':id2',$UserID);
                $newPhotoQuery->execute();


        }

    }

    if($allright==true && $uploadPhoto==1){
        header('Location: ../mainPage/mainPage.php#page2');
        exit();
    }
    else{
       header('Location: editUserInfoScript.php');
       exit();
    }



}

header('../mainPage/mainPage.php#page2');
exit();

?>
