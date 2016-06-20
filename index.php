<?

function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}


include 'php/connect.php';

if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{   

     $query = mysql_query("SELECT * FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");

     $userdata = mysql_fetch_assoc($query);
	
        $login = $userdata["user_login"];
		$_SESSION['login'] = $login;
        header("Location: app.php");
}

if(isset($_POST['submit']))
{
    $query = mysql_query("SELECT user_id, user_password FROM users WHERE user_login='".$_POST['login']."' LIMIT 1");
    $data = mysql_fetch_assoc($query);

    if($data['user_password'] === md5(md5($_POST['password'])))
    {

        $hash = md5(generateCode(10));

        mysql_query("UPDATE users SET user_hash='".$hash."' WHERE user_id='".$data['user_id']."'");

        setcookie("id", $data['user_id'], time()+60*60*24*30);
        setcookie("hash", $hash, time()+60*60*24*30);

        header("Location: http://$host$uri"); exit();
    }
    else
    {
        print "Вы ввели неправильный логин/пароль";
    }
}
mysql_close();
?>


<!DOCTYPE html>
<!--[if lt IE 7]><html lang="ru" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html lang="ru" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html lang="ru" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="ru">
<!--<![endif]-->
<head>

	<meta charset="utf-8" />

	<title>Вход в личный кабинет</title>
	<meta content="" name="description" />
	<meta content="" property="og:image" />
	<meta content="" property="og:description" />
	<meta content="" property="og:site_name" />
	<meta content="website" property="og:type" />

	<meta content="telephone=no" name="format-detection" />
	<meta http-equiv="x-rim-auto-match" content="none">

	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<link rel="stylesheet" href="libs/bootstrap/bootstrap-grid-3.3.1.min.css" />
	<link rel="stylesheet" href="css/fonts.css" />
	<link rel="stylesheet" href="css/main.css" />
	<link rel="stylesheet" href="css/media.css" />
	<script type="text/javascript" src="libs/ajax/jquery.min.js"></script>
</head>
<body>
	<div class="row">
		<div class="container">
			<div class="top_tx">
				<div class="col-md-6">Заказы и товары. <br>Личный кабинет</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="container">
			<div class="col-md-6">
				<div class="tabs_header">
					<div class="wrapper">
						<div class="tabs">
							<span class="tab">Вход</span> 
							<span class="tab">Регистрация</span>      
						</div>
						<div class="tab_content">
							<div class="tab_item">
								<form method="post"  class="form_begin">
									<label>
										<span id="log">Логин: </span>
										<input type="text" name="login" required/>
									</label>
									<label>
										<span id="pass">Пароль:</span>
										<input type="password" name="password" required />
									</label>
									<button name="submit">
										Вход
									</button>
								</form>
							</div>
							<div class="tab_item">
								<form action="php/register.php" method="post" class="form_begin">
									<label>
										<span id="log">Логин: </span>
										<input type="text" name="login" required/>
									</label>
									<label>
										<span id="pass">Пароль:</span>
										<input type="password" name="password" required />
									</label>
									<button type="submit" name="reg">
										Регистрация
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</container>
		</div>
	</div>


<script src="libs/bootstrap-toolkit/bootstrap-toolkit.min.js"></script>
<script src="js/first.js"></script>

</body>
</html>