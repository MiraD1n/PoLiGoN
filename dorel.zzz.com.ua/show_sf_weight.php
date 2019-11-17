<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css" />
  <title>Пример веб-страницы</title>
 </head>
 <body>
<a href="http://dorel.zzz.com.ua/show_sf.php" class="c">TUBLER_WORRY<a><br/>
<br/>
<p><a href="index.php">На ГЛАВНУЮ</a><br/>
<!--<form action="show_sf.php">
  <p><input type="submit" value="TUBLER_WORRY"></p>
</form>
<p><a href="index.php">Назад</a><br/>-->
<h5>*Weight of each of SFERA...tap provide you change weight,worry and link</h5>
<h5>*+/- change WEIGHT</h5>
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

/*
 * Если нужно быть уверенным в совместимости с версиями до 5.2.9,
 * лучше использовать такой код

if (mysqli_connect_error()) {
    die('Ошибка подключения (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}
*/

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

// *************** Блок кода на изменение цвета
function getProperColor($col_lk)
{
    if ($col_lk <= 3)
        $var = '#008000';
    else if ($col_lk >= 4 && $col_lk <= 6)
        $var = '#4682B4';
    else if ($col_lk == 7)
        $var = '#0000CD';
    else if ($col_lk == 8)
        $var = '#C71585';
    else if ($col_lk >= 9)
        $var = '#FF0000';
$col_lk = $var;
return $col_lk;
}


// Блок Worry 1 или 0
/*function getProperColor($col_lk)
{
    if ($col_lk == 0)
        $var = '#4682B4';
    else if ($col_lk == 1)
        $var = '#FF0000';
    else $var = 'blue';
$col_lk = $var;
return $col_lk;
}

/* '<?=getProperColor($result['number'])?>;'*/

//использование
/*<div style="background-color: <?=getProperColor($result['number'])?>;"><?=$result["title"]?></div>*/
// ***************** Конец блока кода на изменение цвета

//Шаблон для вывода меню в виде дерева

//$col_link = 5;
//$test_col = getProperColor($col_link);

//*вместо ссылки использовать ссылку на обьект для изменений
function tplMenu($category){
//    $number = '#FF8000'; - это работает пробую через вызов функции
//$col_link = '#FF0000'; - крассыный
$test_col = getProperColor($category['weight']);
//echo $category['worry'];
//echo $test_col;
//$test_col = 'red';
    $menu = '<li>
        <a href= "http://dorel.zzz.com.ua/minus.php?id='.$category['id'].'" class="as" >-1</a>
        <a href= "http://dorel.zzz.com.ua/chenger.php?id='.$category['id'].'" style="color: '.$test_col.'" name=" '. $category['name'] .'">'.
        $category['name'].'</a>
        <a href= "http://dorel.zzz.com.ua/plus.php?id='.$category['id'].'" class="as" >+1</a>';
        if(isset($category['childs'])){
            $menu .= '<ul>'. showCat($category['childs']) .'</ul>';
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
$cat_menu = showCat($tree);

//Выводим на экран
echo '<ul>'. $cat_menu .'</ul>';

?>
</body>
</html>
