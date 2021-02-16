<?php
require_once('functions.php');
require_once('init.php');

if(!$res = mysqli_query($link, 'SELECT * FROM categories')) {
	exit(show_error());
} else {
	$categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
}

$title = 'Мои ставки';

if (isset($_SESSION['user'])) {

	$sql = "SELECT dt_rate, rate, rates.lot_id, lots.name, img, TIME_FORMAT(TIMEDIFF(dt_end, NOW()), '%H:%i:%S') "
			. 'AS remaining_time, contacts, categories.name_ru, winner FROM lots '
				. 'JOIN users ON lots.author = users.id '
				. 'JOIN rates ON lots.id = rates.lot_id '
				. 'JOIN categories ON categories.id = lots.category_id '
				. 'WHERE user_id = 3 AND rates.lot_id = 15 '
				. 'ORDER BY dt_rate DESC';
	$res = mysqli_query($link, $sql);
	//var_dump(mysqli_num_rows($res));
	$res = mysqli_fetch_assoc($res);
	var_dump($res['remaining_time']);

} else {
	echo 'пожалуйста, войдите в учетную запись и повторно перейдите на страницу my_rates.php';
}