<?php
session_start();
require ($_SERVER['DOCUMENT_ROOT'] . '/app/database/connect.php');
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
if(isset($_SERVER['HTTPS'])){
	$http = "https://";
}else{
	$http = "http://";
}
$minutesBeforeSessionExpire=300;
if (isset($_SESSION['FAIL_TIME']) && (time() - $_SESSION['FAIL_TIME'] > ($minutesBeforeSessionExpire))) {
	unset($_SESSION['FAIL_TIME']);
	unset($_SESSION['FAIL_NUM']);
}

// Авторизация
function userAuth($arr){
	global $http;
	$_SESSION['id'] = $arr['id'];
	$_SESSION['login'] = $arr['username'];
	$_SESSION['admin'] = $arr['admin'];
	if($_SESSION['admin']){
		header('location: ' . $http . $_SERVER['SERVER_NAME'] . '/?page=ADM_posts_index');
	}else{
		header('location: ' . $http . $_SERVER['SERVER_NAME']);
	}
}

// Куки логин
function cookie_login($email){
	$cookie = $email . microtime();
	$cookie = addslashes($cookie);
	$cookie_hash = password_hash($cookie, PASSWORD_DEFAULT);
	setcookie('cookie_login', $cookie_hash, time() + 3600*24*30, '/');
	global $pdo;
	$sql = "UPDATE users SET cookie_login = '$cookie_hash' WHERE email = '$email'";
	$query = $pdo->prepare($sql);
	$query->execute();
}

// Принт пре
function tt($value){
	echo "<pre>";
	print_r($value);
	echo "</pre>";
}

// Функции к базе данных

// Проверка выполнения запроса к БД
function dbCheckError($query){
	$errInfo = $query->errorInfo();
	if($errInfo[0] !== PDO::ERR_NONE){
		echo $errInfo[2];
		exit();
	}
	return true;
}

// Запрос на получение данных одной таблицы
function selectAll($table, $params = []){
	global $pdo;
	$sql = "SELECT * from $table";
	if(!empty($params)){
		$i = 0;
		foreach($params as $key => $value){
			if(!is_numeric($value)){
				$value = "'".$value."'";
			}
			if($i === 0){
				$sql .= " WHERE $key=$value";
			}else{
				$sql .= " AND $key=$value";
			}
			$i++;
		}
	}
	$query = $pdo->prepare($sql);
	$query->execute();
	dbCheckError($query);
	return $query->fetchAll();
}

// Запрос на получение одной строки с выбранной таблицы
function selectOne($table, $params = []){
	global $pdo;
	$sql = "SELECT * from $table";
	if(!empty($params)){
		$i = 0;
		foreach($params as $key => $value){
			if(!is_numeric($value)){
				$value = "'".$value."'";
			}
			if($i === 0){
				$sql .= " WHERE $key=$value";
			}else{
				$sql .= " AND $key=$value";
			}
			$i++;
		}
	}
//	$sql .= " LIMIT 1";
	$query = $pdo->prepare($sql);
	$query->execute();
	dbCheckError($query);
	return $query->fetch();
}

// Запись в таблицу БД
function insert($table, $params){
	global $pdo;
	$i = 0;
	$coll = '';
	$mask = '';
	foreach($params as $key => $value){
		if($i === 0){
			$coll .= "$key";
			$mask .= "'"."$value"."'";
		}else{
			$coll .= ", $key";
			$mask .= ", "."'"."$value"."'";
		}

		$i++;
	}
	$sql = "INSERT INTO $table ($coll) VALUES ($mask)";
	$query = $pdo->prepare($sql);
	$query->execute($params);
	dbCheckError($query);
	return $pdo->lastInsertId();
}

// Обновление строки в таблице
function update($table, $id, $params){
	global $pdo;
	$i = 0;
	$str = '';
	foreach($params as $key => $value){
		if($i === 0){
			$str .= "$key = '$value'";
		}else{
			$str .= ", $key = '$value'";
		}
		$i++;
	}
	$sql = "UPDATE $table SET $str WHERE id = $id";
	$query = $pdo->prepare($sql);
	$query->execute($params);
	dbCheckError($query);
}

// Удаление строки в таблице
function delete($table, $id){
	global $pdo;
	$sql = "DELETE FROM $table WHERE id = $id";
	$query = $pdo->prepare($sql);
	$query->execute();
	dbCheckError($query);
}

// Выборка записей (posts) с автором в админку

function selectAllFromPostsWithUsers($table1, $table2, $sort = "", $asc_desc = ""){
	global $pdo;
	$sql_sorts = "";
	if($sort != ""){
		$sql_sorts = " ORDER BY $sort $asc_desc";
	}
	$sql = "SELECT t1.id, t1.title, t1.img, t1.content, t1.status, t1.id_topic, t1.created_date, t2.username FROM $table1 AS t1 JOIN $table2 AS t2 ON t1.id_user = t2.id$sql_sorts";
	$query = $pdo->prepare($sql);
	$query->execute();
	dbCheckError($query);
	return $query->fetchAll();
}


/*function updateMY($table, $id, $params){
	global $conn;
	$i = 0;
	$str = '';
	foreach($params as $key => $value){
		if($i === 0){
			$str .= "$key = '$value'";
		}else{
			$str .= ", $key = '$value'";
		}
		$i++;
	}
	$sql = "UPDATE $table SET $str WHERE id = $id";
	echo $sql;
	mysqli_query($conn, $sql);
}*/
?>
