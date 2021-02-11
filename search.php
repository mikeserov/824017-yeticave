<?php
$title = 'Результаты поиска по запросу%поисковый_запрос%';
require_once('functions.php');
require_once('data.php');
require_once('init.php');

if(!$res = mysqli_query($link, 'SELECT * FROM categories')) {
	exit(show_error());
} else {
	$categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
}

$search = trim($_GET['search'] ?? '');
if (!empty($search)) {

}



$sql = 'SELECT * FROM lots '
	. 'WHERE TIMEDIFF(dt_end, NOW()) > 0 AND '
	. 'WHERE MATCH(name, description) AGAINST(?)';
$stmt = db_get_prepare_stmt($link, $sql, [$search]);
mysqli_stmt_execute($stmt);
$res =  mysqli_stmt_get_result($stmt);
$item_count = mysqli_num_rows($res);

if ($item_count > 9) {
	$cur_page = $_GET['page'] ?? 1;
	$page_count = ceil($item_count / 9);
	$offset = ($cur_page - 1) * 9;

	$sql = "SELECT l.id, dt_start, l.name, start_price, img, c.name_ru AS category, TIME_FORMAT(TIMEDIFF(dt_end, NOW()), '%H:%i') AS remaining_time FROM lots l "
	. "JOIN categories c ON l.category_id = c.id "
	. "WHERE TIMEDIFF(dt_end, NOW()) > 0 AND "
	. "WHERE MATCH(l.name, description) AGAINST(?) "
	. "ORDER BY dt_start DESC "
	. "LIMIT 9 OFFSET '$offset'";
	$stmt = db_get_prepare_stmt($link, $sql, [$search]);
	mysqli_stmt_execute($stmt);
	$res =  mysqli_stmt_get_result($stmt);
	$item_count = mysqli_num_rows($res);

}






/*if ($search) {
	$sql = "SELECT l.id, dt_start, l.name, start_price, img, c.name_ru AS category, TIME_FORMAT(TIMEDIFF(dt_end, NOW()), '%H:%i') AS remaining_time FROM lots l "
	. 'JOIN categories c ON l.category_id = c.id '
	. 'WHERE TIMEDIFF(dt_end, NOW()) > 0 AND '
	. 'WHERE MATCH(l.name, description) AGAINST(?)'
	. 'ORDER BY dt_start DESC ' 
	. 'LIMIT 9 OFFSET ' . "''";
}*/