<?php



// Сортировка по дате
if(!isset($posts_date_sort)){
	$posts_date_sort = "?page=ADM_posts_index&sort=posts_date_asc";
}

if($_GET['sort'] == "posts_date_asc"){
	$postsADM = selectAllFromPostsWithUsers('posts', 'users', 'created_date', 'ASC');
	$posts_date_sort = "?page=ADM_posts_index&sort=posts_date_desc";
	$fa_date = "up";
}
if($_GET['sort'] == "posts_date_desc"){
	$postsADM = selectAllFromPostsWithUsers('posts', 'users', 'created_date', 'DESC');
	$posts_date_sort =  "?page=ADM_posts_index&sort=posts_date_asc";
	$fa_date = "down";
}

// Сортировка по автору
if(!isset($posts_author_sort)){
	$posts_author_sort = "?page=ADM_posts_index&sort=posts_author_asc";
}

if($_GET['sort'] == "posts_author_asc"){
	$postsADM = selectAllFromPostsWithUsers('posts', 'users', 'username', 'ASC');
	$posts_author_sort = "?page=ADM_posts_index&sort=posts_author_desc";
	$fa_author = "up";
}
if($_GET['sort'] == "posts_author_desc"){
	$postsADM = selectAllFromPostsWithUsers('posts', 'users', 'username', 'DESC');
	$posts_author_sort =  "?page=ADM_posts_index&sort=posts_author_asc";
	$fa_author = "down";
}

// Сортировка по названию

if(!isset($posts_name_sort)){
	$posts_name_sort = "?page=ADM_posts_index&sort=posts_name_asc";
}

if($_GET['sort'] == "posts_name_asc"){
	$postsADM = selectAllFromPostsWithUsers('posts', 'users', 'title', 'ASC');
	$posts_name_sort = "?page=ADM_posts_index&sort=posts_name_desc";
	$fa_name = "up";
}
if($_GET['sort'] == "posts_name_desc"){
	$postsADM = selectAllFromPostsWithUsers('posts', 'users', 'title', 'DESC');
	$posts_name_sort =  "?page=ADM_posts_index&sort=posts_name_asc";
	$fa_name = "down";
}

// Сортировка по статусу

if(!isset($posts_status_sort)){
	$posts_status_sort = "?page=ADM_posts_index&sort=posts_status_asc";
}

if($_GET['sort'] == "posts_status_asc"){
	$postsADM = selectAllFromPostsWithUsers('posts', 'users', 'status', 'ASC');
	$posts_status_sort = "?page=ADM_posts_index&sort=posts_status_desc";
	$fa_status = "up";
}
if($_GET['sort'] == "posts_status_desc"){
	$postsADM = selectAllFromPostsWithUsers('posts', 'users', 'status', 'DESC');
	$posts_status_sort =  "?page=ADM_posts_index&sort=posts_status_asc";
	$fa_status = "down";
}

?>