				
				
				<div id="upload_form">
					<form action="../user/upload.php" method="post" enctype="multipart/form-data">
						<p class = "add_song">Add new song here </p></br>
							<input type="text" name="song_title" id="song_title" placeholder= "Type title of your song"><br>
							<label for="upload_music">Browse...</label>
							<input type="file" name="upload_music" id="upload_music"><br>
							<input type="submit" value="Submit" name="upload" id="submit_music" >
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