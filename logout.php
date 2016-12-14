<?php
session_start();
unset($_SESSION["visited_login"]);
session_destroy();
header("Location:http://localhost/login1.php");
exit;
?>