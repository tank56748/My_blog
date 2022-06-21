<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/controls/settings.php'); ?>

<main>
	<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/aside_admin.php'); ?>
	<div class="posts">
		<h2>Управление записями</h2>
		<div>
			<form action="?page=ADM_settings_index" method="post">
				<div class="form-item">

					Техработы <input name="tech" value="1" type="checkbox" <? if($settings['tech'] == 1){echo 'checked';} ?>>
				</div>
				<div class="form-item">
					<button class="submit-btn1" name="button-settings" type="submit">Отправить</button>
				</div>
			</form>
		</div>
	</div>
</main>
