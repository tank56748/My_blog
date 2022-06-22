<?php
$errMsg = [];
$post_id = $_GET['id_post'];

// Код для формы создания комментария
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['button-comment'])){
	$comment = $_POST['comment'];
	if(isset($_SESSION['login'])){
		$login = $_SESSION['login'];
	}else{
		$login = $_POST['login'];
		if(!filter_var($login, FILTER_VALIDATE_EMAIL)){
			array_push($errMsg, "Email $login указан неверно!");
		}
	}
	if(strlen($comment) < 3){
		array_push($errMsg, "Комментарий слишком короткий!");
	}
	if(empty($errMsg)){
		$comment = trim(strip_tags(stripcslashes(htmlspecialchars($comment))));
		if(!isset($_SESSION['login'])){
			$login = trim(strip_tags(stripcslashes(htmlspecialchars($login))));
		}
		$com = [
			'comment' => $comment,
			'id_post' => $post_id,
			'login' => $login,
		];
		insert('comments', $com);
	}
}
?>