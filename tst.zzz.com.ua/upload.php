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

// ресэмплирование
//$image_p = imagecreatetruecolor($new_width, $new_height);
$image = imagecreatefrompng($filename1);
$image_p = imagecreatefrompng($filename2);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

// вывод
imagejpeg($image_p, null, 100);

imagejpeg($image_p, "test.png", 100);
//*****************************************************************************

?>

<p><a href="index.php">BACK</p>
