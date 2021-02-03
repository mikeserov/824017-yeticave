<?php
$title = 'Добавление лота';
require_once('functions.php');
require_once('data.php');
require_once('init.php');
if(!$res = mysqli_query($link, 'SELECT * FROM categories')) {
	exit(show_error());
} else {
	$categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
	$cats_ids = array_column($categories, 'id');
}

	$rules = [
		'lot_name' => function($value) {
			return validateLength($value70, 128)
		}]


if($_SERVER['REQUEST_METHOD'] == 'POST') {
	new_lot = filter_inpur_array(INPUT_POST, ['lot_name' => FILTER_DEFAULT, 'category' => FILTER_DEFAULT, 'description' => FILTER_DEFAULT, 'lot_rate' => FILTER_DEFAULT, 'lot_step' => FILTER_DEFAULT, 'lot_date' => FILTER_DEFAULT], true);
	/*спросить у наставника нужен ли здесь фильтр FILTER_SANITIZE_FULL_SPECIAL_CHARS*/
	foreach($new_lot as $key => $value) {
		if(isset($rules[$key])) {
			$rule = $rules[$key];


		}
	}

}



