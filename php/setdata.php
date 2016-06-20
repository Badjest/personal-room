<?php

$json;

  if(isset($_POST['categories'])) {
    $json = $_POST['categories'];
    $json = json_decode($json, true);
  } else {
    echo "Noooooooob";
  }
 

  include("connect.php");

  $del = mysql_query("DELETE goods_into_order FROM goods_into_order INNER JOIN orders ON goods_into_order.idorder = orders.idorder WHERE orders.iduser = " .$_COOKIE['id']);

  for ($i = 0; $i < count($json); $i++) 
  { 
    
  	if ( is_null($json[$i]["idorder"]))
  	{
  		mysql_query("INSERT INTO orders (idorder, iduser) VALUES (NULL, ".$_COOKIE['id'].")");
  		$id = mysql_insert_id();
  		for ($j = 0; $j < count($json[$i]["good"]); $j++) 
  		{
  			
			  mysql_query("INSERT INTO goods_into_order (idgoodsintoorder, idgood, idorder, countgood) VALUES (NULL," .$json[$i]["good"][$j]["idgood"]. ",".$id." , ".$json[$i]["good"][$j]["countgood"]." )");
			
		}
  	}
  	else
  	{
  		$rs = mysql_query("SELECT goods_into_order.idgood as idgood FROM goods_into_order join orders on goods_into_order.idorder = orders.idorder WHERE orders.iduser = " .$_COOKIE['id']. " AND orders.idorder = " .$json[$i]["idorder"]);


  		for ($j = 0; $j < count($json[$i]["good"]); $j++) 
  		{
  			$key = 0;
  			while($row = mysql_fetch_array($rs)) {
  				
			if(	intval($json[$i]["good"][$j]["idgood"]) == intval($row['idgood']))
			{
				mysql_query("
    			UPDATE goods_into_order a 
   				JOIN orders b ON a.idorder = b.idorder 
   				SET a.countgood = a.countgood + ".$json[$i]["good"][$j]["countgood"]."
   				where b.idorder = ".$json[$i]["idorder"] ." and b.iduser =
   				". $_COOKIE['id'] ."
				");
				$key = 1;
				break;	
			} 
			}
			if ($key == 0)
			{
			  mysql_query("INSERT INTO goods_into_order (idgoodsintoorder, idgood, idorder, countgood) VALUES (NULL," .$json[$i]["good"][$j]["idgood"]. ",".$json[$i]["idorder"]." , ".$json[$i]["good"][$j]["countgood"]." )");
			} 
		}

  		}
  } 
   mysql_close();
?>