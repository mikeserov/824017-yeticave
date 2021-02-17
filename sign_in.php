<?php
$title = 'Вход';
require_once('functions.php');
require_once('init.php');
if (!$res = mysqli_query($link, 'SELECT * FROM categories')) {
    exit(show_error());
} else {
    $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
}
$required_attr ='';
$tpl_data = ['categories' => $categories, 'required' => $required_attr];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required = ['email', 'password'];
    $completed_err_messg = [
        'email' => 'Введите e-mail',
        'password' => 'Введите пароль'
    ];
    $errors = [];
    $form = $_POST;
    foreach ($form as $key => $value) {
        if (in_array($key, $required) && empty($value)) {
            $errors[$key] = $completed_err_messg[$key];
        }
    }
    if (!$errors) {
        $email = mysqli_real_escape_string($link, $form['email']);
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $res = mysqli_query($link, $sql);
        $user = $res ? mysqli_fetch_assoc($res) : null;
        if ($user) {
            if (password_verify($form['password'], $user['password'])) {
                $_SESSION['user'] = $user;
                header('Location: /index.php');
                exit();
            } else {
                $errors['password'] = 'Вы ввели неверный пароль';
            }
        } else {
            $errors['email'] = 'Такой пользователь не найден';
        }
    }
    $tpl_data = array_merge($tpl_data, ['errors' => $errors, 'values' => $form]);
}
$page_content = include_template('sign_in_tmplt.php', $tpl_data);
$layout_content = include_template('layout.php', [
    'categories' => $categories,
    'page_content' => $page_content,
    'title' => $title,
    'main_container' => ''
]);
print($layout_content);
