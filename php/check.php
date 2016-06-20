<?
session_start();

include('connect.php');

if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{   

     $query = mysql_query("SELECT * FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");

     $userdata = mysql_fetch_assoc($query);
	
        $login = $userdata["user_login"];
		$_SESSION['login'] = $login;
        header("Location: ../app.php");
	}	 
 else
 {
     print "Включите куки";
 }
mysql_close();
?>