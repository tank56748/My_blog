<?php
// Сортировка по названию

if(!isset($posts_name_sort)){
	$topic_name_sort = "?page=ADM_topics_index&sort=topic_name_asc";
}

if($_GET['sort'] == "topic_name_asc"){
	global $pdo;
	$sql = "SELECT * from topics ORDER BY name ASC";
	$query = $pdo->prepare($sql);
	$query->execute();
	$topicss = $query->fetchAll();
	$topic_name_sort = "?page=ADM_topics_index&sort=topic_name_desc";
	$fa_name = "up";
}
if($_GET['sort'] == "topic_name_desc"){
	global $pdo;
	$sql = "SELECT * from topics ORDER BY name DESC";
	$query = $pdo->prepare($sql);
	$query->execute();
	$topicss = $query->fetchAll();
	$topic_name_sort =  "?page=ADM_topics_index&sort=topic_name_asc";
	$fa_name = "down";
}
?>