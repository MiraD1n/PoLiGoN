<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css" />
  <title>Пример веб-страницы</title>
 </head>
 <body>
<?php

header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL);

//Объектно-ориентированный стиль
$mysqli = new mysqli("127.0.0.1", "dorel", "Qq1234567", "dorel");

//Устанавливаем кодировку utf8
$mysqli->query("SET NAMES 'utf8'");

/*
 * Это "официальный" объектно-ориентированный способ сделать это
 * однако $connect_error не работал вплоть до версий PHP 5.2.9 и 5.3.0.
 */
if ($mysqli->connect_error) {
    die('Ошибка подключения (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

$id = $_GET['id'];
$res = $mysqli->query("SELECT * FROM systree WHERE id = '$id' ");
$row = $res->fetch_assoc();
//update25082019 weight->worry
$i = $row['worry'];
if ($i <=0) {
      $i = 0;
    } else {
      $i = $i - 1;
}
//echo $id;
//$res_name = $mysqli->query("UPDATE systree SET weight = '$weight' WHERE id = '$id' UPDATE systree SET worry = '$worry' WHERE id = '$id' ");
//update25082019 weight->worry
$mysqli->query("UPDATE systree SET worry = '$i' WHERE id = '$id'");

$redicet = $_SERVER['HTTP_REFERER'];
@header ("Location: $redicet");
?>
<p><a href="show_sf_weight.php">Веса СФЕР</a><br/>
<p><a href="show_sf.php">Тревожность СФЕР</a><br/>
<p><a href="show_flows.php">Веса ПОТОКОВ</a><br/>
<p><a href="index.php">На главную</a><br/>
</body>
</html>
