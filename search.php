<?php
require_once('functions.php');
require_once('init.php');

if (!$res = mysqli_query($link, 'SELECT * FROM categories')) {
    exit(show_error());
} else {
    $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
}

$search = esc(trim($_GET['search'] ?? ''));
$title = 'Результаты поиска по запросу «' . $search . '»';
if (!empty($search)) {
    $sql = "SELECT l.id, dt_start, l.name, start_price, img, c.name_ru AS category, TIME_FORMAT(TIMEDIFF(dt_end, NOW()), '%H:%i') AS remaining_time FROM lots l "
    . "JOIN categories c ON l.category_id = c.id "
    . "WHERE TIMEDIFF(dt_end, NOW()) > 0 "
    . "AND MATCH(l.name, description) AGAINST(?) "
    . "ORDER BY dt_start DESC";
    $stmt = db_get_prepare_stmt($link, $sql, [$search]);
    mysqli_stmt_execute($stmt);
    $res =  mysqli_stmt_get_result($stmt);
    $item_count = mysqli_num_rows($res);
    $cur_page = $_GET['page'] ?? 1;
    $pages_count = ceil($item_count / 9);
    $offset = ($cur_page - 1) * 9;
    mysqli_data_seek($res, $offset);
    $pages = range(1, $pages_count);
    $tpl_data = [
        'categories' => $categories,
        'lots' => $res,
        'search' => $search,
        'pages_count' => $pages_count,
        'cur_page' => $cur_page,
        'pages' => $pages
    ];
} else {
    $tpl_data = [
        'categories' => $categories,
        'search' => $search,
        'pages_count' => ''
    ];
}

$page_content = include_template('search_tmplt.php', $tpl_data);
$layout_content = include_template('layout.php', [
    'categories' => $categories,
    'page_content' => $page_content,
    'title' => $title,
    'search' => $search
]);
print($layout_content);
