<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css" />
  <title>Пример веб-страницы</title>
 </head>
 <body>
<!-- Комментарий -->
<!-- <a href="http://dorel.zzz.com.ua/connect.php" class="c">CONNECT<a> -->
<br/>
<!--<a href="http://dorel.zzz.com.ua/show_sf.php" class="c">SHOW SF<a><br/>-->
<a href="http://dorel.zzz.com.ua/show_sf.php"><img src="sferas.png" width="100"
   height="100" alt="sferas"><a>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<a href="http://dorel.zzz.com.ua/show_flow_links_prioweight.php"><img src="flows.png" width="100" height="100" alt="flows"><a>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<p><a href="show_log.php" class="c">ЛОГ-ФАЙЛ</a>&nbsp; &nbsp;
<a href="http://dorel.zzz.com.ua/dayway.php" class="c">BAGES</a>&nbsp; &nbsp;[
<a href="pride_mx.php" class="c">MX</a>&nbsp; &nbsp;
<a href="pride_ma.php" class="c">M@</a> &nbsp; &nbsp;
<a href="pride_sf.php" class="c">SF</a>] <br/>
<!--<a href="http://dorel.zzz.com.ua/show_flows_links.php" class="c">SHOW FW<a><br/>-->
<!--<form action="connect.php">
  <p><input type="submit" value="CONNECT"></p>
</form>
<form action="show_sf.php">
  <p><input type="submit" value="SHOW SF"></p>
</form>
<form action="show_flows_links.php">
  <p><input type="submit" value="SHOW FW"></p>
</form>
-->
<br/>
< ---------CREATE_NEW_OBJECT--------->
  <form method="post" action="add_new_object.php">
             NAME:  <input type="text" name="name" value="" /><br />
             WEIGHT:  <input type="text" name="weight" value="1" /><br />
             WORRY (0 нет/1 отложено,зависит/2 тревожит):  <input type="text" name="worry" value="0" /><br />
             SF/FW_4kr/DONE (0-SF/1-FW/2-DONE/3-DONE KT):  <input type="text" name="s_f_4kr" value="0" /><br />
             PARENT (id of topper sfera):  <input type="text" name="parent" value="0" /><br />
             <p><input type="submit" value="CREATE"></p>
  </form>
< ----------DELETE_OBJECT------------->
  <form method="post" action="delete_id_object.php">
               ID:  <input type="text" name="id" value="" /><br />
               <p><input type="submit" value="DELETE OBJECT"></p>
  </form>
< ----------DELETE_LINK--------------->
    <form method="post" action="delete_id_link.php">
                 ID_Link:  <input type="text" name="id_link" value="" /><br />
                 <p><input type="submit" value="DELETE LINK"></p>
    </form>
 </body>
</html>
