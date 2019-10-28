<!-- <p><img src="key.png" alt="key"></p> -->
<?php
$dir = './';
$files = scandir($dir);


foreach (glob("*.png") as $filename) {
    //echo "$filename size " . filesize($filename) . "\n";
 //echo '<p><a href="delete_image.php" name="image"><img src="'.$filename.'" alt="key"></p>';

 echo '<form id="delimage" name="delimage" action="delete_image.php">
          <input type="hidden" id="image_id" name="image_id" value="'.$filename.'">
           <input type="image" name="submit" src="'.$filename.'" alt="Submit" />
      </form>';


}

foreach (glob("*.jpg") as $filename) {
    //echo "$filename size " . filesize($filename) . "\n";
 //echo '<p><a href="delete_image.php" name="image"><img src="'.$filename.'" alt="key"></p>';

 /*echo '<form id="delimage" name="delimage" action="delete_image.php">
          <input type="hidden" id="image_id" name="image_id" value="'.$filename.'">
           <input type="image" name="submit" src="'.$filename.'" alt="Submit" />
      </form>';
*/
echo '<p><a href=""><img src="'.$filename.'" width="200" height="100"></p>';

}

echo '<form enctype="multipart/form-data" name="upload_bage" id="upload_bage" action="upload.php" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
        <input name="userfile" type="file" />
        <input type="submit" value="Отправить файл" />
      </form>';

//****************


// исходное изображение
$img="banan.png";

// imagecreatefrompng - создаёт новое изображение из файла или URL
// водяной знак (шаблон бейджа)
$wm=imagecreatefrompng('bage2.png');

// imagesx - получает ширину изображения
$wmW=imagesx($wm);

// imagesy - получает высоту изображения
$wmH=imagesy($wm);

// imagecreatetruecolor - создаёт новое изображение true color
$image=imagecreatetruecolor($wmW, $wmH);

// выясняем расширение изображения на которое будем накладывать водяной знак
if(preg_match("/.gif/i",$img)):
	$image=imagecreatefromgif($img);
elseif(preg_match("/.jpeg/i",$img) or preg_match("/.jpg/i",$img)):
	$image=imagecreatefromjpeg($img);
elseif(preg_match("/.png/i",$img)):
	$image=imagecreatefrompng($img);
else:
	die("Ошибка! Неизвестное расширение изображения");
endif;
// узнаем размер изображения
$size=getimagesize($img);

// указываем координаты, где будет располагаться водяной знак
/*
* $size[0] - ширина изображения
* $size[1] - высота изображения
* - 10 -это расстояние от границы исходного изображения
*/
$cx=$size[0]-$wmW-10;
$cy=$size[1]-$wmH-10;

/* imagecopyresampled - копирует и изменяет размеры части изображения
* с пересэмплированием
*/
imagecopyresampled ($image, $wm, $cx, $cy, 0, 0, $wmW, $wmH, $wmW, $wmH);

/* imagejpeg - создаёт JPEG-файл filename из изображения image
* третий параметр - качество нового изображение
* параметр является необязательным и имеет диапазон значений
* от 0 (наихудшее качество, наименьший файл)
* до 100 (наилучшее качество, наибольший файл)
* По умолчанию используется значение по умолчанию IJG quality (около 75)
*/
imagejpeg($image,$img,90);

// imagedestroy - освобождает память
imagedestroy($image);

imagedestroy($wm);

// на всякий случай
unset($image,$img);

?>






<!--
 echo '<pre>';
 print_r($files);
 echo '<pre>';
 -->
