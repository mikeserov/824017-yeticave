
INSERT INTO categories (name_ru, name_en) VALUES ("Доски и лыжи", "boards"), ("Крепления", "attachment"), ("Ботинки", "boots"), ("Одежда", "clothing"), ("Инструменты", "tools"), ("Разное", "other");
INSERT INTO users (email, name, password, avatar_ref, contacts, lot_id, rate_id)
	VALUES ("iloveMassachusetts@yandex.ru", "Winston", "1234", "img/avatar.jpg", "+79999999999", 2, 1),
		("iloveNew-York@yandex.ru", "Dave", "4321", "img/avatar_2.jpg", "+79998887700", 3, 2);

INSERT INTO lots (name, description, img_ref, start_price, rate_step, category_id, author)
	VALUES ("2014 Rossignol District Snowboard", "Супер сноуборд", "img/lot-1.jpg", 10999, 5, 1, 1),
		("DC Ply Mens 2016/2017 Snowboard", "Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив
			снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот
            снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом
            кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется,
            просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла
            равнодушным.", "img/lot-2.jpg", 159999, 5, 1, 2),
		("Крепления Union Contact Pro 2015 года размер L/XL", "Очень подробное описание", "img/lot-3.jpg", 8000, 5, 2, 2),
		("Ботинки для сноуборда DC Mutiny Charocal", "Очень подробное описание", "img/lot-4.jpg", 10999, 5, 3, 1),
		("Куртка для сноуборда DC Mutiny Charocal", "Очень подробное описание", "img/lot-5.jpg", 7500, 5, 4, 1),
		("Маска Oakley Canopy", "Очень подробное описание", "img/lot-6.jpg", 5400, 5, 6, 2);

INSERT INTO rates (rate, user_id, lot_id)
	VALUES (190000, 1, 2),
		(240000, 2, 2);



SELECT * FROM categories;

/*получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, название категории;*/
SELECT l.name, start_price, img_ref, c.name_ru FROM lots l
 	JOIN categories c
 		ON l.category_id = c.id
	/*WHERE 	 > CURRENT_TIMESTAMP
	ORDER BY dt_start DESC   (ПОКА НЕ РЕАЛИЗОВАНО!)*/
	LIMIT 3;

/*показать лот по его id. Получите также название категории, к которой принадлежит лот*/
SELECT l.name, c.name FROM lots
	JOIN categories c
		ON l.category_id = c.id
	WHERE l.id = 6;

/*обновить название лота по его идентификатору*/
UPDATE lots SET name = "Маска Oakley Canopy Black"
	WHERE id = 6;

/*получить список самых свежих ставок для лота по его идентификатору*/
SELECT rate FROM rates
	JOIN lots ON lots.id = rates.lot_id
	WHERE lots.id = 2
	ORDER BY dt_rate_declare DESC
	LIMIT 2;