<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css" />
  <title>Пример веб-страницы</title>
 </head>
 <body>
   <a href="http://dorel.zzz.com.ua/show_sf.php"><img src="sferas.png" width="100"
      height="100" alt="sferas"><a>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
   <a href="http://dorel.zzz.com.ua/show_flow_links_prioweight.php"><img src="flows.png" width="100"
             height="100" alt="flows"><a><br/>
<p><a href="index.php">НА ГЛАВНУЮ</a>&nbsp; &nbsp;<a href="http://dorel.zzz.com.ua/dayway.php" class="c">BAGES</a>
<?php
$id_object = $_GET['id'];

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


$res_name = $mysqli->query("SELECT * FROM systree WHERE id = '$id_object' ORDER BY id ASC");
$object_values = $res_name->fetch_assoc();
$show_id = $object_values['name'];
$show_uid = $object_values['userid'];
$show_doned = $object_values['donedate'];
if ($show_uid == '') $show_uid = 'mx';
$show_sf_fw = $object_values['s_f_4kr'];
//sf fw 4ker
$sf4 = $object_values['s_f_4kr'];
if ($sf4 == 1) $sf4 = 'flow';
else $sf4 = "sfera";
//***
echo '<h3>***** '. $show_id.'<sup><small>&nbsp;'. $sf4.'</small></sup> *****</h3>';
echo '<form method="post" action="changer_button.php">
             ID:  <input type="text" name="id" value="'.$object_values['id'].'" /><br />
             NAME:  <input type="text" name="name" value="'.$object_values['name'].'" /><br />
             WEIGHT:  <input type="text" name="weight" value="'.$object_values['weight'].'" /><br />
             WORRY (0 нет/1 отложено,зависит/2 тревожит):  <input type="text" name="worry" value="'.$object_values['worry'].'" /><br />
             SF/FW_4kr/DONE (0-SF/1-FW/2-DONE):  <input type="text" name="s_f_4kr" value="'.$object_values['s_f_4kr'].'" /><br />
             PARENT (id of topper sfera):  <input type="text" name="parent" value="'.$object_values['parent'].'" /><br />
             PERCENTAGE (% of done/above 100 - KT %):  <input type="text" name="pers" value="'.$object_values['pers'].'" /><br />
             USERID (who):  <input type="text" name="userid" value="'.$show_uid.'" /><br />
             DONEDATE("yyyy-mm-dd"):  <input type="text" name="doned" value="'.$show_doned.'" /><br />
             ARGS:<br />
             <textarea name="descr">'.$object_values['descr'].'</textarea>
          <p><input type="submit" value="CHANGER_BUTTON"></p>
      </form>';
      echo '<form method="post" action="create_link.php">
                   <input type="hidden" type="text" name="id" value="'.$object_values['id'].'" /><br />
                   РОДИТЕЛЬ:  <input type="text" name="who" value="'.$object_values['name'].'" /><br />
                   КТО будет от него ЗАВИСИТЬ (id обьекта):  <input type="text" name="him" value="" /><br />
                   ОТ КОГО будет ЗАВИСИТЬ (id обьекта):  <input type="text" name="parent" value="" /><br />
                <p><input type="submit" value="CREATE_LINK"></p>
            </form>';

//Close connection to DB
?>
<br/>
</body>
</html>
