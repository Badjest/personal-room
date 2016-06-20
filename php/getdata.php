<?php

$variant = $_GET['variant'];

include("connect.php");

$array = array();
if ( $variant == "all" )
{$result = mysql_query("SELECT orders.idorder , goods_into_order.idgood, goods.good_name , goods.good_price, goods_into_order.countgood FROM goods_into_order join orders on goods_into_order.idorder = orders.idorder join users on orders.iduser = users.user_id join goods on goods_into_order.idgood = goods.idgood WHERE orders.iduser = " .$_COOKIE['id'] );
}

if ( $variant == "good" )
{
   $result = mysql_query("SELECT * FROM goods");
}

while ($orders = mysql_fetch_assoc($result)) {
$array[] =  $orders;
}

echo json_encode($array);

mysql_close();
?>