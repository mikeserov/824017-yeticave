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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!isset($_SESSION['user'])) {
		exit(show_error('403', 'Недостаточно прав для добавления ставки. Пожалуйста, войдите в учетную запись, чтобы иметь возможность добавить ставку.', $categories));
	} else {
		if (empty($_POST['cost'])) {
			$form_error = 'Введите значение ставки';
			require_once('lot.php');
			exit;
		} else {
			$res = mysqli_query($link, 'SELECT IFNULL(rate + rate_step, start_price + rate_step) AS min_valid_rate FROM lots '
				.'LEFT JOIN rates ON rates.lot_id = lots.id '
				."WHERE lots.id = '$id' "
				.'ORDER BY rate DESC '
				.'LIMIT 1');
				$min_valid_rate = mysqli_fetch_assoc($res)['min_valid_rate'];
			if (!filter_input(INPUT_POST, 'cost', FILTER_VALIDATE_INT, ['options' => ['min_range' => $min_valid_rate]])) {
				$form_error = 'Введите целое значение не менее чем мин. ставка';
				require_once('lot.php');
		}
	}
}

}



$form_error = '';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$res = mysqli_query($link, 'SELECT l.id, description, name, start_price, img_ref AS URL, c.name_ru AS category, rate_step, rate AS max_rate_added, '
	.'IFNULL(rate, start_price) AS current_price, IFNULL(rate + rate_step, start_price + rate_step) AS min_valid_rate FROM lots l '
		.'JOIN categories c ON l.category_id = c.id '
		.'LEFT JOIN rates ON rates.lot_id = l.id '
		."WHERE l.id = '$id' "
		.'ORDER BY rate DESC '
		.' LIMIT 1');
if ($id && mysqli_num_rows($res)) {
	$lot_info = mysqli_fetch_assoc($res);
	$tpl_data = [
		'categories' => $categories,
		'lot_info' => $lot_info,
		'rm_time' => $rm_time,
		'error' => $form_error
	];
	$tpl_file = 'lot_info.php';
} else {
	$tpl_data = [
		'error_number' => '404 Страница не найдена',
		'error_message' => 'Данной страницы не существует на сайте.',
		'categories' => $categories
	];
	$tpl_file ='error.php';
}
$page_content = include_template($tpl_file, $tpl_data);
$layout_content = include_template('layout.php', [
	'categories' => $categories,
	'page_content' => $page_content,
	'title' => $title,
	'main_container' => ''
]);
print($layout_content);