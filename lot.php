<?php
$title = 'Информация о лоте';
require_once('functions.php');
require_once('data.php');
require_once('init.php');
if(!$res = mysqli_query($link, 'SELECT * FROM categories')) {
	exit(show_error());
} else {
	$categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
}
if (!isset($id)) {
	$form_error = '';
	$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
}
$res = mysqli_query($link, 'SELECT l.id, description, name, start_price AS price, img_ref AS URL, c.name_ru AS category FROM lots l '
	. 'JOIN categories c ON l.category_id = c.id '
	. 'WHERE l.id = ' . $id);
if ($id && mysqli_num_rows($res)) {
	$lot_info = mysqli_fetch_assoc($res);
	$page_content = include_template('lot_info.php', [
		'categories' => $categories,
		'lot_info' => $lot_info,
		'rm_time' => $rm_time,
		'error' => $form_error
	]);
	$layout_content = include_template('layout.php', [
		'categories' => $categories,
		'page_content' => $page_content,
		'title' => $title,
		'main_container' => ''
	]);
	print($layout_content);
} else {
	$error_number = '404 Страница не найдена';
	$error_message = 'Данной страницы не существует на сайте.';
	$page_content = include_template('error.php', [
		'error_number' => $error_number,
		'error_message' => $error_message,
		'categories' => $categories
	]);
	$layout_content = include_template('layout.php', [
		'categories' => $categories,
		'page_content' => $page_content,
		'title' => $title,
		'main_container' => ''
	]);
	print($layout_content);
}