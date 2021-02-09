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
	if (empty($_POST['cost'])) {
		$form_error = 'Введите значение ставки';
		$referer_array = explode('=', $_SERVER['HTTP_REFERER']);
		$id = intval($referer_array[1]);
		require_once('lot.php');
	}
}