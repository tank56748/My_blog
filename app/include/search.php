
<main>
	<div class="container-main">
		<div class="content">
			<div class="main-content">
				<h2 style="margin-bottom: 40px; margin-left:60px; margin-right:60px; border-radius:15px; border:3px solid #008484; background-color: #008484; padding:20px; color: wheat;"><div>Результаты поиска</div></h2>
				<?
				global $pdo;
				if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['button-search'])){
					$query_search = trim(strip_tags(stripcslashes(htmlspecialchars($_POST['search-term']))));
					$sql_search = " AND t1.title LIKE '%$query_search%' OR t1.content LIKE '%$query_search%'";
				}else{
					$sql_search = "";
				}
				$sql = "SELECT t3.username, t2.name, t1.id, t1.status, t1.title, t1.img, t1.content, t1.created_date FROM posts AS t1 JOIN topics AS t2 ON t1.id_topic = t2.id JOIN users AS t3 ON t1.id_user = t3.id WHERE t1.status = 1$sql_search ORDER BY t1.id DESC";
				$query = $pdo->prepare($sql);
				$query->execute();
				dbCheckError($query);
				$All_posts_search = $query->fetchAll();
				?>
				<? if(empty($All_posts_search)): ?>
					<div style="font-size:30px;display:flex; justify-content:center"><div style="margin-top:50px;">Ничего не найдено!</div></div>
				<? endif; ?>
				<? foreach($All_posts_search as $post): ?>
					<div style="display:block; width: 100%;word-break: break-word;max-height: 600px;overflow: hidden;" class="post">
						<div>
							<div class="post-img">
								<? if(empty($post['img']) || $post['img'] == 'nofoto.png'): ?>
									<img src="/assets/images/nofoto.png">
								<? else: ?>
									<img alt="<?=substr($post['title'], 0, 50)?>" src="/assets/images/posts/<?=$post['img']?>">
								<? endif; ?>
							</div>
						</div>
						<div>
							<div class="post-text">
								<h2 class="content-color">
									<a href="?page=single&id_post=<?=$post['id']?>"><?php
										$str_length_title = 100;
										mb_strlen($post['title']) > $str_length_title ? $after = "..." : $after = "";
										echo mb_substr($post['title'], 0,$str_length_title) . $after;
										?>
									</a>
								</h2>
								<i style="margin-left: 13px;" class="far fa-user"> <?=$post['username']?></i>
								<i class="far fa-calendar"> <?=date('j F o в H:i',strtotime($post['created_date']))?></i>
								<p class="prewiev-text">
									<style>
										img {max-width:100%}
									</style>
									<?php
									$str_length_cont = 500;
									mb_strlen($post['content']) > $str_length_cont ? $after = "..." : $after = "";
									echo mb_substr($post['content'], 0,$str_length_cont) . $after;
									?>
								</p>
							</div>
						</div>
					</div>
				<? endforeach; ?>
			</div>
			<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/sidebar.php');?>
		</div>
	</div>
</main>

