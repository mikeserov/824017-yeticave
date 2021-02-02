<?php
$title = 'Информация о лоте';
require_once('data.php');
require_once('functions.php');
require_once('init.php');
if(!$res = mysqli_query($link, 'SELECT * FROM categories')) {
	exit(show_error());/*ЭТО РАБОТАЕТ?*/
} else {
	$categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
} 
if($id = filter_input(INPUT_GET, 'id')) {
	$sql = 'SELECT l.id, description, name, start_price AS price, img_ref AS URL, c.name_ru AS category FROM lots l '
	. 'JOIN categories c ON l.category_id = c.id '
	. 'WHERE l.id = ' . $id;
	$res = mysqli_query($link)
}

 







$page_content = include_template('lot_template.php', [
	'categories' => $categories,
	'lot_info' => ,
	'rm_time' => $rm_time
]);

$layout_content = include_template('layout.php', [
	'categories' => $categories,
	'page_content' => $page_content,
	'title' => $title
]);
print($layout_content);
?>*/