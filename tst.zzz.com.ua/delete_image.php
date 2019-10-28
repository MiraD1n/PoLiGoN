<?php

unlink($_GET['image_id']);
echo $_GET['image_id']." Was deleted!";
header("Location: index.php");
 ?>
