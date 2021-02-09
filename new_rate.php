<?php
require_once('functions.php');
require_once('init.php');
if(!$res = mysqli_query($link, 'SELECT * FROM categories')) {
	exit(show_error());
} else {
	$categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
}

if (!isset($_SESSION['user'])) {
	exit(show_error('403', 'Недостаточно прав для добавления лота. Пожалуйста, войдите в учетную запись, чтобы иметь возможность добавить лот.', $categories));
} else {
		$referer_array = explode('=', $_SERVER['HTTP_REFERER']);
		var_dump($referer_array);
		$id = intval($referer_array[1]);
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
