<p><img src="key.png" alt="key"></p>
<?php

echo '<form enctype="multipart/form-data" name="upload_bage" id="upload_bage" action="upload.php" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
        <input name="userfile" type="file" />
        <input type="submit" value="Отправить файл" />
      </form>';

 ?>
