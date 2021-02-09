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
if (!isset($_SESSION['user'])) {
	exit(show_error('403', 'Недостаточно прав для добавления лота. Пожалуйста, войдите в учетную запись, чтобы иметь возможность добавить лот.', $categories));
}

$required_attr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$required = ['lot_name', 'category', 'description', 'lot_rate', 'lot_step', 'lot_date'];
	$completed_err_messg = [
		'lot_name' => 'Введите наименование лота',
		'category' => 'Выберите категорию',
		'description' => 'Напишите описание лота',
		'lot_rate' => 'Введите начальную цену',
		'lot_step' => 'Введите шаг ставки',
		'lot_date' => 'Введите дату завершения торгов'
	];
	$errors = [];//попробовать потом выполнить код без этой строки.
	$rules = [
		'lot_name' => function($value) {
			return validateLength($value, 10, 128);
		},
		'category' => function($value) use ($cats_ids) {
			return validateCategory($value, $cats_ids);
		},
		'description' => function($value) {
			return validateLength($value, 10, 3000);
		},
		'lot_rate' => function($value) {
			return validateType($value);
		},
		'lot_step' => function($value) {
			return validateType($value);
		}
	];
	$new_lot = filter_input_array(INPUT_POST, ['lot_name' => FILTER_DEFAULT, 'category' => FILTER_DEFAULT, 'description' => FILTER_DEFAULT, 'lot_rate' => FILTER_DEFAULT, 'lot_step' => FILTER_DEFAULT, 'lot_date' => FILTER_DEFAULT], true);
	//спросить у наставника нужен ли здесь фильтр FILTER_SANITIZE_FULL_SPECIAL_CHARS
	foreach($new_lot as $key => $value) {
		if(isset($rules[$key])) {
			$rule = $rules[$key];
			$errors[$key] = $rule($value);
		}
		if(in_array($key, $required) && empty($value)) {
			$errors[$key] = $completed_err_messg[$key];
		}
	}
	$errors = array_filter($errors);
	if (!empty($_FILES['lot_img']['name'])) {
		$tmp_name = $_FILES['lot_img']['tmp_name'];
		$path = $_FILES['lot_img']['name'];
		$filename = uniqid() . '.jpg';
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$file_type = finfo_file($finfo, $tmp_name);
		if ($file_type !== "image/jpeg") {
			$errors['lot_img'] = 'Загрузите фото лота в формате JPG';
		} else {
			if (!count($errors)) {
				move_uploaded_file($tmp_name, 'img/' . $filename);
				$new_lot['img_ref'] = 'img/' . $filename;
			} else {
				//$new_lot['img_ref'] = $tmp_name; /*СПРОСИТЬ У ОПЫТНОГО ЧЕЛОВЕКА, ПОЧЕМУ $tmp_name не открывается в браузере? потомучто картинка в таком случае лежит не в папке сайта?.. */
				move_uploaded_file($tmp_name, 'temporary_files/' . $filename);
				$new_lot['img_ref'] = 'temporary_files/' . $filename;
			}
		} 
	} else {
		$errors['lot_img'] = 'Вы не загрузили файл';
	}
	if (count($errors)) {
		$page_content = include_template('add_lot_tmplt.php', [
			'new_lot' => $new_lot,
			'errors' => $errors,
			'categories' => $categories,
			'required' => $required_attr
		]);
	} else {
		$id = $_SESSION['user']['id'];
		$sql = "INSERT INTO lots (dt_start, author, name, category_id, description, start_price, rate_step, dt_end, img_ref) "
			. "VALUES (NOW(), '$id', ?, ?, ?, ?, ?, ?, ?)";
		$stmt = db_get_prepare_stmt($link, $sql, $new_lot);
		$res = mysqli_stmt_execute($stmt);
		if ($res) {
			$lot_id = mysqli_insert_id($link);
			header('Location: lot.php?id=' . $lot_id);
		}
	}
} else {
	$page_content = include_template('add_lot_tmplt.php', [
		'categories' => $categories,
		'required' => $required_attr
	]);
}

$layout_content = include_template('layout.php', [
	'categories' => $categories,
	'page_content' => $page_content,
	'title' => $title,
	'main_container' => ''
]);
print($layout_content);