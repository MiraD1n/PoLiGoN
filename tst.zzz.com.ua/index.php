<!-- <p><img src="key.png" alt="key"></p> -->
<?php
$dir = './';
$files = scandir($dir);


foreach (glob("*.png") as $filename) {
    //echo "$filename size " . filesize($filename) . "\n";
 echo '<p><a href="delete_image.php" name="image"><img src="'.$filename.'" alt="key"></p>';

}

echo '<form enctype="multipart/form-data" name="upload_bage" id="upload_bage" action="upload.php" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
        <input name="userfile" type="file" />
        <input type="submit" value="Отправить файл" />
      </form>';


 ?>

<!--
 echo '<pre>';
 print_r($files);
 echo '<pre>';
 -->
