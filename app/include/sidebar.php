<div class="sidebar">
	<div class="search section">
		<h3>Поиск</h3>
		<form action="?page=search" method="post">
			<input type="text" name="search-term" class="text-input" placeholder="Введите искомое слово...">
			<button name="button-search" style="padding:7px;background:#2d60c9;border:1px solid #1343a7;border-radius:5px;color:white;cursor:pointer;width: 100%;margin-top: 15px;" type="submit">Поиск</button>
		</form>
	</div>
	<? if(!isset($_GET['page'])): ?>
	<div class="topics section">
		<h3>Категории</h3>
		<ul>
			<? $topics = selectAll('topics'); ?>
			<? foreach($topics as $key => $topic):?>
				<li><a href="?<?=$page_get?>topic=<?=$topic['name']?>"><?=$topic['name']?></a></li>
			<? endforeach;?>
		</ul>
	</div>
	<? endif; ?>
</div>
