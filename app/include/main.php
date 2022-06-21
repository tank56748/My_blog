


<?php
global $pdo;
$sql = "SELECT t2.name, t1.id, t1.status, t1.title, t1.img, t1.content, t1.created_date FROM posts AS t1 JOIN topics AS t2 ON t1.id_topic = t2.id WHERE t1.status = 1 AND t2.name = 'Top' ORDER BY t1.id DESC";
$query = $pdo->prepare($sql);
$query->execute();
$Top_posts = $query->fetchAll();
?>

<style>
	#slides .image{ /*устанавливает общий размер блока с изображениями*/
		width: <?=count($Top_posts)?>00%;
		line-height: 0;
	}

	#slides article{ /*все изображения справа друг от доруга*/
		width: <?=100/count($Top_posts)?>%;
		float: left;
	}

	/*настройка переключения и положения для левой стрелки*/
	/*если свич1-count($Top_posts) активны, то идет обращение к лейблу из блока с id контролс*/
	<? for($i = 1; $i <= count($Top_posts); $i++): ?>
	#switch<?=$i?>:checked ~ #controls label:nth-child(<? if($i == 1){echo count($Top_posts);}else{echo $i-1;}?>)<?
			if($i == (count($Top_posts))){
				echo "";
			}else{
				echo ",";
			}
			?>
	<?endfor;?>{
		background: url('/assets/images/prev.png') no-repeat; /*заливка фона картинкой без повторений*/
		float: left;
		margin: -10px 0 0 -84px; /*сдвиг влево*/
		display: block;
		height: 68px;
		width: 68px;
	}

	/*настройка переключения и положения для правой стрелки*/
	<? for($i = 1; $i <= count($Top_posts); $i++): ?>
	#switch<?=$i?>:checked ~ #controls label:nth-child(<?
			 if($i == count($Top_posts)){
				 echo 1;
			 }else{
				 echo $i+1;
			 }
			 ?>)<?
			if($i == (count($Top_posts))){
				echo "";
			}else{
				echo ",";
			}
			?>
	<?endfor;?>{
		background: url('/assets/images/next.png') no-repeat; /*заливка фона картинкой без повторений*/
		float: right;
		margin: -10px -84px 0 0; /*сдвиг вправо*/
		display: block;
		height: 68px;
		width: 68px;
	}

	/*позиция изображения при активации переключателя*/
	<? for($i = 1; $i <= count($Top_posts); $i++): ?>
	#switch<?=$i?>:checked ~ #slides .image{
		margin-left: -<?=$i-1?>00%;
	}
	<? endfor; ?>

	<? for($i = 1; $i <= count($Top_posts); $i++): ?>
	/*цвет активного лейбла при активации чекбокса*/
	#switch<?=$i?>:checked ~ #active label:nth-child(<?=$i?>)<?
			if($i == (count($Top_posts))){
				echo "";
			}else{
				echo ",";
			}
			?>
	<? endfor; ?>{
		background: #18a3dd;
		border-color: #18a3dd !important;
	}
	@media screen and (max-width:766px){

	<? for($i = 1; $i <= count($Top_posts); $i++): ?>
		#switch<?=$i?>:checked ~ #controls label:nth-child(<? if($i == 1){echo count($Top_posts);}else{echo $i-1;}?>)<?
			if($i == (count($Top_posts))){
				echo "";
			}else{
				echo ",";
			}
			?>
		<?endfor;?>{
			display:none;
			margin: -10px 0 0 0;
		}

	<? for($i = 1; $i <= count($Top_posts); $i++): ?>
		#switch<?=$i?>:checked ~ #controls label:nth-child(<?
			 if($i == count($Top_posts)){
				 echo 1;
			 }else{
				 echo $i+1;
			 }
			 ?>)<?
			if($i == (count($Top_posts))){
				echo "";
			}else{
				echo ",";
			}
			?>
		<?endfor;?>{
			display:none;
			margin: -10px 0 0 0;
		}
	}

</style>
<main>
	<div id="slider-text">Топ публикаций</div>
	<!--Слайдер-->
	<div class="all">
		<input checked type="radio" name="respond" id="desktop">
		<article id="slider">
			<? for($i = 1; $i <= count($Top_posts); $i++): ?>
			<input <?php if($i == 1) echo 'checked'?> type="radio" name="slider" id="switch<?=$i?>">
			<? endfor; ?>
			<div id="slides">
				<div id="overflow">
					<div class="image">
						<? foreach($Top_posts as $post_top): ?>
						<article>
							<a href="?page=single&id_post=<?=$post_top['id']?>">
								<? if($post_top['img'] == 'nofoto.png'): ?>
									<img src="/assets/images/<?=$post_top['img']?>">
								<? else: ?>
									<img src="/assets/images/posts/<?=$post_top['img']?>">
								<? endif; ?>
								<div class="image-text"><?php
									$str_length_title = 50;
									mb_strlen($post_top['title']) > $str_length_title ? $after = "..." : $after = "";
									echo mb_substr($post_top['title'], 0,$str_length_title) . $after;
									?></div>
							</a>
						</article>
						<? endforeach; ?>
					</div>
				</div>
			</div>
			<div id="controls">
				<? for($i = 1; $i <= count($Top_posts); $i++): ?>
				<label for="switch<?=$i?>"></label>
				<? endfor; ?>
			</div>
			<div id="active">
				<? for($i = 1; $i <= count($Top_posts); $i++): ?>
				<label for="switch<?=$i?>"></label>
				<? endfor; ?>
			</div>
		</article>
	</div>
	<!--Слайдер-->

	<div class="container-main">
		<div class="content">
			<div class="main-content">
				<? if(isset($_GET['topic'])): ?>
					<h2 style="margin-bottom: 40px; margin-left:60px; margin-right:60px; border-radius:15px; border:3px solid #008484; background-color: #008484; padding:20px; color: wheat;"><div>Категория: <?=$_GET['topic']?></div></h2>
				<? else: ?>
					<h2 style="margin-bottom: 40px; margin-left:60px; margin-right:60px; border-radius:15px; border:3px solid #008484; background-color: #008484; padding:20px; color: wheat;"><div>Последние публикации</div></h2>
				<? endif; ?>

				<?
				$pagination = $_GET['pagination'] ?? 1;
				$limit = 2;
				$offset = ($pagination - 1) * $limit;
				$sql_pagination = "LIMIT $limit OFFSET $offset";
				?>
				<?
				global $pdo;
				if(isset($_GET['topic'])){
					$topic = $_GET['topic'];
					$sql_topic = " AND t2.name = '$topic'";
				}else{
					$sql_topic = "";
				}
				$sql = "SELECT t3.username, t2.name, t1.id, t1.status, t1.title, t1.img, t1.content, t1.created_date FROM posts AS t1 JOIN topics AS t2 ON t1.id_topic = t2.id JOIN users AS t3 ON t1.id_user = t3.id WHERE t1.status = 1$sql_topic ORDER BY t1.id DESC $sql_pagination";
				$query = $pdo->prepare($sql);
				$query->execute();
				$All_posts = $query->fetchAll();
				?>

				<!--Пагинация-->
				<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/pagination.php');  ?>
				<!--Пагинация-->


				<!--Посты-->
				<? if(empty($All_posts)): ?>
					<div style="font-size:30px;display:flex; justify-content:center"><div style="margin-top:100px;">Ничего не найдено!</div></div>
				<? endif; ?>
				<? $i = 0; ?>
				<? foreach($All_posts as $post): ?>
					<? $i++; ?>
				<div style="display:block; width: 100%;word-break: break-word;max-height: 600px;overflow: hidden; margin-top: 15px;" class="post">
					<div>
						<div class="post-img">
							<? if(empty($post['img']) || $post['img'] == 'nofoto.png'): ?>
								<img id="pst-img<?=$i?>" src="/assets/images/nofoto.png">
							<? else: ?>
								<img id="pst-img<?=$i?>" alt="<?=substr($post['title'], 0, 50)?>" src="/assets/images/posts/<?=$post['img']?>">
							<? endif; ?>
							<script>
								$('#pst-img<?=$i?>').click(function (){
									location.href = "?page=single&id_post=<?=$post['id']?>";
								});
							</script>
						</div>
					</div>
					<div>
						<div style="max-width:100%;" class="post-text">
							<h2 class="content-color">
								<a href="?page=single&id_post=<?=$post['id']?>"><?php
									$str_length_title = 100;
									mb_strlen($post['title']) > $str_length_title ? $after = "..." : $after = "";
									echo mb_substr($post['title'], 0,$str_length_title) . $after;
									?></a>
							</h2>
							<div style="display:flex; font-size: 17px; margin-bottom: 11px;">
								<i style="margin-left: 22px;" class="far fa-user"> <?=$post['username']?></i>
								<i style="margin-left: 4%;" class="far fa-calendar"> <?=date('j F o в H:i',strtotime($post['created_date']))?></i>
								<span style="margin-left: 4%;">Категория: <a href="?topic=<?=$post['name']?>"><?=$post['name']?></a></span>
							</div>
							<p class="prewiev-text">
								<style>
									img {max-width:100%}
								</style>
								<?php
								$str_length_cont = 500;
								mb_strlen($post['content']) > $str_length_cont ? $after = "..." : $after = "";
								echo mb_substr($post['content'], 0,$str_length_cont) . $after;
								?>
								</i>
							</p>
						</div>
					</div>
				</div>
				<? endforeach; ?>
				<!--Посты-->
				<script>
					/*function click(e){
						$.ajax({
							url: "/app/include/main.php",
							type: "POST",
							data: { 'data' : 'ref_sell', 'id' : e,},
							success: function(data){
								<?/* echo $_POST['data'] . " " . $_POST['id'];*/?>
							}
						});
					}*/
				</script>
			</div>
			<? include ($_SERVER['DOCUMENT_ROOT'] . '/app/include/sidebar.php');?>
		</div>
	</div>
</main>
