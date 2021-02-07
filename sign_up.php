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
$tpl_data = ['categories' => $categories, 'required' => $required_attr];

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

	foreach($form as $key => $value) {
		if (in_array($key, $required) && empty($value)) {
			$errors[$key] = $completed_err_messg[$key];
		}
	}
	if (!empty($form['email']) && !filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = 'Некорректный формат e-mail';
	}
	if (!empty($_FILES['photo2']['name'])) {
		$tmp_name = $_FILES['photo2']['tmp_name'];
		$filename = $_FILES['photo2']['name'];
		$get_format = explode(".", $filename);
		$format = end($get_format);
		$filename = uniqid() . $format;
		$file_type = mime_content_type($tmp_name);
		if ($file_type == "image/jpeg" or $file_type == "image/png") {
			if (!count($errors)) {
				move_uploaded_file($tmp_name, 'avatars/' . $filename);
				$form['photo2'] = 'avatars/' . $filename;
			}
		} else {
			$errors['photo2'] = 'Загрузите фото в формате JPG или PNG';
		}
	}
	if (!$errors) {
		$email = mysqli_real_escape_string($link, $form['email']);
		$sql = "SELECT * FROM users WHERE email = '$email'";
		$res = mysqli_query($link, $sql);
		if (mysqli_num_rows($res) > 0) {
			$errors['email'] = 'Пользователь с этим e-mail уже зарегистрирован';
		} else {
			$password = password_hash($form['password'], PASSWORD_DEFAULT);
			$form['password'] = $password;
			$sql = isset($form['photo2']) ? 'INSERT INTO users (dt_add, email, password, name, contacts, avatar_ref) VALUES (NOW(), ?, ?, ?, ?, ?)'
				: 'INSERT INTO users (dt_add, email, password, name, contacts, avatar_ref) VALUES (NOW(), ?, ?, ?, ?, NULL)';
			$stmt = db_get_prepare_stmt($link, $sql, $form);
			$res = mysqli_stmt_execute($stmt);
		}
		if ($res && empty($errors)) {
			header('Location: sign_in.php');
			exit();
		}
	}
	$tpl_data = array_merge($tpl_data, ['errors' => $errors, 'values' => $form]);
}
$page_content = include_template('sign_up_tmplt.php', $tpl_data);
$layout_content = include_template('layout.php', [
	'categories' => $categories,
	'page_content' => $page_content,
	'title' => $title,
	'main_container' => ''
]);
print($layout_content);


