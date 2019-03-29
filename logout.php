<?php
session_start();
if (isset($_SESSION['admin_login_session'] )) {
	session_destroy();
	header('Location: index.php');
}else{
	header('Location: index.php');
}

session_destroy();

?>