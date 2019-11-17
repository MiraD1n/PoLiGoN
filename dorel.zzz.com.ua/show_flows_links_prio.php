<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Пример веб-страницы</title>
 </head>
 <body>
<a href="http://dorel.zzz.com.ua/show_flows.php" class="c">TUBLER_EDIT_FLOWS<a><br/>
<br/>
<a href="http://dorel.zzz.com.ua/show_sf.php"><img src="sferas.png" width="200"
   height="200" alt="sferas"><a>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<p><a href="index.php">На ГЛАВНУЮ</a><br/>
<h5>*+/- change PRIO (weight 1-3)</h5>
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

//тут вызывать функцию чтобы она уже считала .... нужен массив и

$res = $mysqli->query("SELECT * FROM systree WHERE s_f_4kr = 1 ORDER BY weight DESC");


//------------------------------- NEW CODE
//функция работает но не до конца коменчу для отладки
function countLinkedObjects($z){
  $mysqli = new mysqli("127.0.0.1", "dorel", "Qq1234567", "dorel");

  // проверка соединения
  if (mysqli_connect_errno()) {
      printf("Соединение не удалось: %s\n", mysqli_connect_error());
      exit();
  }
//echo $z;
//  if ($result = $mysqli->query("SELECT COUNT(*) FROM links WHERE who= '$z' ")) {
    if ($result = $mysqli->query("SELECT * FROM links WHERE who= '$z' ")) {
      // определение числа рядов в выборке
      $row_cnt = $result->num_rows;

      //printf("В выборке %d рядов.\n", $row_cnt);
      //echo $row_cnt;
      //$z = $result;
      // закрытие выборки
      $result->close();
  }

  // закрытие соединения
  $mysqli->close();
  $z = $row_cnt;
  return $z;
}

//------------------------------- END NEW CODE*/
function tplMenu($category){
$test_col = getProperColor($category['weight']);

//  ************ NEW CODE
$y = $category['name'];
$t = countLinkedObjects($y);
//echo $t;
//  ************ END NEW CODE*/
    $menu = '<li>
        <a href= "http://dorel.zzz.com.ua/minus_fw.php?id='.$category['id'].'" class="as" >-1</a>
        <a href= "http://dorel.zzz.com.ua/show_linked_objects.php?id='.$category['id'].'" style="color: '.$test_col.'" name=" '. $category['name'] .'">'.
        $category['name'].'</a>
        <sup><small>'.$t.'</small></sup>
        <a href= "http://dorel.zzz.com.ua/plus_fw.php?id='.$category['id'].'" class="as" >+1</a>';
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
</body>
</html>
