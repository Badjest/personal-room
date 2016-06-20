<?

include("connect.php");

if(isset($_POST['reg']))
{
    $err = array();

    
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    }

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    }

   
    $query = mysql_query("SELECT COUNT(user_id) as col FROM users WHERE user_login='".$_POST['login']."'");
    $row = mysql_fetch_assoc($query);
    if( $row["col"] > 0)
    {
        $err[] = "Пользователь с таким логином уже существует";
    }

    
    if(count($err) == 0)
    {

        $login = $_POST['login'];
       
        $password = md5(md5(trim($_POST['password'])));

        mysql_query("INSERT INTO users SET user_login='".$login."', user_password='".$password."'");
        print "Вы успешно зарегестрировались <a href='../index.php'>Вернуться</a>";


    }
    else
    {
        print "<b>При регистрации произошли следующие ошибки:</b><br>";
        foreach($err AS $error)
        {
            print $error."<br>";
        }
    }
}
mysql_close();
?>

