<?php








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
?>