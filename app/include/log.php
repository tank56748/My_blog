<?php include ($_SERVER['DOCUMENT_ROOT'] . '/app/controls/users.php');?>
<div class="reg-page">
	<div class="reg-h"><h2>Авторизация</h2></div>
	<div class="form">
		<form method="post" action="?page=log">
			<div class="form-item err">
				<? include $_SERVER['DOCUMENT_ROOT'] . "/app/include/error_info.php"?>
			</div>
			<div class="form-item">
				<label>Введите email</label>
				<input id="2" name="email" value="<?=$email?>" type="email" class="reg-input" placeholder="Введите ваш email..." required>
			</div>

			<div class="form-item">
				<label>Введите пароль</label>
				<input name="password" type="password" class="reg-input" placeholder="Введите ваш пароль...">
			</div>
			<div class="form-item">
				<input type="checkbox" name="cookie_login" value="1"><span> Запомнить меня</span>
			</div>
			<button name="button-log" class="submit-btn1">Войти</button>
			<div id="or">Или</div>
		</form>
			<a href="?page=reg"><button class="submit-btn2">Зарегистрироваться</button></a>
	</div>
</div>

<?php
if($_SESSION['FAIL_NUM'] > 3){
	header('location: ' . $http . $_SERVER['SERVER_NAME'] . '?page=timer');
}
?>


