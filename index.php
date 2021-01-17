<?php
require_once('functions.php');
require_once('data.php');
$page_content = include_template('main.php', [
    'categories' => $categories,
    'lots' => $lots
]);
$layout_content = include_template('layout.php', [
    'categories' => $categories,
    'page_content' => $page_content,
    'title' => $title
]);
print($layout_content);