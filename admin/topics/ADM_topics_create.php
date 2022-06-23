


<?php include ($_SERVER['DOCUMENT_ROOT'] . '/app/controls/topics.php'); ?>
<main>
	<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/aside_admin.php'); ?>
	<div class="posts">
		<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/button_admin.php'); ?>
		<h2>Создать категорию</h2>
		<div class="add-post">
			<form method="post" action="?page=ADM_topics_create">
				<div class="form-item err">
					<? include $_SERVER['DOCUMENT_ROOT'] . "/app/include/error_info.php"?>
				</div>
				<div class="form-item">
					<label for="h-post">Имя категории</label>
					<input value="<?=$name;?>" name="name" id="h-post" type="text" maxlength="253" class="reg-input" placeholder="Имя категории...">
				</div>
				<div class="form-item">
					<label for="textarea">Описание категории</label>
					<textarea name="description" id="textarea" class="reg-input" placeholder="Описание..."><?=$description;?></textarea>
				</div>
				<div class="form-item">
					<button name="button-topic-create" type="submit" class="submit-btn1 add">Создать категорию</button>
				</div>
			</form>
		</div>
	</div>
</main>
