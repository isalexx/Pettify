<?php
session_start();

require_once("connect.php");
$db -> query("DELETE FROM pettify_users WHERE user_id = {$_SESSION['user']['user_id']}");

unset($_SESSION['user']);

header("Location: register.php");

exit();
