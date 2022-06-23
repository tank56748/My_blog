<?php


$driver = 'mysql';
$host = 'localhost';
$db_name = 'qwert136_myblog';
if($_SERVER['SERVER_NAME'] == 'localhost'){
	$db_user = 'root';
	$db_pass = 'mysql';
}else{
	$db_user = 'qwert136_qwert136';
	$db_pass = 'kOuW09bhfx';
}
$charset = 'utf8';
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,	// Режим сообщения об ошибках PDO. Выбрасывает PDOException.
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	];

try {
	$pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=$charset", $db_user, $db_pass, $options);
}catch(PDOException $i){
	die("Ошибка подключения к базе данных");
}

?>