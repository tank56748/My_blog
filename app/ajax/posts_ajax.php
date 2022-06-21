<?php if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'): ?>
	<?php include ($_SERVER['DOCUMENT_ROOT'] . '/app/database/db.php'); ?>
	<?php
	// Удаление поста
	if($_POST['action'] == 'delete'){
		$id = $_POST['id'];
		$del_post = selectOne('posts', ["id" => $id]);
		if(!empty($del_post['img']) && $del_post['img'] != "nofoto.png"){
			$del_link_img = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/posts/" . $del_post['img'];
			unlink($del_link_img);
		}
		delete("posts", $id);
		echo "ok";
	}
	// Опубликовать/Снять с публикации запись
	if($_POST['action'] == 'status'){
		$id = $_POST['id'];
		$do = $_POST['do'];
		update('posts', $id, ['status'=> $do]);
		echo "ok";
	}
	?>
<?php else: echo "Ошибка доступа"; ?>
<?php endif; ?>