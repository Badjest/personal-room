<?php
  
  $id = $_GET['idorder'];
  include("connect.php");


  mysql_query("DELETE goods_into_order FROM goods_into_order INNER JOIN orders ON goods_into_order.idorder = orders.idorder WHERE orders.iduser = ".$_COOKIE['id'] . " and goods_into_order.idorder = ". $id);
  
  mysql_query("DELETE orders FROM orders WHERE idorder = ". $id);
  
  mysql_close();
?>