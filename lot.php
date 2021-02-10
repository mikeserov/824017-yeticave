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
$lot_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$form_error = '';
$val_entered = '';
$rt_already_added = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!isset($_SESSION['user'])) {
		exit(show_error('403', 'Недостаточно прав для добавления ставки. Пожалуйста, войдите в учетную запись, чтобы иметь возможность добавить ставку.', $categories));
	} else {
		if (empty($_POST['cost'])) {
			$form_error = 'Введите значение ставки';
		} else {
			$res = mysqli_query($link, 'SELECT IFNULL(rate + rate_step, start_price + rate_step) AS min_valid_rate FROM lots '
				.'LEFT JOIN rates ON rates.lot_id = lots.id '
				."WHERE lots.id = '$lot_id' "
				.'ORDER BY rate DESC '
				.'LIMIT 1');
			$min_valid_rate = mysqli_fetch_assoc($res)['min_valid_rate'];
			$new_rate = filter_input(INPUT_POST, 'cost', FILTER_VALIDATE_INT, ['options' => ['min_range' => $min_valid_rate]]);
			if (!$new_rate) {
				$form_error = 'Введите целое значение не менее чем мин. ставка';
				$val_entered = $_POST['cost'];
			} else {
				$user_id = $_SESSION['user']['id'];
				$sql = "INSERT INTO rates (rate, user_id, lot_id) VALUES ('$new_rate', '$user_id', '$lot_id')";
				$res = mysqli_query($link, $sql);	
			}
		}
	}
}
$res = mysqli_query($link, 'SELECT l.id, description, name, start_price, img_ref AS URL, c.name_ru AS category, rate_step, rate AS max_rate_added, '
	."IFNULL(rate, start_price) AS current_price, IFNULL(rate + rate_step, start_price + rate_step) AS min_valid_rate, TIME_FORMAT(TIMEDIFF(dt_end, NOW()), '%H:%i') AS remaining_time, author FROM lots l "
		.'JOIN categories c ON l.category_id = c.id '
		.'LEFT JOIN rates ON rates.lot_id = l.id '
		."WHERE l.id = '$lot_id' "
		.'ORDER BY rate DESC '
		.' LIMIT 1');

if ($lot_id && mysqli_num_rows($res)) {
	$lot_info = mysqli_fetch_assoc($res);
	if (isset($_SESSION['user'])) {
		$user_id = $_SESSION['user']['id'];
		$sql = "SELECT * FROM rates WHERE user_id = '$user_id' AND lot_id = '$lot_id'";
		$res = mysqli_query($link, $sql);
		$rt_already_added = mysqli_num_rows($res); 
	}
	$allow_to_add_rt = isset($_SESSION['user']) && $lot_info['remaining_time'] > 0 && $lot_info['author'] != $_SESSION['user']['id'] && !$rt_already_added;
	$sql = "SELECT dt_rate_declare, rate, users.name FROM rates JOIN users ON rates.user_id = users.id "
		."WHERE rates.lot_id = '$lot_id' ORDER BY dt_rate_declare DESC LIMIT 10";
	$res = mysqli_query($link, $sql);
	$rates = mysqli_fetch_all($res, MYSQLI_ASSOC);
	var_dump($rates);
	$tpl_data = [
		'categories' => $categories,
		'lot_info' => $lot_info,
		'error' => $form_error,
		'value' => $val_entered,
		'allow_to_add_rt' => $allow_to_add_rt,
		'rates' => $rates
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