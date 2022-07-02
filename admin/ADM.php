<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<?php
$time1 = microtime();
if($_SESSION['admin'] == 1){
	if(strpos($page, "posts") !== false){
		include ($_SERVER['DOCUMENT_ROOT'] . "/admin/posts/$page.php");
	}elseif(strpos($page, "settings") !== false){
		include ($_SERVER['DOCUMENT_ROOT'] . "/admin/settings/$page.php");
	}elseif(strpos($page, "topics") !== false){
		include ($_SERVER['DOCUMENT_ROOT'] . "/admin/topics/$page.php");
	}elseif(strpos($page, "users") !== false){
		include ($_SERVER['DOCUMENT_ROOT'] . "/admin/users/$page.php");
	}
}else{
	include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/error_access.php');
}

$time2 = microtime() - $time1;
echo $time2;


?>