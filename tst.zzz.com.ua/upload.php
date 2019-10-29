<?php
$uploaddir = './';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);

/**************WORK
echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "Файл корректен и был успешно загружен.\n";
} else {
    echo "Возможная атака с помощью файловой загрузки!\n";
}

echo 'Некоторая отладочная информация:';
print_r($_FILES);

print "</pre>";
************WORK*/

//*****************************************************************************

// файл

$filename1 = 'bage.png';
$filename2 = $_FILES['userfile']['name'];

$percent = 0.5;

// тип содержимого
header('Content-Type: image/jpeg');

// получение новых размеров
list($width, $height) = getimagesize($filename1);
$new_width = $width;
$new_height = $height;

//Изменение размера входящего изображения
list($width_2, $height_2) = getimagesize($filename2);
$new_width_income = '393';
$new_height_income = '435';
$image_poligon = imagecreatetruecolor($new_width_income, $new_height_income);
$image_income = imagecreatefrompng($filename2);
imagecopyresampled($image_poligon, $image_income, 0, 0, 0, 0, $new_width_income, $new_height_income, $width_2, $height_2);

// ресэмплирование
//$image_p = imagecreatetruecolor($new_width, $new_height);
$image = imagecreatefrompng($filename1);
$image_p = $image_poligon;
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

// вывод
imagejpeg($image_p, null, 100);

imagejpeg($image_p, "test.png", 100);
//*****************************************************************************

//удаляет загружаемый файл, оставляя бейдж
unlink($filename2);

?>

<p><a href="index.php">BACK</p>
