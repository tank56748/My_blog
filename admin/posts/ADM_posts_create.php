
<?php include ($_SERVER['DOCUMENT_ROOT'] . '/app/controls/posts.php'); ?>
	<main>
		<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/aside_admin.php'); ?>
		<div class="posts">
			<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/button_admin.php'); ?>
			<h2>Добавление записи</h2>
			<div class="add-post">
				<form id="form1" runat="server" method="post" action="?page=ADM_posts_create" enctype="multipart/form-data">
					<div class="form-item err">
						<? include $_SERVER['DOCUMENT_ROOT'] . "/app/include/error_info.php"?>
					</div>
					<div class="form-item">
						<label for="h-post">Заголовок</label>
						<input value="<?=$title?>" name="title" id="h-post" type="text" minlength="7" maxlength="253" class="reg-input" placeholder="Заголовок...">
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
						<input style="margin-right:3px" value="1" name="public" id="public" type="checkbox" checked>
						<label style="font-size:15px; display: inline-block;" for="public">Публиковать</label>
					</div>
					<div class="form_img" style="display:flex">
						<div class="form-item file-upload">
							<input name="img" id="imgInp"  type="file" class="reg-input" placeholder="Заголовок...">
							<label for="imgInp">Загрузить</label>
						</div>
						<div>
							<div class="pred" style="font-size: 16px;position: relative;top: -37px;left: -53px;">Предпросмотр</div>
							<img style="height: 120px; position: relative;top: -31px;left: -73px; display:none" id="blah" src="#" alt="your image"/>
						</div>

					</div>
					<div class="form-item">
						<button name="button-post-create" type="submit" class="submit-btn1 add">Добавить запись</button>
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
	});
	<? if(isset($_POST['category'])): ?>
	let el_from = document.querySelector(".category option[value='<?=$_POST['category']?>']");
	el_from.setAttribute('selected', '');
	<? endif; ?>

</script>
<script src="assets/js/scripts.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
