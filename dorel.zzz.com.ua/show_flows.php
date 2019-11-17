<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css" />
  <title>Пример веб-страницы</title>
 </head>
 <body>

<a href="http://dorel.zzz.com.ua/show_flows_links.php" class="c">TUBLER_LINKED_SFERAS<a><br/>
<br/>
<a href="http://dorel.zzz.com.ua/show_sf.php"><img src="sferas.png" width="200"
   height="200" alt="sferas"><a>
<p><a href="index.php">На ГЛАВНУЮ</a><br/>
<h5>*Change object fields</h5>
<!-- <form action="show_flows_links.php">
  <p><input type="submit" value="TUBLER_LINKED_SFERAS"></p>
</form>
<p><a href="index.php">Назад</a><br/>
<br/>
-->

<?php
$mysqli = new mysqli("127.0.0.1", "dorel", "Qq1234567", "dorel");

if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

function getProperColor($col_lk)
{
    if ($col_lk <= 1)
        $var = '#008000';
    else if ($col_lk == 2)
        $var = '#4682B4';
    else if ($col_lk >= 3)
        $var = '#FF0000';
$col_lk = $var;
return $col_lk;
}

$res = $mysqli->query("SELECT * FROM systree WHERE s_f_4kr = 1 ORDER BY name ASC");
/*
echo "Выборка всех сфер с их ID...<br/>\n";
$res->data_seek(0);
while ($row = $res->fetch_assoc()) {
  '<a href= "#" style="color: #FF0000" name=" '. $row['id'] . ' - ' . '">'.
  $row['name'].'</a>';
//  echo " id_" . $row['id'] . " - " . $row['name'] . "<br/>\n";
}
*/
function tplMenu($category){
$test_col = getProperColor($category['weight']);
    $menu = '<li>
        <a href= "http://dorel.zzz.com.ua/chenger.php?id='.$category['id'].'" style="color: '.$test_col.'" name=" '. $category['name'] .'">'.
        $category['name'].'</a>';
        if(isset($category['childs'])){
            $menu .= '<ul>'. showCat($category['childs']) .'</ul>';
        }
    $menu .= '</li>';
    return $menu;
}

function showCat($data){
    $string = '';
    foreach($data as $item){
        $string .= tplMenu($item);
    }
    return $string;
}

//Получаем HTML разметку
$cat_menu = showCat($res);

//Выводим на экран
echo '<ul>'. $cat_menu .'</ul>';
?>
<p>*3 - red</p>
<p>*5 - purple</p>
<p>Приоритет - это выберешь ли ты этот поток в суете</p>
</body>
</html>
