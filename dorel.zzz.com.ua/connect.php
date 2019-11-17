<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--  <link rel="stylesheet" type="text/css" href="style.css" /> -->
  <title>Пример веб-страницы</title>
 </head>
 <body>
<?php
$link = mysqli_connect("127.0.0.1", "dorel", "Qq1234567", "dorel");

if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo "Соединение с MySQL установлено! <br/>\n" . PHP_EOL;
echo "Информация о сервере: <br/>\n" . mysqli_get_host_info($link) . PHP_EOL;


mysqli_close($link);
?>
<p><a href="index.php">Назад</a>
</body>
</html>
