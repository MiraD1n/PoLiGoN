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
$name_old = $row['name'];
$weight_old = $row['weight'];
$worry_old = $row['worry'];
$parent_old = $row['parent'];
$descr_old = $row['descr'];
$pers_old = $row['pers'];
$userid_old = $row['userid'];
$doned_old = $row['donedate'];
//

$name = $_POST['name'];
$weight = $_POST['weight'];
$worry = $_POST['worry'];
$s_f_4kr = $_POST['s_f_4kr'];
$parent = $_POST['parent'];
$descr = $_POST['descr'];
$pers = $_POST['pers'];
$userid = $_POST['userid'];
$doned = $_POST['doned'];

$log = 'log.txt';
$time = date("Y-m-d H:i:s");
$write_log = "$time Внесены правки. Старые значение: id:$id_old Имя:$name_old Вес:$weight_old Тревожность:$worry_old РодительID:$parent_old %_done:$pers_old USERID:$userid_old --> Новые значения: id:$id Имя:$name Вес:$weight Тревожность:$worry РодительID:$parent %_done:$pers USERID:$userid\n";

$mysqli->query("UPDATE systree SET name = '$name' WHERE id = '$id'");
$mysqli->query("UPDATE systree SET weight = '$weight' WHERE id = '$id'");
$mysqli->query("UPDATE systree SET worry = '$worry' WHERE id = '$id'");
$mysqli->query("UPDATE systree SET s_f_4kr = '$s_f_4kr' WHERE id = '$id'");
$mysqli->query("UPDATE systree SET parent = '$parent' WHERE id = '$id'");
$mysqli->query("UPDATE systree SET descr = '$descr' WHERE id = '$id'");
$mysqli->query("UPDATE systree SET pers = '$pers' WHERE id = '$id'");
$mysqli->query("UPDATE systree SET userid = '$userid' WHERE id = '$id'");
$mysqli->query("UPDATE systree SET donedate = '$doned' WHERE id = '$id'");
file_put_contents($log, $write_log, FILE_APPEND | LOCK_EX);
$log_show = file_get_contents($log);
echo nl2br( htmlspecialchars($log_show) );
$redicet = $_SERVER['HTTP_REFERER'];
@header ("Location: $redicet");
?>
</body>
</html>
