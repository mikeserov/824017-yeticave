<?php
require_once('functions.php');
require_once('data.php');
$page_content = include_template('main.php', [
    'categories' => $categories,
    'lots' => $lots
]);
$layout_content = include_template('layout.php', [
    'categories' => $categories,
    'page_content' => $page_content,
    'title' => $title
]);

$link = mysqli_connect("localhost", "root", "root", "yeti_cave");
if (!$link) {
	print('Ошибка соединения № ' .mysqli_connect_errno(). ': '.mysqli_connect_error());
} else {
	print('Соединение успешно установлено.');
}

printf("Первоначальная кодировка: %s\n", mysqli_character_set_name($link));

if (! mysqli_set_charset($link, "utf8")) {
	print('Ошибка № ' .mysqli_errno($link). ': '.mysqli_error($link));
} else {
	print('Кодировка успешно установлена. Текущая кодировка: '.mysqli_character_set_name($link));
}



/*$stm = 'select * from categories;*/

print($layout_content);