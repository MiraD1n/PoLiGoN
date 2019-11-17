<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css" />
  <title>Пример веб-страницы</title>
 </head>
 <body>
<?php
$sdd_db_host='127.0.0.1'; // ваш хост
$sdd_db_name='dorel'; // ваша бд
$sdd_db_user='dorel'; // пользователь бд
$sdd_db_pass='Qq1234567'; // пароль к бд
@mysql_connect($sdd_db_host,$sdd_db_user,$sdd_db_pass); // коннект с сервером бд
@mysql_select_db($sdd_db_name); // выбор бд
$result=mysql_query('SELECT * FROM `systree`'); // запрос на выборку
while($row=mysql_fetch_array($result))
{
echo '<p>Запись id='.$row['id'].'. Текст: '.$row['text'].'</p>';// выводим данные
}

?>
</body>
</html>
