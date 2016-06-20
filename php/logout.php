<?php
	session_start();
	$_SESSION['login'] = "";
	$_SESSION['password'] = "";

	if (isset($_COOKIE['id'])) {
    unset($_COOKIE['id']);
    unset($_COOKIE['hash']);
    setcookie('hash', null, -1, '/sample');
    setcookie('id', null, -1, '/sample');
	}

	header("Location: ../index.php");
	exit;
?>