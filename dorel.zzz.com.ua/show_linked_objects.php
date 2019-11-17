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

function getProperColor($col_lk)
{
    if ($col_lk <= 0)
        $var = '#008000';
    else if ($col_lk == 1)
        //$var = '#C71585';
        $var = '#4682B4';
    else if ($col_lk >= 2)
        $var = '#FF0000';
$col_lk = $var;
return $col_lk;
}

//$object_name = '#СфОЖ';
//$object_name = $_POST['id'];
$object_name = $_GET['id'];



//echo 'ID обьекта: '.$object_name;
$res_name = $mysqli->query("SELECT * FROM systree WHERE id = '$object_name' ORDER BY id ASC");
$maybe_array = $res_name->fetch_assoc();
$show_id = $maybe_array['name'];
$idpers = $maybe_array['pers'];

// ************ проверка есть бейдж или нет
          $file_pointer = 'bages/'.$object_name.'.png';

          if ($idpers > 100)
          {
              $file_pointer = 'bages/kt.png';
          }
          else if (file_exists($file_pointer))
          {
              $file_pointer = 'bages/'.$object_name.'.png';
          }
          else
          {
              $file_pointer = 'bages/blank.png';
          }
//************ конец проверки

echo '<a href= "http://dorel.zzz.com.ua/chenger.php?id='.$object_name.'"><img weight=200 height=200 src="'.$file_pointer.'"></a>';

//sf fw 4ker
$sf4 = $maybe_array['s_f_4kr'];
if ($sf4 == 1) $sf4 = 'flow';
else $sf4 = "sfera";
//***

echo '<h3>***** '.$show_id.'<sup><small>&nbsp;'.$sf4.'&nbsp;id_'.$object_name.'</small></sup> *****</h3>';

$show_descr = $maybe_array['descr'];
echo '<p>АРГУМЕНТЫ:</p>';
echo ' <form method="post" action="change_args.php">
          <input type="hidden" type="text" name="id" value="'.$object_name.'" /><br />
          <textarea name="descr" rows="10" cols="150" >'.$show_descr.'</textarea>
          <p><input type="submit" value="CHANGE_ARGS"></p>
       </form>';
//***********************
echo '<h3>>>> Влияет/дает вес:</h3>';

$res = $mysqli->query("SELECT * FROM links WHERE who = '$show_id' ORDER BY id ASC");
//------> $res_systree = $mysqli->query("SELECT * FROM systree WHERE id = '$object_name' ORDER BY id ASC"); ---------> вот тут правильно что повторно обратился но нужно обращатся к ID потоков, а не СФЕРЫ, но их ID не передаются сюда пока

$res->data_seek(0);
while ($row = $res->fetch_assoc()) {
//echo $row['who'] . "<br/>\n"; // ------> ОСТАВЛЯЮ КАК БЫЛО РАБОЧЕЕ без разукрашивания
// -------> новый код
      $sf_id = $row['him'];
      $res_fw = $mysqli->query("SELECT * FROM systree WHERE name = '$sf_id' ORDER BY id ASC");
      $res_fw_name = $res_fw->fetch_assoc();
      //changes 25082019 weight->worry
      $test_col = getProperColor($res_fw_name['worry']);
      //sf fw 4ker
      $sf4 = $res_fw_name['s_f_4kr'];
      $sf4_w = $res_fw_name['weight'];
      $sf4_d = $res_fw_name['descr'];
      if ($sf4 == 1) {
            $sf4 = '&#8669';
            echo '<p style="color: '.$test_col.'"> Link ID is:'.$row['id'].' - <a href="http://dorel.zzz.com.ua/show_linked_objects.php?id='.$res_fw_name['id'].' "style="color:'.$test_col.'" ">'.$row['him'].'</a><sup><small>'.$sf4_w.'&nbsp;'.$sf4.'&nbsp;'.$sf4_d.'</small></sup></p>';
      } else {
            $sf4 = "&#9884";
            echo '<p style="color: '.$test_col.'"> Link ID is:'.$row['id'].' - <a href="http://dorel.zzz.com.ua/show_linked_objects.php?id='.$res_fw_name['id'].' "style="color:'.$test_col.'" ">'.$row['him'].'</a><sup><small>'.$sf4_w.'&nbsp;'.$sf4.'</small></sup></p>';
      }
//***
}

echo '<h3><<< Зависит от:</h3>';


//******************************* РАБОЧИЙ КУСОК КОДА *********************

$res = $mysqli->query("SELECT * FROM links WHERE him = '$show_id' ORDER BY id ASC");
//------> $res_systree = $mysqli->query("SELECT * FROM systree WHERE id = '$object_name' ORDER BY id ASC"); ---------> вот тут правильно что повторно обратился но нужно обращатся к ID потоков, а не СФЕРЫ, но их ID не передаются сюда пока

$res->data_seek(0);
while ($row = $res->fetch_assoc()) {
//echo $row['who'] . "<br/>\n"; // ------> ОСТАВЛЯЮ КАК БЫЛО РАБОЧЕЕ без разукрашивания
// -------> новый код
      $sf_id = $row['who'];
      $res_fw = $mysqli->query("SELECT * FROM systree WHERE name = '$sf_id' ORDER BY id ASC");
      $res_fw_name = $res_fw->fetch_assoc();
      //changes 25082019 weight->worry
      $test_col = getProperColor($res_fw_name['worry']);
      //sf fw 4ker
      $sf4 = $res_fw_name['s_f_4kr'];
      $sf4_w = $res_fw_name['weight'];
      $sf4_d = $res_fw_name['descr'];
      if ($sf4 == 1) {
            $sf4 = '&#8669';
            echo '<p style="color: '.$test_col.'"> Link ID is:'.$row['id'].' - <a href="http://dorel.zzz.com.ua/show_linked_objects.php?id='.$res_fw_name['id'].' "style="color:'.$test_col.'" ">'.$row['who'].'</a><sup><small>'.$sf4_w.'&nbsp;'.$sf4.'&nbsp;'.$sf4_d.'</small></sup></p>';
      } else {
            $sf4 = "&#9884";
            echo '<p style="color: '.$test_col.'"> Link ID is:'.$row['id'].' - <a href="http://dorel.zzz.com.ua/show_linked_objects.php?id='.$res_fw_name['id'].' "style="color:'.$test_col.'" ">'.$row['who'].'</a><sup><small>'.$sf4_w.'&nbsp;'.$sf4.'</small></sup></p>';
      }

}
//******************************* КОНЕЦ РАБОЧЕГО КОДА

//echo '<h3> *** Дерево зависимости:</h3>';

//******************************* Новый код 26092019

function TreeBuild($id_parent, $parid_par){

  try {
      $pdo = new PDO ('mysql:host=127.0.0.1;dbname=dorel', 'dorel', 'Qq1234567');
    }
    catch (PDOException $e) {
      echo "Невозможно соеденится с БД";
    }

    $query = "SELECT *
              FROM links
              WHERE him = '$id_parent'";
    $cat = $pdo->query($query);
    $i = 0;
    $test_a = array();
    while($catalog = $cat->fetch(PDO::FETCH_ASSOC)){
      $test_a [$i]["fw_id"] = $catalog ['fw_id'];
      $test_a [$i]["name"] = $catalog ['who'];
      $test_a [$i]["parent_name"] = $id_parent;
      $test_a [$i]["parent_id"] = $parid_par;
      $i++;
    }
    return $test_a;
}

/*$a = TreeBuild(СОЦИО);
$b = TreeBuild(Уют);
//передаем значение верхушки и от него строим основной массив
$main_tree = array_merge($a, $b);
*/


$id_top = $object_name;
$id_top_name = $show_id;


$i = 0;
//$id_top = 61;
//$id_top_name = "Здоровье";
$id_top_id = 0;

$main_tree ["0"]["fw_id"] = $id_top;
$main_tree ["0"]["name"] = $id_top_name;
$main_tree ["0"]["parent_id"] = $id_top_id;

//рабочий алогритм перебора главного массива
while (isset($main_tree[$i]["fw_id"])) {
      $a = $main_tree["$i"]["name"];
      $parid = $main_tree["$i"]["fw_id"];
      $c = TreeBuild($a, $parid);
      if ($c)
      {
          $y = array_merge($main_tree, $c);
          $main_tree = $y;
          $i++;
        } else {
          $i++;
        }
}
/*
echo '<pre>';
print_r($main_tree);
echo '</pre>';
*/


//************************************

function buildTree(array &$elements, $parentId = 0) {

    $branch = array();

    foreach ($elements as &$element) {

        if ($element['parent_id'] == $parentId) {
            $children = buildTree($elements, $element['fw_id']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[$element['fw_id']] = $element;
            unset($element);
        }
    }
    return $branch;
}

$c = buildTree($main_tree);
$c[$id_top]['name'] = '**** ДЕРЕВО: >>>>';

//************************************

//*********** 2 ********

function tplMenu($category){

  $mysqli = new mysqli("127.0.0.1", "dorel", "Qq1234567", "dorel");
  $sf_id = $category['name'];
  $res_fw = $mysqli->query("SELECT * FROM systree WHERE name = '$sf_id' ORDER BY id ASC");
  $res_fw_name = $res_fw->fetch_assoc();
  //changes 25082019 weight->worry
  $test_col = getProperColor($res_fw_name['worry']);
  $chekr = $res_fw_name['s_f_4kr'];
  if ($chekr == 1) {
        $chekr = '&#9992';
      } else {
         $chekr = "&#9884";
  }

$menu = '<li>
    <a href= "http://dorel.zzz.com.ua/show_linked_objects.php?id='.$category['fw_id'].' "style="color:'.$test_col.'" >'.$category['name'].'</a><sup><small>'.$chekr.'</small></sup>';
    if(isset($category['children'])){
        $menu .= '<ul>'. showCat($category['children']) .'</ul>';
    }
$menu .= '</li>';
    return $menu;
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
$cat_menu = showCat($c);

//Выводим на экран
echo '<ul>'. $cat_menu .'</ul>';



//******************************* КОНЦЕЦ 26092019

?>
</body>
</html>
