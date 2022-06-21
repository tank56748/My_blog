


	<?php include ($_SERVER['DOCUMENT_ROOT'] . '/app/controls/posts.php'); ?>
	<main>
		<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/aside_admin.php'); ?>
		<div class="posts">
			<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/button_admin.php'); ?>
			<h2>Редактирование записи</h2>
			<div class="add-post">
				<form method="post" action="?page=ADM_posts_edit&id=<?=$_GET['id']?>" enctype="multipart/form-data">
					<div class="form-item err">
						<? include $_SERVER['DOCUMENT_ROOT'] . "/app/include/error_info.php"?>
					</div>
					<input value="<?=$id?>" name="id" type="hidden">
					<div class="form-item">
						<label for="h-post">Заголовок</label>
						<input name="title" id="h-post" type="text" class="reg-input" minlength="7" value="<?=$title?>" placeholder="Заголовок...">
					</div>
					<div class="form-item">
						<label for="editor">Содержимое записи</label>
						<textarea name="content" id="editor" class="reg-input" minlength="7" placeholder="Текст..."><?=$content?></textarea>
					</div>
					<div class="form-item">
						<label for="cat">Категория</label>
						<select name="category" id="cat" class="reg-input category">
							<? foreach($topics as $key => $topic):?>
								<option value="<?=$topic['id']?>"><?=$topic['name']?></option>
							<? endforeach;?>
						</select>
					</div>
					<div class="form-item" style="display: inline-block;">
						<?if($status){$check = "checked";}?>
						<input style="margin-right:3px" value="1" name="public" id="public" type="checkbox" <?=$check?>>
						<label style="font-size:15px; display: inline-block;" for="public">Публиковать</label>
					</div>
					<div class="form_img" style="display:flex">
						<div class="form-item file-upload">
							<input name="img" id="imgInp" value="<? if(empty($_SESSION['image_path'])) {} else { echo $_SESSION['image_path']; } ?> " type="file" class="reg-input" placeholder="Заголовок...">
							<label for="imgInp">Загрузить</label>
						</div>
						<div>
							<div id="edit_pred" style="font-size: 16px;position: relative;top: -37px;left: -6px;">Предпросмотр</div>
							<? if(empty($img) || $img == 'nofoto.png'): ?>
								<img id="edit_img" style="height: 120px; position: relative;top: -31px;left: -25px;" src="/assets/images/nofoto.png">
							<? else: ?>
								<img id="edit_img" style="height: 120px; position: relative;top: -31px;left: -25px;" src="<?="/assets/images/posts/" . $img;?>">
							<? endif; ?>
							<div class="pred" style="font-size: 16px;position: relative;top: -37px;left: -53px;">Предпросмотр</div>
							<img style="height: 120px; position: relative;top: -31px;left: -73px; display:none" id="blah" src="#" alt="your image"/>
						</div>

					</div>
					<div class="form-item">
						<button name="button-post-update" type="submit" class="submit-btn1 add">Сохранить запись</button>
					</div>
				</form>
			</div>
		</div>
	</main>

<script>
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				$('#blah').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imgInp").change(function() {
		readURL(this);
		$(".pred").show();
		$("#blah").show();
		$("#edit_pred").hide();
		$("#edit_img").hide();
	});


	let el_topic = document.querySelector(".category option[value='<?=$topic_id?>']");
	el_topic.setAttribute('selected', '');
</script>
	<script src="assets/js/scripts.js"></script>
	<script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>


