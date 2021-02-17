<?php
/**
 * Подключает шаблон страницы и заполняет переданными данными
 *
 * @param string $name имя файла шаблона, размещенного в папке /templates
 * @param array $data массив данных, передаваемых в шаблон
 *
 * @return string контент для последующего вывода на экран
 */
function include_template($name, $data)
{
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

/**
 * Форматирует число больше 1000 при помощи встроенной функции
 *
 * @param int $price число(цена лота) для форматирования
 *
 * @return string число, округленное до целого, в виде строки формата 1 000 000
 */
function my_number_format($price)
{
    if ($price > 1000) {
        $price = number_format(ceil($price), 0, ',', ' ');
    }
    return "$price";
}

/**
 * Преобразует специальные символы в HTML-сущности при помощи htmlspecialchars
 * Объявлена с целью сокращения кода
 * 
 * @param string $str конвертируемая строка 
 *
 * @return string преобразованная строка
 */
function esc($str)
{
    $text = htmlspecialchars($str);
    return $text;
}

/**
 * Возвращает контент с информацией об ошибке соединения с БД для вывода на экран.
 * 
 * @return string контент для последующего вывода на экран
 */
function show_connection_error()
{
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

/**
 * Возвращает контент с информацией об ошибке выполнения запроса к БД для вывода на экран.
 *
 * @param string|int $errno номер ошибки
 * @param string $error описание ошибки
 * @param array $categories массив с категориями лотов для отображения в меню, если такой был успешно получен из БД
 *
 * @return string контент для последующего вывода на экран
 */
function show_error($errno = null, $error = null, $categories = [])
{
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

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param mysqli $link Ресурс соединения
 * @param string $sql SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = [])
{
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            } elseif (is_string($value)) {
                $type = 's';
            } elseif (is_double($value)) {
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

/**
 * Проверка длинны строки на соответствие заданным параметрам мин/макс длинны 
 *
 * @param string $value валидируемая строка
 * @param int $min минимальная длинна строки
 * @param int $max максимальная длинна строки
 *
 * @return string|null Возвращает сообщение об ошибке, если длинна строки вне установленных лимитов, либо null в случае 
 * корректной длинны строки
 */
function validateLength($value, $min, $max)
{
    if ($value) {
        $len = strlen($value);
        if ($len < $min or $len > $max) {
            return "Значение должно быть от $min до $max символов";
        }
    }
    return null;
}

/**
 * Проверяет полученный id категории на наличие в массиве id существующих категорий
 *
 * @param int|string $id валидируемый id категории
 * @param array $allowed_list массив с id существующих категорий
 *
 * @return string|null Возвращает сообщение об ошибке выбора категории пользователем, либо null в случае корректного id категории
 */
function validateCategory($id, $allowed_list)
{
    if (!in_array($id, $allowed_list) && isset($id)) {
        return "Указана несуществующая категория";
    }
    return null;
}

/**
 * Проверяет, является ли числом введенное в поле значение
 *
 * @param string $value валидируемое значение
 *
 * @return string|null возвращает сообщение об ошибке, либо null в случае корректного значения
 */
function validateType($value)
{
    if (!is_numeric($value)) {
        return "Введите значение в числовом формате";
    }
    return null;
}

/**
 * Проверяет, отправлено ли значение с именем поля $name
 *
 * @param string $name имя поля
 *
 * @return string полученное от пользователя значение в случае успешной валидации, либо null
 */
function getPostVal($name)
{
    return filter_input(INPUT_POST, $name);
}

/**
 * Возвращает информацию о количестве времени, истекшего относительно переданной даты, в человекочитаемом формате
 *
 * @param string $dt_rate дата объявления ставки
 *
 * @return string количество пройденного времени с момента объявления ставки, либо дата объявления ставки, если прошло больше 24
 * часов/или наступил следующий день
 */
function time_passed($dt_rate)
{
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

        $dt_yesterday = date_add($dt_now, date_interval_create_from_date_string('yesterday'));
        
        if (date_format($dt_yesterday, 'Y-m-d') === date_format($dt_rate, 'Y-m-d')) {
            $time_passed = 'Вчера, в ' . date_format($dt_rate, 'H:i');
        } else {
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
        }
        return $time_passed;
    }
    return;
}
