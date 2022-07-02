
<aside class="aside">
	<ul>
		<li id="ADM_posts">
			<a href="?page=ADM_posts_index">Записи</a>
		</li>
		<li id="ADM_users">
			<a href="?page=ADM_users_index">Пользователи</a>

		</li>
		<li id="ADM_topics">
			<a href="?page=ADM_topics_index">Категории</a>

		</li>
		<li id="ADM_settings">
			<a href="?page=ADM_settings_index">Настройки</a>
		</li>
	</ul>
</aside>

<?php
$page_filter = preg_filter('/(_index\w*)|(_edit\w*)|(_create\w*)/', '', $page);
?>
<script>document.getElementById('<?=$page_filter?>').className = 'focus';</script>