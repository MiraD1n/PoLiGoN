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
$who = $_POST['who'];
$him = $_POST['him'];
$parent = $_POST['parent'];

if (isset($him) && $him !== ''){

  // ----------------> new code conver ID to NAME him
  $res_name = $mysqli->query("SELECT * FROM systree WHERE id = '$him' ORDER BY id ASC");
  $maybe_array = $res_name->fetch_assoc();
  $show_id = $maybe_array['name'];
  $show_id_f = $maybe_array['id'];
  // ----------------> and new code

$mysqli->query("INSERT INTO `links` (`id`, `who`, `fw_id`, `him`) VALUES (NULL, '$who', '$id', '$show_id')");

//********* Блок логирования - ID можно получить только после создания связи
//$res = $mysqli->query("SELECT * FROM links WHERE id = '$id_link' ");
$res = $mysqli->query("SELECT * FROM links order by id DESC LIMIT 1");
$row = $res->fetch_assoc();
$id_object = $row['id'];
$who = $row['who'];
$him = $row['him'];
$log = 'log.txt';
$time = date("Y-m-d H:i:s");
//$write_log = "$time Новые изменения: WHO:$who HIM:$him\n";
$write_log = "$time Создана связь: ID:$id_object РОДИТЕЛЬ:$who КТО будет от него ЗАВИСИТЬ:$him\n";
file_put_contents($log, $write_log, FILE_APPEND | LOCK_EX);
$log_show = file_get_contents($log);
echo nl2br( htmlspecialchars($log_show) );
//********* Конец блока логирования
}

if (isset($parent) && $parent !== ''){

    // ----------------> new code conver ID to NAME him
    $res_name = $mysqli->query("SELECT * FROM systree WHERE id = '$parent' ORDER BY id ASC");
    $maybe_array = $res_name->fetch_assoc();
    $show_id = $maybe_array['name'];
    $show_id_f = $maybe_array['id'];
    // ----------------> and new code

  $mysqli->query("INSERT INTO `links` (`id`, `who`, `fw_id`, `him`) VALUES (NULL, '$show_id', '$show_id_f', '$who')");

  //********* Блок логирования - ID можно получить только после создания связи
  //$res = $mysqli->query("SELECT * FROM links WHERE id = '$id_link' ");
  $res = $mysqli->query("SELECT * FROM links order by id DESC LIMIT 1");
  $row = $res->fetch_assoc();
  $id_object = $row['id'];
  $who = $row['who'];
  $him = $row['him'];
  $log = 'log.txt';
  $time = date("Y-m-d H:i:s");
  //$write_log = "$time Новые изменения: WHO:$who HIM:$him\n";
  $write_log = "$time Создана связь: ID:$id_object РОДИТЕЛЬ:$who КТО будет от него ЗАВИСИТЬ:$him\n";
  file_put_contents($log, $write_log, FILE_APPEND | LOCK_EX);
  $log_show = file_get_contents($log);
  echo nl2br( htmlspecialchars($log_show) );
  //********* Конец блока логирования
}

?>
<p><a href="clear_log.php">ОЧИСТИТЬ ЛОГ</a><br/>
</body>
</html>
