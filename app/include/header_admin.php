<?php include ($_SERVER['DOCUMENT_ROOT'] . '/app/controls/users.php');
?>


<!doctype html>
<html lang="en">
<head>
	<script src="https://kit.fontawesome.com/757f66b528.js" crossorigin="anonymous"></script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="/assets/css/admin.css" rel="stylesheet">
	<link href="/assets/css/styles.css" rel="stylesheet">
	<link href="/assets/css/single.css" rel="stylesheet">
	<link href="/assets/css/reg.css" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<title>Hello, world!</title>
</head>
<body>
<header>
	<div class="header">
		<div class="logo center"><h1><a href="/">My Blog</a></h1></div>
		<nav class="nav">
			<ul class="nav-item">
				<li id="empty-list">

				</li>
				<li id="inherit-list">
					<? if(isset($_SESSION['id'])): ?>
						<a href="#"><i class="fas fa-user"></i><? echo $_SESSION['login'] ?></a>
						<ul class="nav-item-inherit logout">
							<li><a href="/app/include/logout.php">Выход</a></li>
						</ul>
					<? else: ?>
						<a href="/app/include/log.php"><i class="fas fa-user"></i>Войти</a>
					<? endif; ?>
				</li>
				<? if(isset($_SESSION['id'])): ?>
				<li id="logout">
					<a href="/app/include/logout.php">Выход</a>
				</li>
				<? endif; ?>
			</ul>
		</nav>
	</div>
</header>
