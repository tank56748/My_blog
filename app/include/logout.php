<?php include ($_SERVER['DOCUMENT_ROOT'] . '/app/controls/users.php');?>
<?php
if($_SESSION['FAIL_NUM'] > 3) {
	header('location: '.$http.$_SERVER['SERVER_NAME']);
}else{
	session_start();
	unset($_SESSION['id']);
	unset($_SESSION['login']);
	unset($_SESSION['admin']);
	unset($_SESSION['FAIL_NUM']);
	header('location: ' . $http . $_SERVER['SERVER_NAME']);
}
?>