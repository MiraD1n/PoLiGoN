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
   <a href="http://dorel.zzz.com.ua/show_flows_links.php"><img src="flows.png" width="200"
        height="200" alt="flows"><a><br/>
   <p><a href="index.php">НА ГЛАВНУЮ</a><br/>
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

$name = $_POST['name'];
$weight = $_POST['weight'];
$worry = $_POST['worry'];
$s_f_4kr = $_POST['s_f_4kr'];
$parent = $_POST['parent'];
$log = 'log.txt';
$time = date("Y-m-d H:i:s");
//$mysqli->query("UPDATE systree SET weight = '$weight' WHERE id = '$id'");
$mysqli->query("INSERT INTO `systree` (`id`, `name`, `weight`, `worry`, `s_f_4kr`, `parent`) VALUES (NULL, '$name', '$weight', '$worry', '$s_f_4kr', '$parent')");
$res = $mysqli->query("SELECT * FROM systree WHERE name = '$name' ");
$row = $res->fetch_assoc();
$id = $row['id'];
$write_log = "$time Обьект создан: ID:$id Имя:$name Вес:$weight Тревожность:$worry SF/FW_4kr:$s_f_4kr РодительID:$parent\n";
file_put_contents($log, $write_log, FILE_APPEND | LOCK_EX);
$log_show = file_get_contents($log);
echo nl2br( htmlspecialchars($log_show) );

?>
  </body>
</html>
