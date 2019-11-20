				
				
				<div class="upload_form">
					<form action="../user/upload.php" method="post" enctype="multipart/form-data">
						<h3>Add song:</h3>
							Type title of your song:
							<input type="text" name="song_title" id="song_title"><br>
							<input type="file" name="upload_music" id="upload_music"><br>
							<input type="submit" value="Submit" name="upload">
					</form>
					
					<span class = "php_uplad_error">
						<?php
							SESSION_START();
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