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

if ($mysqli->connect_error) {
    die('Ошибка подключения (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

$kapital = $_POST['kapital'];
$descr = $_POST['descr'];

$log = 'log.txt';
$time = date("Y-m-d H:i:s");
//$mysqli->query("UPDATE systree SET weight = '$weight' WHERE id = '$id'");
$mysqli->query("INSERT INTO `money` (`id`, `date`, `kapital`, `descr`) VALUES (NULL, '$time', '$kapital', '$descr')");

$write_log = "$time Добавлено финансы: Дата:$time Сумма:$kapital Заметки:$descr\n";

file_put_contents($log, $write_log, FILE_APPEND | LOCK_EX);
$log_show = file_get_contents($log);
echo nl2br( htmlspecialchars($log_show) );
$redicet = $_SERVER['HTTP_REFERER'];
@header ("Location: $redicet");
?>
  </body>
</html>
