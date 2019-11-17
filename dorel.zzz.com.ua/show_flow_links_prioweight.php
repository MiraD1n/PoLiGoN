<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Пример веб-страницы</title>
 </head>
 <body>
<!-- <a href="http://dorel.zzz.com.ua/show_flows.php" class="c">TUBLER_EDIT_FLOWS<a><br/>-->
<br/>
<a href="http://dorel.zzz.com.ua/show_flows_links.php" class="c">SORT_BY_NAME<a><br/>
<br/>
<a href="http://dorel.zzz.com.ua/show_sf.php"><img src="sferas.png" width="200"
   height="200" alt="sferas"><a>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<p><a href="index.php">На ГЛАВНУЮ</a>&nbsp; &nbsp; <a href="http://dorel.zzz.com.ua/dayway.php" class="c">BAGES</a><br/>
<h4>*ПОТОК &#8680 кто от НЕГО зависит</h4>
<h5>*RED - проработать / BLUE - ожидает, отложено,зависит, календарь / GREEN - в проработке</h5>
* шахматные фигуры - это сколько сфер + вес</br>
* цифра - сумарный weight (красным добавляет автоматом 200/зеленым 100 - чтобы выводить в порядке очереди)</br>
* цифра в степени - на сколько сфер влияет (находить безполезные потоки, которые не влияют ни на кого)</br>
* строка - критерий</br>
<?php
$mysqli = new mysqli("127.0.0.1", "dorel", "Qq1234567", "dorel");

if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

function getProperColor($col_lk)
{
    if ($col_lk <= 0)
        $var = '#008000';
    else if ($col_lk == 1)
        $var = '#4682B4';
    else if ($col_lk >= 2)
        $var = '#FF0000';
$col_lk = $var;
return $col_lk;
}

//******************* функция высчитывания весов прилинкованых сфер NEW 19082019
function showAllSf($show_id){
  $mx_array= array();
  $i = 0;
  $mysqli = new mysqli("127.0.0.1", "dorel", "Qq1234567", "dorel");
  $res = $mysqli->query("SELECT * FROM links WHERE who = '$show_id' ORDER BY id ASC");
  //переводим указатель на начало
  $res->data_seek(0);
  //***цикл:пока есть значения обрабатываем все строки HIM, вытягиваем значения weight
  //$row и есть тот массив который нужен
  while ($row = $res->fetch_assoc()) {
  $sf_id = $row['him'];
  //********* блок вытягивания веса
  $res_fw = $mysqli->query("SELECT * FROM systree WHERE name = '$sf_id' ORDER BY id ASC");
  $res_fw_name = $res_fw->fetch_assoc();
  //******** конце блока веса
  $new_array[$i] = $res_fw_name['weight'];
  $i++;
  }
//Массив уже подготовлен ниже идет обработка
//сортировка массива в порядке убывания
  arsort($new_array);


  //$comma_separated = implode(",", $mx_array);
//>>>>>>>$comma_separated = implode(",", $new_array);
//  echo $comma_separated;
//>>>>>>>return $comma_separated;
return $new_array;
//echo $i;
}
//******************* конгец NEW 19082019

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
//to back color by weight CHANGE worry for weight back
$test_col = getProperColor($category['worry']);

//  ************ Count of sfers in quadro
$y = $category['name'];
$w = $category['worry'];
$t = countLinkedObjects($y);
$f = showAllSf($y);

foreach ($f as &$val) {
    if ($val <= 3)
        $var = '&#9817';
    else if ($val >= 4 && $val <= 6)
        $var = '&#9816';
    else if ($val == 7)
        $var = '&#9821';
    else if ($val == 8)
        $var = '&#9819';
    else if ($val >= 9)
        $var = '&#9818';
  $color[] = $var;
}
$comma_separated = implode($color);

//sum weight of all linked sferas **test_code**
$sum_sf = array_sum($f);
// Прибавка к весу в зависимости от уровня тревоги: RED +200/Blue +100/Green +0
if ($w >= 2)
    $sum_sf = $sum_sf + 200;
else if ($w == 0)
    $sum_sf = $sum_sf + 100;
//end
$mysqli = new mysqli("127.0.0.1", "dorel", "Qq1234567", "dorel");
$mysqli->query("UPDATE systree SET weight = '$sum_sf' WHERE name = '$y'");
//****end test_code

//  ************ END

    $menu = '<li>
        <a href= "http://dorel.zzz.com.ua/minus_fw.php?id='.$category['id'].'" class="as" >-1</a>
        <a href= "http://dorel.zzz.com.ua/show_linked_objects.php?id='.$category['id'].'" style="color: '.$test_col.'" name=" '. $category['name'] .'">'.$category['name'].'</a>
        <sup><small>'.$t.'</small></sup>
        <a href= "http://dorel.zzz.com.ua/plus_fw.php?id='.$category['id'].'" class="as" >+1</a>
        <code> '.$comma_separated.' </code>
        <code> '.$sum_sf.' </code>
        <sup><small>'.$category['descr'].'</small></sup>';
//        <sup><small>'.$comma_separated.'</small></sup>';
//echo $k;
//верхний блок через цикл нужно пропустить
        if(isset($category['childs'])){
            $menu .= '<ul>'. showCat($category['childs']) .'</ul>';
        }
    $menu .= '</li>';
    return $menu;
}

function circleColor(){


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
