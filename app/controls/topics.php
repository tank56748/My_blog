<?php

$errMsg = [];
$topics = selectAll('topics');
// Код для формы создания категории
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-topic-create'])){
	$name = trim($_POST['name']);
	$description = trim($_POST['description']);
	if($name === '' || $description === '') array_push($errMsg, 'Не все поля заполнены!');
	if(mb_strlen($name, 'UTF8') < 3) array_push($errMsg, 'Имя должно быть более 2-х символов');
	if(empty($errMsg)){
		$existence_name = selectOne('topics', ['name' => $name]);
		if($existence_name['name'] === $name){
			array_push($errMsg, 'Введенная категория уже существует');
		}
		else{
			$topic = [
				"name" => $name,
				"description" => $description,
			];
			$id = insert("topics", $topic);
			$topic = selectOne('topics', ['id' => $id]);
			header('location: ' . $http . $_SERVER['SERVER_NAME'] . '/?page=ADM_topics_index');
		}
	}
}else {
	$description = '';
	$name = '';
}

// Редактирование категории
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])){
	$id = $_GET['id'];
	$edit = selectOne('topics', ['id' => $id]);
	$id = $edit['id'];
	$name = $edit['name'];
	$description = $edit['description'];
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-topic-update'])){
	$name = trim($_POST['name']);
	$description = trim($_POST['description']);
	$id = $_POST['id'];
	if($name === '' || $description === '') array_push($errMsg, 'Не все поля заполнены!');
	if(mb_strlen($name, 'UTF8') < 3) array_push($errMsg, 'Имя должно быть более 2-х символов');
	if(empty($errMsg)){
			$topic = [
				"name" => $name,
				"description" => $description,
				"id" => $id
			];
			update('topics', $id, $topic);
			header('location: ' . $http . $_SERVER['SERVER_NAME'] . '?page=ADM_topics_index');
	}
}

?>