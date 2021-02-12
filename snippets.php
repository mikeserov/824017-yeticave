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

/*$sql = 'SELECT * FROM lots '
	. 'WHERE TIMEDIFF(dt_end, NOW()) > 0 AND '
	. 'WHERE MATCH(name, description) AGAINST(?)';*/
/*$sql = "SELECT l.id, dt_start, l.name, start_price, img, c.name_ru AS category, TIME_FORMAT(TIMEDIFF(dt_end, NOW()), '%H:%i') AS remaining_time FROM lots l "
	. "JOIN categories c ON l.category_id = c.id "
	. "WHERE TIMEDIFF(dt_end, NOW()) > 0 AND "
	. "WHERE MATCH(l.name, description) AGAINST(?) "
	. "ORDER BY dt_start DESC "
	. "LIMIT 9 OFFSET '$offset'";
	$stmt = db_get_prepare_stmt($link, $sql, [$search]);
	mysqli_stmt_execute($stmt);
	$res =  mysqli_stmt_get_result($stmt);
	$item_count = mysqli_num_rows($res);*/


	     <ul class="pagination-list">
              <li class="pagination-item pagination-item-prev"><a <?= $cur_page != 1 ? "href='search'" :; ?>>Назад</a></li>
              <?php  foreach($pages as $page): ?>
                <?php $iscur_page = $page == $cur_page ? true : false; ?>
                <li class="pagination-item <?= $iscur_page ? 'pagination-item-active' : ''; ?>"><a <?= $iscur_page ? '' : "href=search.php?page=$page&search=$search; ?>&search=<?= esc($search); ?>" ?>><?= $page; ?></a></li>
              <?php endforeach; ?>
              <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
            <?php endforeach; ?>


            //альтернативный вариант
 <?php if($pages_count > 1): ?> 
          <ul class="pagination-list">
              <?php if ($cur_page == 1):
                     $href = '';
                    else:
                      $href = 'href=search.php?page=' . ($cur_page - 1) . '&search=' . esc($search);
                      ?>
              <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
              
              <?php  foreach($pages as $key => $page): ?>



                <?php 
                      if ()
                if ($page == $cur_page):
                        $classname = 'pagination-item-active';
                        $href = '';
                      else:
                        $classname = '';
                        $href = 'href=search.php?page=' . $page . '&search=' . esc($search);
                      endif; ?>
                <li class="pagination-item <?= $classname; ?>"><a <?= $href; ?>><?= $page; ?></a></li>




              <?php endforeach; ?>

              <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
/* ----------------------------------------------------------------------------------------------------------------------------------*/