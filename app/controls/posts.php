<?php

$errMsg = [];
$id = '';
$title = '';
$img = '';
$content = '';
$topics = '';


$topics = selectAll('topics');
$posts = selectAll('posts');

// Код для формы создания записи
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-post-create'])){

	$title = trim($_POST['title']);
	$content = trim($_POST['content']);
	$topic = trim($_POST['category']);
	$img = trim($_POST['img']);
	$public = trim($_POST['public']);

	if($title === '' || $content === '' || $topic === '') array_push($errMsg, "Не все поля заполнены!");
	if(mb_strlen($title, 'UTF8') < 7) array_push($errMsg, "Название статьи должно быть более 6 символов");
	if(!empty($_FILES['img']['name']) && strpos(mime_content_type($_FILES['img']['tmp_name']), "image") === false) array_push($errMsg, "Файл не является изображением");
	/*if(!empty($_FILES['img']['name']) && (getimagesize($_FILES['img']['tmp_name'])[0] > 1000 || getimagesize($_FILES['img']['tmp_name'])[1] > 1000)) array_push($errMsg, "Ширина или высота не соответствуют требованиям!");*/
	if(strpos($title, "'") !== false) array_push($errMsg, "Замените одинарные кавычки на двойные!");
	if(empty($errMsg)){
		$imgname = date("o-F-d_H:i:s_") . $_FILES['img']['name'];
		$fileTmpName = $_FILES['img']['tmp_name'];
		$destination = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/posts/" . $imgname;
		$result = move_uploaded_file($fileTmpName, $destination);
		if(empty($_FILES['img']['name'])){
			$result = true;
		}
		if($result){
			$img = $imgname;
			if(empty($_FILES['img']['name'])){
				$img = "nofoto.png";
			}
			$content = addslashes($content);
			$post = [
				"id_user" => $_SESSION['id'],
				"title" => $title,
				"content" => $content,
				"img" => $img,
				"status" => $public,
				"id_topic" => $topic
			];
			$post = insert("posts", $post);
			$post = selectOne('posts', ['id' => $id]);
			header('location: ' . $http . $_SERVER['SERVER_NAME'] . '?page=ADM_posts_index');
		}else{
			array_push($errMsg, "Ошибка загрузки изображения на сервер");
		}
	}
}else {
	$title = '';
	$content = '';
}

// Редактирование записи
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])){
	$edit = selectOne('posts', ['id' => $_GET['id']]);
	$id = $edit['id'];
	$title = $edit['title'];
	$content = $edit['content'];
	$img = $edit['img'];
	$topic_id = $edit['id_topic'];
	$status = $edit['status'];
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-post-update'])){
	$title = trim($_POST['title']);
	$content = trim($_POST['content']);
	$id = $_POST['id'];
	$topic = trim($_POST['category']);
	$img = trim($_POST['img']);
	$public = trim($_POST['public']);

	if($title === '' || $content === '' || $topic === '') array_push($errMsg, "Не все поля заполнены!");
	if(mb_strlen($title, 'UTF8') < 7) array_push($errMsg, "Название статьи должно быть более 6 символов");
	if(!empty($_FILES['img']['name']) && strpos(mime_content_type($_FILES['img']['tmp_name']), "image") === false) array_push($errMsg, "Файл не является изображением");
	/*if(!empty($_FILES['img']['name']) && (getimagesize($_FILES['img']['tmp_name'])[0] > 1000 || getimagesize($_FILES['img']['tmp_name'])[1] > 1000)) array_push($errMsg, "Ширина или высота не соответствуют требованиям!");*/
	if(strpos($title, "'") !== false) array_push($errMsg, "Замените одинарные кавычки на двойные!");
	if(!empty($errMsg)){
		$status = isset($_POST['public']) ? 1 : 0;
		$_SESSION["image_path"] = $_POST['img'];
	}
	if(empty($errMsg)){
		$imgname = date("o-F-d_H:i:s_") . $_FILES['img']['name'];
		$fileTmpName = $_FILES['img']['tmp_name'];
		$destination = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/posts/" . $imgname;
		$result = move_uploaded_file($fileTmpName, $destination);
		if(empty($_FILES['img']['name'])){
			$result = true;
		}
		if($result){
			$q = selectOne('posts', ['id' => $_GET['id']]);
			if(empty($_FILES['img']['name'])){
				$img = $q['img'];
			}else{
				$img = $imgname;
				$del_link_img = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/posts/" . $q['img'];
				unlink($del_link_img);
			}
			$content = addslashes($content);
			$post = [
				"id_user" => $_SESSION['id'],
				"title" => $title,
				"content" => $content,
				"img" => $img,
				"status" => $public,
				"id_topic" => $topic
			];
			update("posts", $id, $post);
			$post = selectOne('posts', ['id' => $id]);
			header('location: ' . $http . $_SERVER['SERVER_NAME'] . '?page=ADM_posts_index');
		}else{
			array_push($errMsg, "Ошибка загрузки изображения на сервер");
		}
	}
}

$status_index = ["1" => "Опубликован", "0" => "В черновике"];
?>
