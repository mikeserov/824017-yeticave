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

function show_connection_error () {
    global $title;
    $error_number = 'Ошибка соединения №' . mysqli_connect_errno() . ': ';
    $error_message = mysqli_connect_error();
    $content = include_template('error.php', [
        'error_number' => $error_number,
        'error_message' => $error_message,
        'categories' => []
    ]);
    $layout = include_template('layout.php', [
        'categories' => [],
        'content' => $content,
        'title' => $title
    ]);
    return $layout;
}

function show_error () {
    global $link;
    global $title;
    $error_number = 'Ошибка №' . mysqli_errno($link) . ': ';
    $error_message = mysqli_error($link);
    $content = include_template('error.php', [
        'error_number' => $error_number,
        'error_message' => $error_message,
        'categories' => []
    ]);
    $layout = include_template('layout.php', [
        'categories' => [],
        'content' => $content,
        'title' => $title
    ]);
    return $layout;
}
/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
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