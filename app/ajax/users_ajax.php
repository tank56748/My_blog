<?php if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'): ?>
	<?php include ($_SERVER['DOCUMENT_ROOT'] . '/app/database/db.php'); ?>
	<?php
	// Удаление категории
	if($_POST['action'] == 'delete'){
		$id = $_POST['id'];
		delete('users', $id);
		echo "ok";
	}
	?>
	<?php
	// Сделать админом/Сделать пользователем
	if($_POST['action'] == 'admin'){
			$id = $_POST['id'];
			$do = $_POST['do'];
			update('users', $id, ['admin'=> $do]);
			echo "ok";
	}
	?>
<?php else: echo "Ошибка доступа"; ?>
<?php endif; ?>
