<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="style.css" />
  <title>Пример веб-страницы</title>
  <style>
  .sign {
 float: left; /* Выравнивание по правому краю */
 /*border: 1px solid #333; /* Параметры рамки */
 padding: 7px; /* Поля внутри блока */
 margin: 10px 0 5px 5px; /* Отступы вокруг */
 /*background: #f0f0f0; /* Цвет фона */
}
.sign figcaption {
 margin: 0 auto 5px; /* Отступы вокруг абзаца */
 text-align: center;
 font-size: 15px;
}
  </style>
 </head>
 <body>
   <a href="http://dorel.zzz.com.ua/show_sf.php"><img src="sferas.png" width="100"
      height="100" alt="sferas"><a>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
   <a href="http://dorel.zzz.com.ua/show_flow_links_prioweight.php"><img src="flows.png" width="100" height="100" alt="flows"><a><br/>
<!--  <p><a href="index.php">MAIN</a></p>-->
<?php
   $mysqli = new mysqli("127.0.0.1", "dorel", "Qq1234567", "dorel");

   /* проверка соединения */
   if ($mysqli->connect_errno) {
       printf("Соединение не удалось: %s\n", $mysqli->connect_error);
       exit();
   }

   $query = "SELECT * FROM systree WHERE s_f_4kr = 1 ORDER BY weight DESC";

   if ($result = $mysqli->query($query)) {

       /* извлечение ассоциативного массива */
       while ($row = $result->fetch_assoc()) {
         $ident=$row['id'];
         $idname=$row['name'];
         $idpers=$row['pers'];

// ************ проверка есть бейдж, нет или это КТ
          $file_pointer = 'bages/'.$ident.'.png';

          if ($idpers > 100)
          {
              $file_pointer = 'bages/kt.png';
          }
          else if (file_exists($file_pointer))
          {
              $file_pointer = 'bages/'.$ident.'.png';
          }
          else
          {
              $file_pointer = 'bages/blank.png';
          }
//************ конец проверки

//************ проверка процентов выполнения
         $pers_pointer = 'bages/bar.png';

          if ($idpers >= 10 && $idpers <= 19)
              $pers_pointer = 'bages/bar10.png';
          else if ($idpers >= 20 && $idpers <= 29)
              $pers_pointer = 'bages/bar20.png';
          else if ($idpers >= 30 && $idpers <= 39)
              $pers_pointer = 'bages/bar30.png';
          else if ($idpers >= 40 && $idpers <= 49)
              $pers_pointer = 'bages/bar40.png';
          else if ($idpers >= 50 && $idpers <= 59)
              $pers_pointer = 'bages/bar50.png';
          else if ($idpers >= 60 && $idpers <= 69)
              $pers_pointer = 'bages/bar60.png';
          else if ($idpers >= 70 && $idpers <= 79)
              $pers_pointer = 'bages/bar70.png';
          else if ($idpers >= 80 && $idpers <= 89)
              $pers_pointer = 'bages/bar80.png';
          else if ($idpers >= 90 && $idpers <= 99)
              $pers_pointer = 'bages/bar90.png';
          else if ($idpers == 100)
              $pers_pointer = 'bages/bar100.png';
//************ конец процентов

          echo '<figure class = sign>';
          echo '<a href= "http://dorel.zzz.com.ua/show_linked_objects.php?id='.$ident.'"><img weight=130 height=130 src="'.$file_pointer.'"></a>';
          echo '<figcaption>'.$idname.'</figcaption>';
          echo '<a href= "http://dorel.zzz.com.ua/chenger.php?id='.$ident.'"><img weight=15 height=15 src="'.$pers_pointer.'"></a>';
          echo '</figure>';
       }

       /* удаление выборки */
       $result->free();
   }

   /* закрытие соединения */
   $mysqli->close();
   ?>

 </body>
</html>
