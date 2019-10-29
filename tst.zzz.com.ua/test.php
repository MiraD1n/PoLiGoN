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
//$image_p = imagecreatetruecolor($new_width, $new_height);
$image = imagecreatefrompng($filename1);
$image_p = imagecreatefrompng($filename2);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

// вывод
imagejpeg($image_p, null, 100);

imagejpeg($image_p, "test.png", 100);

// освобождение памяти
//imagedestroy($image_p);


/*
echo $new_width.'</br>';
echo $new_height.'</br>';
echo $width.'</br>';
echo $height.'</br>';*/


//********************* WORK CHANGE SIZE
/*
// файл
  $filename = 'banan.png';
  $percent = 0.5;

  // тип содержимого
  header('Content-Type: image/jpeg');

  // получение новых размеров
  list($width, $height) = getimagesize($filename);
  $new_width = '393';
  $new_height = '435';

  // ресэмплирование
  $image_p = imagecreatetruecolor($new_width, $new_height);
  $image = imagecreatefrompng($filename);
  imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

  // вывод
  imagejpeg($image_p, null, 100);

  imagejpeg($image_p, "banan.png", 100);
*/
?>
