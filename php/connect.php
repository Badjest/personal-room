<?php
$host = 'localhost';
$user = 'root';
$password = 'root';
$database = 'sample';

$link = mysql_connect($host, $user, $password)
or die('Не удалось соединиться: ' . mysql_error());
mysql_query("SET NAMES utf8");
mysql_select_db($database) or die('Не удалось выбрать базу данных');
    ?>