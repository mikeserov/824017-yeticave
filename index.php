<?php
require_once('functions.php');
require_once('data.php');


$link = mysqli_connect("localhost", "root", "root", "yeti_cave");
if (!$link) {
	print('Ошибка соединения № ' .mysqli_connect_errno(). ': '.mysqli_connect_error().'<br>');
} else {
	if (! mysqli_set_charset($link, "utf8")) {
		print('Кодировка не установлена, ошибка №' .mysqli_errno($link). ': '.mysqli_error($link).'<br>');
	} else {
		$res = mysqli_query($link, 'SELECT l.id, l.name, start_price AS price, img_ref AS URL, c.name_ru AS category FROM lots l '
			. 'JOIN categories c ON l.category_id = c.id '
			/*WHERE 	 > CURRENT_TIMESTAMP (РЕАЛИЗОВАТЬ К ПОСЛЕДНЕМУ УРОКУ!)
			ORDER BY dt_start DESC   (РЕАЛИЗОВАТЬ К ПОСЛЕДНЕМУ УРОКУ!)*/
			. 'LIMIT 6');
		$lots = mysqli_fetch_all($res, MYSQLI_ASSOC);
		$res = mysqli_query($link, 'SELECT * FROM categories');
		$categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
		$page_content = include_template('main.php', [
			'categories' => $categories,
			'lots' => $lots,
			'rm_time' => $rm_time
		]);
	}	
}

$layout_content = include_template('layout.php', [
	'categories' => $categories,
	'page_content' => $page_content,
	'title' => $title
]);
print($layout_content);