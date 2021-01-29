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