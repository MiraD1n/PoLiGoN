<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css" />
  <title>Пример веб-страницы</title>
 </head>
 <body>
   <a href="http://dorel.zzz.com.ua/show_sf.php"><img src="sferas.png" width="200"
      height="200" alt="sferas"><a>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
   <a href="http://dorel.zzz.com.ua/show_flow_links_prioweight.php"><img src="flows.png" width="200"
        height="200" alt="flows"><a><br/>
   <p><a href="index.php">НА ГЛАВНУЮ</a><br/>
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
//Блок логирования что удалено - обязательно вставлять до операции удаления
$res = $mysqli->query("SELECT * FROM systree WHERE id = '$id' ");
$row = $res->fetch_assoc();
$id_object = $row['id'];
$name = $row['name'];
$weight = $row['weight'];
$worry = $row['worry'];
$s_f_4kr = $row['s_f_4kr'];
$parent = $row['parent'];
$log = 'log.txt';
$time = date("Y-m-d H:i:s");
$write_log = "$time Удален обьект: id:$id_object Имя:$name Вес:$weight Тревожность:$worry s_f_4kr:$s_f_4kr РодительID:$parent\n";
file_put_contents($log, $write_log, FILE_APPEND | LOCK_EX);
$log_show = file_get_contents($log);
echo nl2br( htmlspecialchars($log_show) );
//конец блока логирования что удалено
$mysqli->query("DELETE FROM systree WHERE id = '$id' ;");
?>
<p><a href="clear_log.php">ОЧИСТИТЬ ЛОГ</a><br/>
</body>
</html>
