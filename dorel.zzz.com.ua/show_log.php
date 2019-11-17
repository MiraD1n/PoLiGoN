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
<h3> Последние записи лог-файла:</h3><br/>
<?php
$log = 'log.txt';
$log_show = file_get_contents($log);
echo nl2br( htmlspecialchars($log_show) );

?>
<p><a href="clear_log.php">ОЧИСТИТЬ ЛОГ</a><br/>
 </body>
</html>
