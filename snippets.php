	//print('Соединение успешно установленою.<br>');
	//printf('Первоначальная кодировка: %s<br>', mysqli_character_set_name($link));

		//print('Кодировка успешно установлена. Текущая кодировка: '.mysqli_character_set_name($link).'<br>');

		//if (!$res) {
		//echo("Ошибка запроса №". mysqli_errno($link).": ".mysqli_error($link).'<br>');
		//} else {
		//echo('Запрос выполнен успешно.<br>');
		//}

		= mysqli_query($link, 'SELECT l.name, start_price, img_ref, c.name FROM lots l'
			. 'JOIN categories c ON l.category_id = c.id'
			/*WHERE 	 > CURRENT_TIMESTAMP (ПОКА НЕ РЕАЛИЗОВАНО!)
			ORDER BY dt_start DESC   (ПОКА НЕ РЕАЛИЗОВАНО!)*/
			. 'LIMIT 6');


<?php
class User {
	// Хранение опций пароля для совместного использования при хешировании и повторном хешировании:
	const HASH = PASSWORD_DEFAULT;
	const COST = 14;
	// Внутреннее хранение данных о пользователе:
	public $data; 
	// Макет конструктора:
	public function __construct() {
		// Чтение данных из базы данных, сохранение данных в $data:
		$data->passwordHash and $data->username $this->data = new stdClass();
		$this->data->passwordHash = 'dbd014125a4bad51db85f27279f1040a';
	}

	// Макет функциональности сохранения
	public function save() {
		// Сохранение данных из $data обратно в базу данных
	}
	// Разрешение изменения нового пароля:
	public function setPassword($password) {
		$this->data->passwordHash = password_hash($password, self::HASH, ['cost' => self::COST]);
	} 
	// Логика для регистрации входа пользователя:
	public function login($password) {
		// Сначала проверка правильности введенного пользователем пароля:
		echo "Login: ", $this->data->passwordHash, "\n";
		if (password_verify($password, $this->data->passwordHash)) {
			 // Успех - теперь проверка пароля на необходимость повторного хеширования
			if (password_needs_rehash($this->data->passwordHash, self::HASH, ['cost' => self::COST])) {
	 			// Нам нужно повторно создать хеш пароля и сохранить его. Вызов
	 			setPassword $this->setPassword($password);
	 			$this->save(); 
	 		}
			return true;
			// Или сделайте то, что вам нужно, чтобы пометить пользователя как успешно вошедшего в систему.
		}
		return false;
	}
} 