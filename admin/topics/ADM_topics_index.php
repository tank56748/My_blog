



<?php include ($_SERVER['DOCUMENT_ROOT'] . '/app/controls/topics.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/admin/topics/sort_topics.php'); ?>

<main>
	<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/aside_admin.php');?>
	<div class="posts">
		<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/button_admin.php'); ?>
		<h2>Управление категориями</h2>
		<div class="form-item err">
			<? include $_SERVER['DOCUMENT_ROOT'] . "/app/include/error_info.php"?>
		</div>
		<div style="font-weight: bolder;" class="posts-title">
			<div class="posts__id posts-item">ID</div>
			<div class="posts__title posts-item"><a href="<?=$topic_name_sort?>">Название</a><i id="fa-name" class="fas fa-angle-<?=$fa_name?>"></i></div>
			<div class="posts__edit posts-item">Изменить</div>
			<div class="posts__delete posts-item">Удалить</div>
		</div>
		<?
		if(!isset($_GET['sort'])){
			$topicss = selectAll('topics');
			$i=0;
		}
		?>
		<? foreach($topicss as $key => $topic): ?>
		<? $i++; ?>
		<div class="posts-one" id="topic<?=$topic['id'];?>">
			<div class="posts__id posts-item"><?=$key + 1;?></div>
			<div class="posts__title posts-item"><?=$topic['name'];?></div>
			<div class="posts__edit posts-item edit"><a style="font-size: 22px;margin: 5px;text-decoration: none;transition: ease-out 0.2s;" class="fa fa-pencil-square-o" href="?page=ADM_topics_edit&id=<?=$topic['id']?>"></a></div>
			<div id="del_topic<?=$i?>" class="posts__delete posts-item delete"><a value-id="<?=$topic['id']?>" style="font-size:22px;margin:5px;text-decoration: none;transition: ease-out 0.2s;" class="fa fa-trash-o"></a></div>
		</div>
		<? endforeach; ?>
	</div>
	<script>
		$('.posts').on('click', function(event){
			let target = event.target;
			if (target.hasAttribute('value-id')) {
				var id = target.getAttribute('value-id');
				var title = target.parentNode.parentNode.querySelector('.posts__title').textContent;
				if (confirm(`Вы действительно хотите удалить категорию ${title}?`)) {
					$.ajax({
						url: 'app/ajax/topics_ajax.php',
						type: 'POST',
						data: {action: 'delete', id: id},
						success: function (data){
							if (data.includes('ok')){
								let el = $(`#topic${id}`);
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
