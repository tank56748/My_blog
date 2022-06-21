
<?php include ($_SERVER['DOCUMENT_ROOT'] . '/app/controls/posts.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/admin/posts/sort_posts.php'); ?>
<main>
	<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/aside_admin.php'); ?>
	<div class="posts">
		<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/button_admin.php'); ?>
		<h2>Управление записями</h2>
		<div style="font-weight: bolder;" class="posts-title">
			<div class="posts__id posts-item">ID</div>
			<div class="posts__title posts-item"><a href="<?=$posts_name_sort?>">Название</a><i id="fa-name" class="fas fa-angle-<?=$fa_name?>"></i></div>
			<div class="posts__author posts-item"><a href="<?=$posts_author_sort?>">Автор</a><i id="fa-name" class="fas fa-angle-<?=$fa_author?>"></i></div>
			<div class="posts__time posts-item"><a href="<?=$posts_date_sort?>">Дата</a><i id="fa-name" class="fas fa-angle-<?=$fa_date?>"></i></div>
			<div class="posts__status posts-item"><a href="<?=$posts_status_sort?>">Статус</a><i id="fa-name" class="fas fa-angle-<?=$fa_status?>"></i></div>
			<div class="posts__edit posts-item">Изменить</div>
			<div class="posts__delete posts-item">Удалить</div>
		</div>
		<?
		if(!isset($_GET['sort'])){
			$postsADM = selectAllFromPostsWithUsers('posts', 'users');
		}
		?>
		<? $i = 0 ?>
		<? foreach($postsADM as $key => $one): ?>
			<div class="posts-one" id="post<?=$one['id'];?>">
				<div class="posts__id posts-item"><?=$key + 1?></div>
				<div class="posts__title posts-item"><?=$one['title'];?></div>
				<div class="posts__author posts-item"><?=$one['username'];?></div>
				<div class="posts__time posts-item"><?=$one['created_date'];?></div>
				<div class="posts__status posts-item status<?=$i?> stat"><a status-id="<?=$one['id'];?>"><?=$status_index[$one['status']]?></a></div>
				<div class="posts__edit posts-item edit"><a style="font-size: 22px;margin: 5px;text-decoration: none;transition: ease-out 0.2s;" class="fa fa-pencil-square-o" href="?page=ADM_posts_edit&id=<?=$one['id'];?>"></a></div>
				<div class="posts__delete<?=$i?> posts-item delete"><a value-id="<?=$one['id'];?>" class="fa fa-trash-o" style="font-size:22px;margin:5px;text-decoration: none;transition: ease-out 0.2s;"></a></div>
			</div>
			<? $i++ ?>
		<? endforeach; ?>
		<script>
			let posts = $('.posts');
			posts.on('click', function(event){
				let target = event.target;
				if (target.hasAttribute('status-id')) {
					var id = target.getAttribute('status-id');
					var post = target.parentNode.parentNode.querySelector('.posts__title').textContent;
					var status = target.parentNode.parentNode.querySelector('.posts__status a');
					var text_status = status.textContent;
					var confirm_text;
					var change;
					var name;
					if (text_status == 'В черновике'){
						confirm_text = 'Вы действительно хотите опубликовать пост';
						change = 1;
						name = 'Опубликован';
					}else if(text_status == 'Опубликован'){
						confirm_text = 'Вы действительно хотите снять с публикации пост';
						change = 0;
						name = 'В черновике';
					}
					if (confirm(`${confirm_text} ${post}?`)) {
						$.ajax({
							url: 'app/ajax/posts_ajax.php',
							type: 'POST',
							data: {action: 'status', id: id, do: change},
							success: function (data){
								if (data.includes('ok')){
									status.textContent = name;
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
					if (confirm(`Вы действительно хотите удалить пост ${title}?`)) {
						$.ajax({
							url: 'app/ajax/posts_ajax.php',
							type: 'POST',
							data: {action: 'delete', id: id},
							success: function (data){
								if (data.includes('ok')){
									let el = $(`#post${id}`);
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
	</div>
</main>



