<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css" />
  <title>Пример веб-страницы</title>
 </head>
 <body>
   <p><a href="show_sf_weight.php">Веса СФЕР</a><br/>
   <p><a href="show_sf.php">Тревожность СФЕР</a><br/>
   <p><a href="show_flows.php">Веса ПОТОКОВ</a><br/>
   <p><a href="index.php">На главную</a><br/>
   <p><a href="clear_log.php">ОЧИСТИТЬ ЛОГ</a><br/>
<br/>
<h3> Лог-файл изменений:</h3><br/>
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
$id = $_POST['id'];

//Тут нужно вытянуть старые значения из таблицы до изменений и присвоить им переменные old
$res = $mysqli->query("SELECT * FROM systree WHERE id = '$id' ");
$row = $res->fetch_assoc();
$id_old = $row['id'];
$descr_old = $row['descr'];
//
$descr = $_POST['descr'];

$mysqli->query("UPDATE systree SET descr = '$descr' WHERE id = '$id'");
$redicet = $_SERVER['HTTP_REFERER'];
@header ("Location: $redicet");
?>
</body>
</html>
