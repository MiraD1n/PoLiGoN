<?php
// файл

$filename1 = 'bage.png';
$filename2 = 'banan.png';
$percent = 0.5;

// тип содержимого
header('Content-Type: image/jpeg');

// получение новых размеров
list($width, $height) = getimagesize($filename1);
$new_width = $width;
$new_height = $height;

// ресэмплирование
$image_p = imagecreatetruecolor($new_width, $new_height);
$image = imagecreatefrompng($filename1);
$image_p = imagecreatefrompng($filename2);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

// вывод
imagejpeg($image_p, null, 100);

?>
