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

function my_number_format ($price_of_a_lot) {
    if ($price_of_a_lot > 1000) {
        $price_of_a_lot = number_format(ceil($price_of_a_lot), 0, ',', ' ');
    }
    return "$price_of_a_lot";
}

function esc ($str) {
    $text = htmlspecialchars($str);
    return $text;
}

/*function remaining_time () {
    date_default_timezone_set("Asia/Yekaterinburg");
    setlocale(LC_ALL, 'ru_RU');
    $time_end = date_create('tomorrow');
    $time_now = date_create();
    $time_diff = date_diff($time_end, $time_now);
    $time_count = date_interval_format($time_diff,"%H:%I:%S");
    return $time_count;
} пока не нужно, время до конца торгов расчитывается в запросе SELECT на стороне SQL */

function show_connection_error () {
    global $title;
    $error_number = 'Ошибка соединения №' . mysqli_connect_errno() . ': ';
    $error_message = mysqli_connect_error();
    $page_content = include_template('error.php', [
        'error_number' => $error_number,
        'error_message' => $error_message,
        'categories' => []
    ]);
    $layout_content = include_template('layout.php', [
        'categories' => [],
        'page_content' => $page_content,
        'title' => $title,
        'main_container' => 'container'
    ]);
    return $layout_content;
}

function show_error ($errno = null, $error = null, $categories = []) {
    global $link;
    global $title;
    $error_number = 'Ошибка №' . ($errno ?? mysqli_errno($link)) . ': ';
    $error_message = $error ?? mysqli_error($link);
    $page_content = include_template('error.php', [
        'error_number' => $error_number,
        'error_message' => $error_message,
        'categories' => $categories
    ]);
    $layout_content = include_template('layout.php', [
        'categories' => $categories,
        'page_content' => $page_content,
        'title' => $title,
        'main_container' => ''
    ]);
    return $layout_content;
}

function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);
    if ($data) {
        $types = '';
        $stmt_data = [];
        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }
    return $stmt;
}

function validateLength($value, $min, $max) {
    if ($value) {
        $len = strlen($value);
        if($len < $min or $len > $max) {
            return "Значение должно быть от $min до $max символов";
        }
    }
    return null;
}

function validateCategory($id, $allowed_list) {
    if (!in_array($id, $allowed_list) && isset($id)) {
        return "Указана несуществующая категория";
    }
    return null;
}

function validateType($value) {
    if(!is_numeric($value)) {
        return "Введите значение в числовом формате";
    }
    return null;
}

function getPostVal($name) {
    return filter_input(INPUT_POST, $name);
}

function time_passed ($dt_rate) {
    date_default_timezone_set("Asia/Yekaterinburg");
    setlocale(LC_ALL, 'ru_RU');
    $dt_now = date_create();  
    $dt_rate = date_create($dt_rate);
    $dt_diff = date_diff($dt_rate, $dt_now);
    if (!$dt_diff->invert) {
        $minute_endings = [1 => 'у', 2 => 'ы', 3 => 'ы', 4 => 'ы', 5 => '', 6 => '', 7 => '', 8 => '', 9 => '', 10 => '', 11 => '', 12 => '', 13 => '', 14 => '', 15 => '', 16 => '', 17 => '', 18 => '', 19 => '', 20 => '', 21 => 'у', 22 => 'ы', 23 => 'ы', 24 => 'ы', 25 => '', 26 => '', 27 => '', 28 => '', 29 => '', 30 => '', 31 => 'у', 32 => 'ы', 33 => 'ы', 34 => 'ы', 35 => '', 36 => '', 37 => '', 38 => '', 39 => '', 40 => '', 41 => 'у', 42 => 'ы', 43 => 'ы', 44 => 'ы', 45 => '', 46 => '', 47 => '', 48 => '', 49 => '', 50 => '', 51 => 'у', 52 => 'ы', 53 => 'ы', 54 => 'ы', 55 => '', 56 => '', 57 => '', 58 => '', 59 => ''];
        $hour_endings = [1 => '', 2 => 'а', 3 => 'а', 4 => 'а', 5 => 'ов', 6 => 'ов', 7 => 'ов', 8 => 'ов', 9 => 'ов', 10 => 'ов', 11 => 'ов', 12 => 'ов', 13 => 'ов', 14 => 'ов', 15 => 'ов', 16 => 'ов', 17 => 'ов', 18 => 'ов', 19 => 'ов', 20 => 'ов', 21 => '', 22 => 'а', 23 => 'а'];
        $y = $dt_diff->y;
        $m = $dt_diff->m;
        $d = $dt_diff->d;
        $h = $dt_diff->h;
        $i = $dt_diff->i;
        if ($y || $m || $d) {
            $time_passed = date_format($dt_rate, 'd.m.y в H:i');
        } else {
            if (!$h && !$i) {
                $time_passed = 'только что';
            } else {
                if ($h) {
                    $time_passed = $h . ' час' . $hour_endings[$h] . ' назад';
                } else {
                    $time_passed = $i . ' минут' . $minute_endings[$i] . ' назад';
                }
            }
        }
        return $time_passed;
    }
    return;  
}