<?php
function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';
    if (!file_exists($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function show_price ($price_of_a_lot) {
    if ($price_of_a_lot > 1000) {
        $price_of_a_lot = number_format(ceil($price_of_a_lot), 0, ',', ' ');
    }
    return "$price_of_a_lot"." ₽";
}

function esc ($str) {
    $text = htmlspecialchars($str);
    return $text;
}

function remaining_time () {
    date_default_timezone_set("Asia/Yekaterinburg");
    setlocale(LC_ALL, 'ru_RU');
    $time_end = date_create('tomorrow');
    $time_now = date_create();
    $time_diff = date_diff($time_end, $time_now);
    $time_count = date_interval_format($time_diff,"%H:%I:%S");
    return $time_count;
}