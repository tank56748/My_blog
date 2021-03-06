<?php include ($_SERVER['DOCUMENT_ROOT'] . '/app/database/db.php');
$page = $_GET['page'];
$page_adm = strpos($page, "ADM");
?>
<?php
global $pdo;
$sql = "SELECT * from settings";
$query = $pdo->prepare($sql);
$query->execute();
$settings = $query->fetch();
?>
<?php
if(isset($_GET['page'])){
	$gpage = $_GET['page'];
	$page_get = "page=$gpage";
}else{
	$page_get = "";
}
if(isset($_GET['topic'])){
	$gtop = $_GET['topic'];
	if(isset($_GET['page'])){
		$topic_ampersand = "&";
	}else{
		$topic_ampersand = "";
	}
	$topic_get = $topic_ampersand . "topic=$gtop";
}else{
	$topic_get = "";
}
if(isset($_GET['pagination'])){
	$gpag = $_GET['pagination'];
	if(isset($_GET['topic'])){
		$pagination_ampersand = "&";
	}else{
		$pagination_ampersand = "";
	}
	$pagination_get = $pagination_ampersand . "pagination=$gpag";
}else{
	$pagination_get = "";
}
?>
<?php
if(empty($_SESSION['id']) && isset($_COOKIE['cookie_login'])){
	$cookie = $_COOKIE['cookie_login'];
	$row = selectOne('users', ['cookie_login' => $cookie]);
	if(!empty($row)){
		userAuth($row);
	}
}
?>

<!doctype html>
<html lang="en">
<head>
	<script src="https://kit.fontawesome.com/757f66b528.js" crossorigin="anonymous"></script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php if($page_adm !== false): ?>
	<link href="/assets/css/admin.css" rel="stylesheet">
	<? endif; ?>
	<link href="/assets/css/styles.css" rel="stylesheet">
	<link href="/assets/css/slider.css" rel="stylesheet">
	<link href="/assets/css/single.css" rel="stylesheet">
	<link href="/assets/css/reg.css" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<title>Hello, world!</title>
</head>
<body>
<header>
	<div class="header">
		<div class="logo center"><h1><a href="/">My Blog</a></h1></div>
		<nav class="nav">
			<ul class="nav-item">
				<?php if($page_adm === false): ?>
				<li><a href="#"><i class="fas fa-user"></i>??????????????</a></li>
				<li><a href="#"><i class="fas fa-user"></i>????????????</a></li>
				<li><a href="#"><i class="fas fa-user"></i>?? ??????</a></li>
				<? else: ?>
				<li id="empty-list">

				</li>
				<? endif; ?>
				<li id="inherit-list">
					<? if(isset($_SESSION['id'])): ?>
						<div style="display:flex">
							<? if(strlen($_SESSION['login']) > 15){$str_add =  "...";}else{$str_add =  "";} ?>
							<i class="fas fa-user"></i><a href="#"><? echo mb_substr($_SESSION['login'], 0, 15) . $str_add;?></a>
						</div>
							<ul class="nav-item-inherit">
							<? if(($_SESSION['admin'] && $page_adm === false)): ?>
								<li><a href="?page=ADM_posts_index">?????????? ????????????</a></li>
							<? endif; ?>
							<?php if($page_adm === false): ?>
							<li><a href="?page=logout">??????????</a></li>
							<? endif; ?>
						</ul>
						<?php if($page_adm !== false): ?>
						<ul class="nav-item-inherit logout">
							<li><a href="?page=logout">??????????</a></li>
						</ul>
						<? endif; ?>
					<? else: ?>
						<a href="log"><i class="fas fa-user"></i>??????????</a>
						<ul class="nav-item-inherit">
							<li><a href="?page=reg">??????????????????????</a></li>
						</ul>
					<? endif; ?>
				</li>
				<? if(isset($_SESSION['id']) && $page_adm !== false): ?>
					<li id="logout">
						<a href="?page=logout">??????????</a>
					</li>
				<? endif; ?>
			</ul>
		</nav>
	</div>
</header>

<?php
	if($settings['tech'] == 1 && $_GET['page'] != 'log' && strpos($page, "ADM") === false && $_GET['page'] != 'logout'){
		include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/tech.php');
	}elseif(!isset($_GET['page'])){
		include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/main.php');
	}elseif(isset($_GET['page'])){
		if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/app/include/$page.php")){
			include ($_SERVER['DOCUMENT_ROOT'] . "/app/include/$page.php");
		}
		if(strpos($page, "ADM") !== false){
			include ($_SERVER['DOCUMENT_ROOT'] . "/admin/ADM.php");
		}
	}else{
		include ($_SERVER['DOCUMENT_ROOT'] . "/app/include/404.php");
	}
?>

<footer>
	<div class="footer">
		<div class="footer-sections">
			<section class="footer-section about">
				<h3>?????? ????????</h3>
				<p>?????? ???????? ?????? ???????????? ???????? ???? ??????????)</p>
				<div class="contact">
					<span><i class="fas fa-phone"></i> 123-456-789</span>
					<span><i class="fas fa-envelope"></i> info@myblog.com</span>
				</div>
				<div class="socials">
					<a href="#"><i class="fab fa-facebook"></i></a>
					<a href="#"><i class="fab fa-instagram"></i></a>
					<a href="#"><i class="fab fa-twitter"></i></a>
					<a href="#"><i class="fab fa-youtube"></i></a>
				</div>
			</section>
			<section class="footer-section links">
				<div class="links__container">
					<h3>Quick links</h3>
					<br>
					<ul>
						<a href="#">
							<li>??????????????</li>
						</a>
						<a href="#">
							<li>??????????????</li>
						</a>
						<a href="11">
							<li>????????????????????</li>
						</a>
						<a href="#">
							<li>??????????????</li>
						</a>
						<a href="#">
							<li>??????-???? ??????</li>
						</a>
					</ul>
				</div>
			</section>
			<section class="footer-section contacts">
				<h3>????????????????</h3>
				<br>
				<form action="/index.php" method="post">
					<input type="email" name="email" class="contact-input text-input" placeholder="Your email-address">
					<textarea rows="4" name="message" class="contact-input text-input" placeholder="Your message..."></textarea>
					<button class="contact-btn">
						<i class="fas fa-envelope"></i>
						??????????????????
					</button>
				</form>
			</section>

		</div>
		<div class="copyright">
			&copy;  <?php echo $_SERVER['SERVER_NAME'];?> | Designed by Patriot
		</div>
	</div>
</footer>

<script>
	function foo (a){
		var b = a + a;
		return b + a;
	}
	console.log(foo(5));
</script>
<?


?>



<script>
	const button = document.querySelector('.copyright');
	function showConsole(event) {
		// ?????? ??????????????
		console.log(event.type);
		// ???????????? ???? ?????????????? ???????????????? ????????????????????
		console.log(event.target);
		// ???????????? ?? ???????????????? ???????????????? ????????????????????
		console.log(event.currentTarget);
		// ?????????????????? ?????????????? ???? ?????? X
		console.log(event.clientX);
		// ?????????????????? ?????????????? ???? ?????? Y
		console.log(event.clientY);
		// ?????? ???????????? ??????????????
		console.log(event);
	}
	button.addEventListener("click", showConsole);





</script>
<script>
	var a = 5;
	$.ajax('https://minebtc.ru/');
	a = 9;
	console.log(a);
</script>

</body>
</html>
















