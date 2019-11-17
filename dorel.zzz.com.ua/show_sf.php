<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css" />
  <title>Пример веб-страницы</title>
 </head>
 <body>
<!-- <a href="http://dorel.zzz.com.ua/show_sf_weight.php" class="c">TUMBLER_WEIGHT<a><br/> -->
<br/>
<a href="http://dorel.zzz.com.ua/show_flow_links_prioweight.php"><img src="flows.png" width="200"
     height="200" alt="flows"><a><br/>
<p><a href="index.php">На ГЛАВНУЮ</a>&nbsp; &nbsp; <a href="http://dorel.zzz.com.ua/dayway.php" class="c">BAGES</a><br/>
<!-- Убрал форму, вместо нее можно просто тапать на тревожную сферу. Изменять обьект сферы через тумблер WEIGH
  <form action="show_linked_objects.php" method="post">
      ID_SF:  <input type="text" name="id" /><br />
      <input type="submit" name="submit" value="Show linked OBJECTS" />
  </form>
-->
<h4>*СФЕРА &#8680 от каких потоков ЗАВИСИТ</h4>
*GREEN - все ок</br>
*BLUE - в работе</br>
*RED - нужна проработка</br>
*&#9873 - приоритет</br>
*&#128293 - нужна проработка потоку</br>
<?php
//Устанавливаем кодировку и вывод всех ошибок
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

//Получаем массив нашего меню из БД в виде массива
function getCat($mysqli){
    $sql = 'SELECT * FROM `systree` WHERE s_f_4kr = 0';
    $res = $mysqli->query($sql);

    //Создаем масив где ключ массива является ID меню
    $cat = array();
    while($row = $res->fetch_assoc()){
        $cat[$row['id']] = $row;
    }
    return $cat;
}

//Функция построения дерева из массива от Tommy Lacroix
function getTree($dataset) {
    $tree = array();

    foreach ($dataset as $id => &$node) {
        //Если нет вложений
        if (!$node['parent']){
            $tree[$id] = &$node;
        }else{
            //Если есть потомки то перебераем массив
            $dataset[$node['parent']]['childs'][$id] = &$node;
        }
    }
    return $tree;
}

//Получаем подготовленный массив с данными
$cat  = getCat($mysqli);

//Создаем древовидное меню
$tree = getTree($cat);

// Блок Worry 1 или 0
function getProperColor($col_lk)
{
    if ($col_lk <= 0)
        $var = '#32CD32';
    else if ($col_lk == 1)
        $var = '#4682B4';
    else if ($col_lk >= 1)
        $var = '#FF0000';
$col_lk = $var;
return $col_lk;
}

function getCircleType($col_lk)
{
  if ($col_lk >= 0 && $col_lk <= 6)
      $var = '&#9675';
  else if ($col_lk >= 7 && $col_lk <= 29)
      $var = '&#9872';
  else if ($col_lk >= 30)
      $var = '&#9873';
$col_lk = $var;
return $col_lk;
}

function getCircleColor($d)
{
  if ($d <= 29)
      $var = "green";
  else if ($d >= 30)
      $var = "#C71585";
$d = $var;
return $d;
}

function getFire($col_lk)
{
  //********** db connection
  try {
      $pdo = new PDO ('mysql:host=127.0.0.1;dbname=dorel', 'dorel', 'Qq1234567');
    }
    catch (PDOException $e) {
      echo "Невозможно соеденится с БД";
    }
  //******** end db connection
  $query_1 = "SELECT *
            FROM links
            WHERE him = '$col_lk'";
  $cat = $pdo->query($query_1);
  try {
    while($catalog = $cat->fetch()){
    //********** код перебора сюда
    $fw_worry = $catalog['fw_id'];
      $query_2 = "SELECT *
                  FROM systree
                  WHERE id = '$fw_worry'";
      $cat_2 = $pdo->query($query_2);
      $catalog_2 = $cat_2->fetch();
      $id_worry = $catalog_2['worry'];
      if ($id_worry >= 2)
          goto a;
    }
    //********** код конец
  } catch (PDOException $e) {
    echo "Ошибка выполнения запроса: " . $e->getMessage();
  }

//****
$query_1 = "SELECT *
          FROM links
          WHERE who = '$col_lk'";
$cat = $pdo->query($query_1);
try {
  while($catalog = $cat->fetch()){
  //********** код перебора сюда
  $fw_worry = $catalog['him'];
    $query_2 = "SELECT *
                FROM systree
                WHERE name = '$fw_worry'";
    $cat_2 = $pdo->query($query_2);
    $catalog_2 = $cat_2->fetch();
    $id_worry = $catalog_2['worry'];
    if ($id_worry >= 2)
        break;
  }
  //********** код конец
} catch (PDOException $e) {
  echo "Ошибка выполнения запроса: " . $e->getMessage();
}

//****
a:
  if (empty($id_worry))
   $id_worry = 0;

   if ($id_worry >= 2)
       $var = '&#128293';
   else
       $var = '';

$col_lk = $var;
return $col_lk;
}
//********* work end
//Шаблон для вывода меню в виде дерева
//*вместо ссылки использовать ссылку на обьект для изменений
function tplMenu($category){
//    $number = '#FF8000'; - это работает пробую через вызов функции
//$col_link = '#FF0000'; - крассыный
$test_col = getProperColor($category['worry']);
$circle = getCircleType($category['weight']);
$circle_col = getCircleColor($category['weight']);
$fire = getFire($category['name']);

$menu = '<li>
    <a href= "http://dorel.zzz.com.ua/minus_worry.php?id='.$category['id'].'" >&#8249</a>
    <a href= "http://dorel.zzz.com.ua/show_linked_objects.php?id='.$category['id'].'" style="color: '.$test_col.'" name=" '. $category['name'] .'">'.
    $category['name'].'</a>
    <a href= "http://dorel.zzz.com.ua/plus_worry.php?id='.$category['id'].'" class="as" >&#8250</a>
    <sup><small>'.$category['weight'].'</small></sup>
    <sup><small><a href="http://dorel.zzz.com.ua/chenger.php?id='.$category['id'].'" style="color:'.$circle_col.'">'.$circle.'</a></small></sup>
    <sup style="color:red"><small>'.$fire.'</small></sup>';
    if(isset($category['childs'])){
        $menu .= '<ul>'. showCat($category['childs']) .'</ul>';
    }
$menu .= '</li>';
    return $menu;
}

function mxEcho(){
  echo "yes";
}

/**
* Рекурсивно считываем наш шаблон
**/
function showCat($data){
    $string = '';
    foreach($data as $item){
        $string .= tplMenu($item);
    }
    return $string;
}

//Получаем HTML разметку
$cat_menu = showCat($tree);

//Выводим на экран
echo '<ul>'. $cat_menu .'</ul>';

?>
</body>
</html>
