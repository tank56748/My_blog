<?
$sql_for_pag = "SELECT t3.username, t2.name, t1.id, t1.status, t1.title, t1.img, t1.content, t1.created_date FROM posts AS t1 JOIN topics AS t2 ON t1.id_topic = t2.id JOIN users AS t3 ON t1.id_user = t3.id WHERE t1.status = 1$sql_topic ORDER BY t1.id DESC";
$query = $pdo->prepare($sql_for_pag);
$query->execute();
$posts_pag = $query->fetchAll();
if($_GET['topic']){
	$str1 = "&";
}else{
	$str1 = "";
}
$get_pg = $_GET['pagination'];

?>
<div style="display:flex; flex-wrap: wrap; margin-left: 7%;">
	<a href="?<?=$page_get?><?=$topic_get?><?=$str1?>pagination=1"><div class="pag-item">Первая</div></a>
	<? if($_GET['pagination'] == 1 || !isset($_GET['pagination'])){
		$back = 1;
	}else{
		$back = $_GET['pagination'] - 1;
	}
	?>
	<a href="?<?=$page_get?><?=$topic_get?><?=$str1?>pagination=<?=$back?>"><div class="pag-item">Назад</div></a>
	<? for($i = 1;$i <= (ceil(count($posts_pag) / $limit)); $i++): ?>
		<? if($get_pg == 1 || $get_pg == (ceil(count($posts_pag) / $limit))){
			$plus = 4;
			$minus = 4;
		}elseif($get_pg == 2 || $get_pg == (ceil(count($posts_pag) / $limit)) - 1){
			$plus = 3;
			$minus = 3;
		}elseif(!isset($_GET['pagination'])){
			$plus = 5;
			$minus = 2;
		}else{
			$plus = 2;
			$minus = 2;
		}
		?>
		<? if($i >= $get_pg - $minus && $i <= $get_pg + $plus): ?>
			<a href="?<?=$page_get?><?=$topic_get?><?=$str1?>pagination=<?=$i?>">
				<div class="pag-item <?
				if($_GET['pagination'] == $i) echo "pag-item-active";
				if(!isset($_GET['pagination']) && $i == 1) echo "pag-item-active";
				?>"><?=$i?></div></a>
		<? endif; ?>
	<? endfor; ?>
	<?
	if(count($posts_pag) <= $limit){
		$forward = 1;
	}elseif($_GET['pagination'] == ceil(count($posts_pag) / $limit)){
		$forward = ceil(count($posts_pag) / $limit);
	}elseif(!isset($_GET['pagination'])){
		$forward = 2;
	}else{
		$forward = $_GET['pagination'] + 1;
	}
	?>
	<a href="?<?=$page_get?><?=$topic_get?><?=$str1?>pagination=<?=$forward?>"><div class="pag-item">Вперед</div></a>
	<a href="?<?=$page_get?><?=$topic_get?><?=$str1?>pagination=<?=ceil(count($posts_pag) / $limit)?>"><div class="pag-item">Последняя</div></a>
</div>