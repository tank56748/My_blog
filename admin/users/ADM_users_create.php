

<?php include ($_SERVER['DOCUMENT_ROOT'] . '/app/controls/users.php');?>
<main>
	<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/aside_admin.php'); ?>
	<div class="posts">
		<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/button_admin.php'); ?>
		<h2>Создание пользователя</h2>
		<div class="add-post">
			<form method="post" action="?page=ADM_users_create">
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
				</div>
				<div class="form-item">
					<label for="5">Возраст</label>
					<input id="5" name="age" value="<?=$age?>" maxlength="3" type="number" min="14" max="100" class="reg-input" placeholder="Укажите ваш возраст...">
				</div>
				<div class="form-item">
					<label for="6">Пол</label>
					<select id="6" class="reg-input gender" name="gender">
						<option value="0">Не определился</option>
						<option value="f">Женский</option>
						<option value="m">Мужской</option>
					</select>
				</div>
				<div class="form-item">
					<label for="7">Роль</label>
					<select id="7" class="reg-input category" name="admin">
						<option value="0">User</option>
						<option value="1">Admin</option>
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
				<div class="form-item">
					<button name="button-user-create" type="submit" class="submit-btn1 add">Создать пользователя</button>
				</div>
			</form>
		</div>
	</div>
</main>

<script>
	<? if(isset($_POST['gender'])): ?>
	let el_gender = document.querySelector(".gender option[value='<?=$_POST['gender']?>']");
	el_gender.setAttribute('selected', '');
	<? endif; ?>
	<? if(isset($_POST['admin'])): ?>
	let el_admin = document.querySelector(".category option[value='<?=$_POST['admin']?>']");
	el_admin.setAttribute('selected', '');
	<? endif; ?>
</script>
