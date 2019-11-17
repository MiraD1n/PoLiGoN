<?php
//рабочая функция зависимостей
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
    while($catalog = $cat->fetch(PDO::FETCH_ASSOC)){
      $test_a [$i][fw_id] = $catalog ['fw_id'];
      $test_a [$i][name] = $catalog ['who'];
      $test_a [$i][parent_name] = $id_parent;
      $test_a [$i][parent_id] = $parid_par;
      $i++;
    }
    return $test_a;
}

/*$a = TreeBuild(СОЦИО);
$b = TreeBuild(Уют);
//передаем значение верхушки и от него строим основной массив
$main_tree = array_merge($a, $b);
*/


$id_top = $_POST['id_zavis'];
$id_top_name = $_POST['name_zavis'];


$i = 0;
//$id_top = 61;
//$id_top_name = "Здоровье";
$id_top_id = 0;

$main_tree ["0"]["fw_id"] = $id_top;
$main_tree ["0"]["name"] = $id_top_name;
$main_tree ["0"]["parent_id"] = $id_top_id;

//рабочий алогритм перебора главного массива
while (isset($main_tree[$i][fw_id])) {
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

/*
echo '<pre>';
print_r($c);
echo '</pre>';
*/
//************************************

//*********** 2 ********

function tplMenu($category){

$menu = '<li>
    <a href= "" >'.$category['name'].'</a>';
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

//**********************

?>
