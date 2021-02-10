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

funcion time_gone ($dt_rate_declare) {
    date_default_timezone_set("Asia/Yekaterinburg");
    setlocale(LC_ALL, 'ru_RU');
    $dt_now = date_create();    
    $dt_rate_declare = date_create($dt_rate_declare);
    $dt_diff = date_diff($dt_now, $dt_rate_declare);
    //$dt_diff = date_interval_format($dt_diff,"%H:%I");

    if ($dt_diff > '59:59')
    return $time_count;
}