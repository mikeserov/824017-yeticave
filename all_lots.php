<?php
require_once('functions.php');
require_once('init.php');

if(!$res = mysqli_query($link, 'SELECT * FROM categories')) {
	exit(show_error());
} else {
	$categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
}

$cur_category = esc($_GET['category'] ?? '');
$title = 'Все лоты в категории «' . $cur_category . '»';
$tpl_data = [
	'pages_count' => '',
	'cur_category' => '',
	'categories' => $categories
];

if ($cur_category) {
	$sql = "SELECT l.id, dt_start, l.name, start_price, img, c.name_ru AS category, TIME_FORMAT(TIMEDIFF(dt_end, NOW()), '%H:%i') AS remaining_time FROM lots l "
	. "JOIN categories c ON l.category_id = c.id "
	. "WHERE TIMEDIFF(dt_end, NOW()) > 0 "
	. "AND c.name_ru = ? "
	. "ORDER BY dt_start DESC";
	$stmt = db_get_prepare_stmt($link, $sql, [$cur_category]);
	mysqli_stmt_execute($stmt);
	$res =  mysqli_stmt_get_result($stmt);

	if ($res && mysqli_num_rows($res)) {

		$item_count = mysqli_num_rows($res);
		$cur_page = $_GET['page'] ?? 1;
		$pages_count = ceil($item_count / 9);
		$offset = ($cur_page - 1) * 9;
		mysqli_data_seek($res, $offset);
		$pages = range(1, $pages_count);
		$tpl_data = [
			'categories' => $categories,
			'lots' => $res,
			'cur_category' => $cur_category,
			'pages_count' => $pages_count,
			'cur_page' => $cur_page,
			'pages' => $pages
		];
		
	} else {
		$tpl_data = [
			'categories' => $categories,
			'cur_category' => $cur_category,
			'pages_count' => ''
		];
	}		
}

$page_content = include_template('all_lots_tmplt.php', $tpl_data);
$layout_content = include_template('layout.php', [
	'categories' => $categories,
	'page_content' => $page_content,
	'title' => $title,
	'cur_category' => $cur_category
]);
print($layout_content);