<?php
SESSION_START();

include_once '../../connection/connectWithDB.php';
if($_SESSION['id_user']) {
$idUser = $_SESSION['id_user'];
$userquery = $db->prepare("SELECT * FROM users WHERE id_user=:id");
$userquery->bindParam(':id', $idUser);
$userquery->execute();
    while ($infouser = $userquery->fetch()){
?>
<div class="main-box">
    <div class="first-column">
        <span>Your profile</span>
        <div class="button-box">
            <div class="button-inside"><a href="../user/editUserInfoScript.php">Edit</a></div>
        </div>
        <div class="profile-box">
        <div class="user-photo">
            <img class="user-photo-style"
                 src="../user/uploads/<?php echo $infouser['id_user']; ?>/user_photo/<?php echo $infouser['user_photo']; ?>"  alt="user_photo">
                <div></div>
                    </div>
                    <div class="info-text">
                        <div class="profile-text"><?php echo $infouser['name'].'&nbsp'.$infouser['family_name'];?></div>
                        <div class="profile-text"><?php echo $infouser['email']; }}?></div>
                    </div>
        </div>

                        </div>
                        <div class="second-column">
                            <div class="sections">
                                <div <!--id="all_user_songs"--> >
                            <p class = "add_song">Your all accepted songs: </p></br>
							<div id="scroll"
                            <?php
					include_once '../../connection/connectWithDB.php';
					$sql=$db->prepare("SELECT * FROM media WHERE id_owner=:id AND is_accepted=1");
					$sql->bindParam(':id', $_SESSION['id_user']);
					$sql->execute();
					
					while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
						
						echo '<form action = "../user/music_player/addPlaylist.php?track=' . $row["id_media"] . '" method="post" class="track">
							<input type = "submit" name = "track" input id="btn" class="btn" value = " ' . $row["media_title"] . '"></input>';
						
						echo '</form>';	}?>
							</div>
                            </div>
                            </div>
                            <div class="sections">
                                <div <!--id="upload_form"-->>
                                <form action="../user/upload.php" method="post" enctype="multipart/form-data">
						<p class = "add_song">Add new song here </p></br>
						<p class="songs">After successful uploading of your song, it needs to be accepted by our administrator.
						Then, your masterpiece will appear in the whole system. Enjoy!</p><br>
						<p class="songs">Your title should have 5 - 30 characters.
						Supported music extensions: .mp3, .wav, .aac or .flac.
						You can choose the cover of your song, but it is not required(.jpg, .png, .bmp or .gif).
						Files need to be less than 15MB!
						</p><br>
						<p class="songs"></p>
							<input type="text" name="song_title" id="song_title" placeholder= "Type title of your song"><br>
							<label for="upload_music">Browse your music...</label>
							<input type="file" name="upload_music" id="upload_music"><br>
							<label for="upload_cover">Browse you cover...</label>
							<input type="file" name="upload_cover" id="upload_cover"><br>
							<input type="submit" value="Submit" name="upload" id="submit_music" >
					</form>
					
					<span class = "php_uplad_error">
						<?php
							//SESSION_START();
							if (isset($_SESSION['e_upload'])) {
								echo $_SESSION['e_upload'];
								unset($_SESSION['e_upload']);
							}
						?>
					</span>
					<span class = "php_upload_success">
					<?php
						//SESSION_START();
						if (isset($_SESSION['s_upload'])) {
								if (isset($_SESSION['e_upload'])) {
								unset($_SESSION['e_upload']);
								}
							echo $_SESSION['s_upload'];
							unset($_SESSION['s_upload']);
						}
					?>
					</span>
                            </div>
                    </div>
                    </div>
                </div>
