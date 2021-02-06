<?php
$title = 'Регистрация';
require_once('functions.php');
require_once('init.php');
if(!$res = mysqli_query($link, 'SELECT * FROM categories')) {
	exit(show_error());
} else {
	$categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
}
$required_attr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$required = ['email', 'password', 'name', 'message'];
	$completed_err_messg = [
		'email' => 'Введите e-mail',
		'password' => 'Введите пароль',
		'name' => 'Введите имя',
		'message' => 'Напишите как с вами связаться'
	];
	$errors = [];//попробовать потом выполнить код без этой строки.
	$form = filter_input_array(INPUT_POST, ['email' => FILTER_DEFAULT, 'password' => FILTER_DEFAULT, 'name' => FILTER_DEFAULT, 'message' => FILTER_DEFAULT], true);
	//$form = $_POST; попробовать
	//var_dump($form); попробовать
	//var_dump($_POST); попрбовать

	foreach($form as $key => $value) {
		if (in_array($key, $required) && empty($value)) {
			$errors[$key] = $completed_err_messg[$key];
		}
	}
	if (isset($form['email']) && !filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = 'Некорректный формат e-mail';
	}
	if (!empty($_FILES['photo2']['name'])) {
		$tmp_name = $_FILES['photo2']['tmp_name'];
		$path = $_FILES['photo2']['name'];
		$filename = uniqid() . '.jpg';
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$file_type = finfo_file($finfo, $tmp_name);
		if ($file_type == "image/jpeg" && $file_type == "image/png") {
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
	}


	if (!$errors) {
		$email = mysqli_real_escape_string($link, $form['email']);
		$sql = "SELECT * FROM users WHERE email = '$email'";
		$res = mysqli_query($link, $sql);
		if (mysqli_num_rows($res) > 0) {
			$errors[] = 'Пользователь с этим e-mail уже зарегистрирован';
		} else {
			$sql = 'INSERT INTO users (dt_add, email, name, password, avatar_ref, contacts) VALUES (NOW(), ?, ?, ?, ?, ?)'

		}
	}






	$errors = array_filter($errors);
	
	if (count($errors)) {
		$page_content = include_template('add_lot_tmplt.php', [
			'new_lot' => $new_lot,
			'errors' => $errors,
			'categories' => $categories,
			'required' => $required_attr
		]);
	} else {
		$sql = 'INSERT INTO lots (dt_start, author, name, category_id, description, start_price, rate_step, dt_end, img_ref) '
			. 'VALUES (NOW(), 1, ?, ?, ?, ?, ?, ?, ?)';
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


