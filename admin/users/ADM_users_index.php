

<?php include ($_SERVER['DOCUMENT_ROOT'] . '/app/controls/users.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/admin/users/sort_users.php'); ?>
<main>
	<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/aside_admin.php'); ?>
	<div class="posts">
		<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/button_admin.php'); ?>
		<h2>Управление пользователями</h2>
		<div style="font-weight: bolder;" class="posts-title">
			<div class="posts__id posts-item">ID</div>
			<div style="flex:2.5" class="posts__title posts-item"><a href="<?=$users_login_sort?>">Логин</a><i id="fa-name" class="fas fa-angle-<?=$fa_login?>"></i></div>
			<div class="posts__email posts-item"><a href="<?=$users_email_sort?>">Email</a><i id="fa-name" class="fas fa-angle-<?=$fa_email?>"></i></div>
			<div style="flex:1.5" class="posts__author posts-item"><a href="<?=$users_admin_sort?>">Роль</a><i id="fa-name" class="fas fa-angle-<?=$fa_admin?>"></i></div>
			<div class="posts__edit posts-item">Страна</div>
			<div class="posts__time posts-item"><a href="<?=$users_date_sort?>">Дата</a><i id="fa-name" class="fas fa-angle-<?=$fa_date?>"></i></div>
			<div class="posts__edit posts-item">Изменить</div>
			<div class="posts__delete posts-item">Удалить</div>
		</div>
		<?
		if(!isset($_GET['sort'])) {
			$users_arr = selectAll('users');
		}
			$i = 0;
		?>
		<? foreach($users_arr as $number => $user_info): ?>
		<? $i++; ?>
		<div class="posts-one" id="user<?=$user_info['id']?>">
			<div class="posts__id posts-item"><?=$number + 1?></div>
			<div style="flex:2.5" class="posts__title posts-item"><?=$user_info['username']?></div>
			<div class="posts__email posts-item"><?=$user_info['email'];?></div>
			<div style="flex:1.5" id="admin<?=$i?>" class="posts__author posts-item adm"><a admin-id="<?=$user_info['id']?>"><?=$admin_index[$user_info['admin']]?></a></div>
			<div class="posts__edit posts-item"><?=$country_index[$user_info['country']]?></div>
			<div class="posts__time posts-item"><?=$user_info['created']?></div>
			<div class="posts__edit posts-item edit"><a style="font-size: 22px;margin: 5px;text-decoration: none;transition: ease-out 0.2s;" class="fa fa-pencil-square-o" href="?page=ADM_users_edit&id_user=<?=$user_info['id']?>"></a></div>
			<div id="del<?=$i?>" class="posts__delete posts-item delete"><a value-id="<?=$user_info['id']?>" style="font-size:22px;margin:5px;text-decoration: none;transition: ease-out 0.2s;" class="fa fa-trash-o"></a></div>
		</div>
		<? endforeach; ?>
	</div>
	<script>
		let posts = $('.posts');
		posts.on('click', function(event){
			let target = event.target;
			if (target.hasAttribute('admin-id')) {
				var id = target.getAttribute('admin-id');
				var user = target.parentNode.parentNode.querySelector('.posts__title').textContent;
				var admin = target.parentNode.parentNode.querySelector('.posts__author a');
				var text_admin = admin.textContent;
				var confirm_text;
				var change;
				var name;
				if (text_admin == 'Пользователь'){
					confirm_text = 'Вы действительно хотите сделать админом';
					change = 1;
					name = 'Админ';
				}else if(text_admin == 'Админ'){
					confirm_text = 'Вы действительно хотите сделать пользователем';
					change = 0;
					name = 'Пользователь';
				}
				if (confirm(`${confirm_text} ${user}?`)) {
					$.ajax({
						url: 'app/ajax/users_ajax.php',
						type: 'POST',
						data: {action: 'admin', id: id, do: change},
						success: function (data){
							if (data.includes('ok')){
								admin.textContent = name;
							}
						}
					});
				}
			}
		});
		posts.on('click', function(event){
			let target = event.target;
			if (target.hasAttribute('value-id')) {
				var id = target.getAttribute('value-id');
				var title = target.parentNode.parentNode.querySelector('.posts__title').textContent;
				if (confirm(`Вы действительно хотите удалить пользователя ${title}?`)) {
					$.ajax({
						url: 'app/ajax/users_ajax.php',
						type: 'POST',
						data: {action: 'delete', id: id},
						success: function (data){
							if (data.includes('ok')){
								let el = $(`#user${id}`);
								el.fadeOut(500, function (){
									el.remove();
								});
							}
						}
					});
				}
			}
		});
	</script>
</main>
