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
	?>

<?php else: echo "Ошибка доступа"; ?>
<?php endif; ?>
