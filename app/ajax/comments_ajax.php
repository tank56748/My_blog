<?php if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'): ?>
	<?php include ($_SERVER['DOCUMENT_ROOT'] . '/app/database/db.php'); ?>
	<?
	if($_POST['action'] == 'likes'){
		$id_user = $_POST['id_user'];
		$id_post = $_POST['id_post'];
		$change = $_POST['change'];
		if($change == 1){
			global $pdo;
			$sql = "SELECT * FROM likes_users WHERE id_user = $id_user AND id_post = $id_post";
			$query = $pdo->prepare($sql);
			$query->execute();
			$row = $query->rowCount();
			if($row == 0){
				insert('likes_users', ['id_user' => $id_user, 'id_post' => $id_post]);
				$sql = "UPDATE posts SET likes = likes + 1 WHERE id = $id_post";
				$query = $pdo->prepare($sql);
				$query->execute();
				echo 'ok1';
			}else{
				echo 'Лайк уже стоит';
			}
		}elseif($change == 0){
			global $pdo;
			$sql = "DELETE FROM likes_users WHERE id_user = $id_user AND id_post = $id_post";
			$query = $pdo->prepare($sql);
			$query->execute();
			$row = $query->rowCount();
			if($row == 1){
				$sql = "UPDATE posts SET likes = likes - 1 WHERE id = $id_post";
				$query = $pdo->prepare($sql);
				$query->execute();
				echo 'ok2';
			}else{
				echo 'Ошибка удаления';
			}
		}
	}
	if($_POST['action'] == 'add_com'){
		$comment = $_POST['comment'];
		$login = $_POST['login'];
		$post_id = $_POST['post_id'];
		$session = $_POST['session'];
		if($session == 0 && !filter_var($login, FILTER_VALIDATE_EMAIL)){
			echo "Email $login указан неверно!";
		}elseif(strlen($comment) < 3){
			echo 'Комментарий слишком короткий!';
		}else{
			$comment = trim(strip_tags(stripcslashes(htmlspecialchars($comment))));
			if($session == 0){
				$login = trim(strip_tags(stripcslashes(htmlspecialchars($login))));
			}
			$com = [
				'comment' => $comment,
				'id_post' => $post_id,
				'login' => $login,
			];
			insert('comments', $com);
			echo 'ok';
		}
	}
	if($_POST['action'] == 'del_com'){
		$id = $_POST['id'];
		delete('comments', $id);
		echo 'ok';
	}
	?>
<?php else: echo "Ошибка доступа"; ?>
<?php endif; ?>