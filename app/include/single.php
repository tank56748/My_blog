
<main>
	<div class="container-main">
		<div class="content single">
			<div style="width: 100%;" class="main-content">
				<?
				global $pdo;
				$id = $_GET['id_post'];
				$sql = "SELECT t3.username, t2.name, t1.* FROM posts AS t1 JOIN topics AS t2 ON t1.id_topic = t2.id JOIN users AS t3 ON t1.id_user = t3.id WHERE t1.id = $id AND t1.status = 1";
				$query = $pdo->prepare($sql);
				$query->execute();
				dbCheckError($query);
				$post = $query->fetch();
				?>
				<h2><div><?=$post['title']?></div></h2>
				<div class="single-post">
					<div style="min-height: 370px;" class="single-post-img">
						<? if(empty($post['img']) || $post['img'] == 'nofoto.png'): ?>
							<img src="/assets/images/nofoto.png">
						<? else: ?>
							<img src="/assets/images/posts/<?=$post['img']?>">
						<? endif; ?>
					</div>
					<div style="display:flex; font-size: 17px; margin-bottom: 11px;">
						<i style="margin-left: 22px;" class="far fa-user"> <?=$post['username']?></i>
						<i style="margin-left: 4%;" class="far fa-calendar"> <?=date('j F o в H:i',strtotime($post['created_date']))?></i>
						<span style="margin-left: 4%;">Категория: <a href="?topic=<?=$post['name']?>"><?=$post['name']?></a></span>
					</div>
					<div style="" class="single-post-text">
						<?=$post['content']?>
					</div>
				</div>
				<!--Комментарии-->
				<?php
				include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/comments.php');
				?>
				<!--Комментарии-->
			</div>
			<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/sidebar.php');?>
		</div>
	</div>
</main>



