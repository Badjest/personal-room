<!DOCTYPE html>
<!--[if lt IE 7]><html lang="ru" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html lang="ru" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html lang="ru" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<?php
session_start();
$logins=$_SESSION['login'];
?>
<html lang="ru">
<!--<![endif]-->
<head>

	<meta charset="utf-8" />

	<title>Личный кабинет</title>
	<meta content="" name="description" />
	<meta content="" property="og:image" />
	<meta content="" property="og:description" />
	<meta content="" property="og:site_name" />
	<meta content="website" property="og:type" />

	<meta content="telephone=no" name="format-detection" />
	<meta http-equiv="x-rim-auto-match" content="none">

	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<link rel="stylesheet" href="libs/fancybox/jquery.fancybox.css" />
	<link rel="stylesheet" href="libs/bootstrap/bootstrap-grid-3.3.1.min.css" />
	<link rel="stylesheet" href="css/fonts.css" />
	<link rel="stylesheet" href="css/app.css" />
	<link rel="stylesheet" href="css/media.css" />
	<script type="text/javascript" src="libs/ajax/jquery.min.js"></script>
</head>
<body>
	<img src="loading.gif" id="imgLoad" style="display:none">
	<?php
	session_start();
	if (empty($_SESSION['login']))
		{ header("Location: index.php");}
		$login = $_SESSION['login'];
	?>
	<div class="top"> 
		<div class="row">
			<div class="container">
				<div class="col-md-6"></div>
				<div class="col-md-6">
					<?php
					echo "<p>Привет, $logins ! <br><a href='php/logout.php'>Выход</a></p>";
					?>
				</div>
			</div>
		</div>
	</div>	

	<div id="order_dialog" style='display:none;'>
	<button class="addcont" id="new_good">Добавить товар</button>
	
	<table class="top_table">
			<tr>
			<th>Товар</th>
			<th>Цена</th>
			<th>Количество</th>
			</tr>
			</table>
	<div class="list_view_good">
		<table id="goods_table">
			
		</table>
	</div>
	
	<p id='itog'>Итого: 0</p>
	<div class="buttons">
		<button class="addcont" id="save_order">Сохранить</button>
		<button class="addcont" id="close_fan">Отмена</button>
	</div>

	</div>
	
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2>Мои заказы</h2><div class="right_but"><button href="#order_dialog" class="addcont new_order" > Новый заказ</button>
					</div>
								
								<table class="top_table">
								<tr>
								<th>Номер Заказа</th>
								<th>Сумма</th>
								<th>Опции</th>
								</tr>
								</table>

					<div class="list_view">
						<table>
							
						</table>
						</div>
						<p id="sum_orders"></p>
				</div>
			</div>
		</div>
	</div>
	
	
	
<script src="libs/fancybox/jquery.fancybox.pack.js"></script>
<script src="libs/bootstrap-toolkit/bootstrap-toolkit.min.js"></script>
<script src="js/common.js"></script>

</body>
</html>