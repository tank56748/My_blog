<?php include ($_SERVER['DOCUMENT_ROOT'] . '/app/controls/users.php');?>
<div class="reg-page">
	<div class="reg-h"><h2>Регистрация</h2></div>
	<div class="form">
		<form method="post" action="?page=reg">
			<div class="form-item err">
				<? include $_SERVER['DOCUMENT_ROOT'] . "/app/include/error_info.php"?>
			</div>
			<div class="form-item">
				<label for="1">Логин</label>
				<input id="1" name="login" value="<?=$login?>" maxlength="50" type="text" class="reg-input" placeholder="Введите ваш логин...">
			</div>
			<div class="form-item">
				<label for="2">Email адрес</label>
				<input id="2" name="email" value="<?=$email?>" type="email" class="reg-input" placeholder="Введите ваш email..." required>
				<div class="email-text">Ваш адрес не будет использован для спама</div>
			</div>
			<div class="form-item">
				<label for="5">Возраст</label>
				<input id="5" name="age" value="<?=$age?>" maxlength="3" type="number" min="14" max="100" class="reg-input" placeholder="Укажите ваш возраст...">
			</div>
			<div class="form-item">
				<label for="6">Пол</label>
				<select id="6" class="reg-input gender" name="gender">
					<option value="0" selected>Не определился</option>
					<option value="f">Женский</option>
					<option value="m">Мужской</option>
				</select>
			</div>
			<div class="form-item">
				<label for="3">Пароль</label>
				<input id="3" name="password" minlength="5" maxlength="50" type="password" class="reg-input" placeholder="Введите ваш пароль...">
			</div>
			<div class="form-item">
				<label for="4">Повторите пароль</label>
				<input id="4" name="password_2" minlength="5" maxlength="50" type="password" class="reg-input" placeholder="Повторите ваш пароль...">
			</div>
			<button name="button-reg" type="submit" class="submit-btn1">Зарегистрироваться</button>
			<div id="or">Или</div>
		</form>
			<a href="?page=log"><button class="submit-btn2">Авторизоваться</button></a>
	</div>
</div>
