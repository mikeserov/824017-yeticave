<?php
require_once('functions.php');
require_once('init.php');

if (!$res = mysqli_query($link, 'SELECT * FROM categories')) {
    exit(show_error());
} else {
    $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
}

$title = 'Мои ставки';

if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['id'];
    $sql = "SELECT user_id, dt_rate, rate, rates.lot_id, lots.name AS lot_name, img, TIME_FORMAT(TIMEDIFF(dt_end, NOW()), '%H:%i:%S') "
            . 'AS remaining_time, contacts, categories.name_ru AS category, winner FROM lots '
                . 'JOIN users ON lots.author = users.id '
                . 'JOIN rates ON lots.id = rates.lot_id '
                . 'JOIN categories ON categories.id = lots.category_id '
                . "WHERE user_id = '$user_id' "
                . 'ORDER BY dt_rate DESC';
    $res = mysqli_query($link, $sql);
    $rates = mysqli_fetch_all($res, MYSQLI_ASSOC);

    $page_content = include_template('my_rates_tmplt.php', [
        'categories' => $categories,
        'rates' => $rates
    ]);
    $layout_content = include_template('layout.php', [
        'categories' => $categories,
        'page_content' => $page_content,
        'title' => $title,
    ]);
    print($layout_content);
} else {
    exit(show_error('403', 'Недостаточно прав. Пожалуйста, авторизуйтесь, чтобы получить доступ к информации о ваших ставках.', $categories));
}
