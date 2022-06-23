<?php
// Сортировка по логину

if(!isset($users_login_sort)){
	$users_login_sort = "?page=ADM_users_index&sort=users_login_asc";
}

if($_GET['sort'] == "users_login_asc"){
	global $pdo;
	$sql = "SELECT * from users ORDER BY username ASC";
	$query = $pdo->prepare($sql);
	$query->execute();
	$users_arr = $query->fetchAll();
	$users_login_sort = "?page=ADM_users_index&sort=users_login_desc";
	$fa_login = "up";
}
if($_GET['sort'] == "users_login_desc"){
	global $pdo;
	$sql = "SELECT * from users ORDER BY username DESC";
	$query = $pdo->prepare($sql);
	$query->execute();
	$users_arr = $query->fetchAll();
	$users_login_sort =  "?page=ADM_users_index&sort=users_login_asc";
	$fa_login = "down";
}

// Сортировка по email

if(!isset($users_email_sort)){
	$users_email_sort = "?page=ADM_users_index&sort=users_email_asc";
}

if($_GET['sort'] == "users_email_asc"){
	global $pdo;
	$sql = "SELECT * from users ORDER BY email ASC";
	$query = $pdo->prepare($sql);
	$query->execute();
	$users_arr = $query->fetchAll();
	$users_email_sort = "?page=ADM_users_index&sort=users_email_desc";
	$fa_email = "up";
}
if($_GET['sort'] == "users_email_desc"){
	global $pdo;
	$sql = "SELECT * from users ORDER BY email DESC";
	$query = $pdo->prepare($sql);
	$query->execute();
	$users_arr = $query->fetchAll();
	$users_email_sort =  "?page=ADM_users_index&sort=users_email_asc";
	$fa_email = "down";
}



// Сортировка по Роли

if(!isset($users_admin_sort)){
	$users_admin_sort = "?page=ADM_users_index&sort=users_admin_asc";
}

if($_GET['sort'] == "users_admin_asc"){
	global $pdo;
	$sql = "SELECT * from users ORDER BY admin ASC";
	$query = $pdo->prepare($sql);
	$query->execute();
	$users_arr = $query->fetchAll();
	$users_admin_sort = "?page=ADM_users_index&sort=users_admin_desc";
	$fa_admin = "up";
}
if($_GET['sort'] == "users_admin_desc"){
	global $pdo;
	$sql = "SELECT * from users ORDER BY admin DESC";
	$query = $pdo->prepare($sql);
	$query->execute();
	$users_arr = $query->fetchAll();
	$users_admin_sort =  "?page=ADM_users_index&sort=users_admin_asc";
	$fa_admin = "down";
}


// Сортировка по дате

if(!isset($users_date_sort)){
	$users_date_sort = "?page=ADM_users_index&sort=users_date_asc";
}

if($_GET['sort'] == "users_date_asc"){
	global $pdo;
	$sql = "SELECT * from users ORDER BY created ASC";
	$query = $pdo->prepare($sql);
	$query->execute();
	$users_arr = $query->fetchAll();
	$users_date_sort = "?page=ADM_users_index&sort=users_date_desc";
	$fa_date = "up";
}
if($_GET['sort'] == "users_date_desc"){
	global $pdo;
	$sql = "SELECT * from users ORDER BY created DESC";
	$query = $pdo->prepare($sql);
	$query->execute();
	$users_arr = $query->fetchAll();
	$users_date_sort =  "?page=ADM_users_index&sort=users_date_asc";
	$fa_date = "down";
}

?>
