<?php
require_once('functions.php');
require_once('data.php');
$title = 'Главная';
require_once('init.php');
$res = mysqli_query($link, "SELECT l.id, dt_start, l.name, start_price, img, c.name_ru AS category, TIME_FORMAT(TIMEDIFF(dt_end, NOW()), '%H:%i') AS remaining_time FROM lots l "
	. 'JOIN categories c ON l.category_id = c.id '
	. 'WHERE TIMEDIFF(dt_end, NOW()) > 0 '
	. 'ORDER BY dt_start DESC ' 
	. 'LIMIT 6');
$lots = mysqli_fetch_all($res, MYSQLI_ASSOC);
$res = mysqli_query($link, 'SELECT * FROM categories');
$categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
$page_content = include_template('main.php', [
	'categories' => $categories,
	'lots' => $lots
]);

$layout_content = include_template('layout.php', [
	'categories' => $categories,
	'page_content' => $page_content,
	'title' => $title,
	'main_container' => 'container'
]);
print($layout_content);