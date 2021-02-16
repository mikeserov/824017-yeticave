
INSERT INTO categories (name_ru, name_en) VALUES ("Доски и лыжи", "boards"), ("Крепления", "attachment"), ("Ботинки", "boots"), ("Одежда", "clothing"), ("Инструменты", "tools"), ("Разное", "other");
INSERT INTO users (email, name, password, avatar_ref, contacts, lot_id, rate_id)
	VALUES ("iloveMassachusetts@yandex.ru", "Winston", "1234", "img/avatar.jpg", "+79999999999", 2, 1),
		("iloveNew-York@yandex.ru", "Dave", "4321", "img/avatar_2.jpg", "+79998887700", 3, 2);

INSERT INTO lots (name, description, img, start_price, rate_step, category_id, author, dt_end)
	VALUES ("2014 Rossignol District Snowboard", "Супер сноуборд", "img/lot-1.jpg", 10999, 5, 1, 1, '2021-03-01 00:00:00'),
		("DC Ply Mens 2016/2017 Snowboard", "Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив
			снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот
            снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом
            кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется,
            просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла
            равнодушным.", "img/lot-2.jpg", 159999, 5, 1, 2, '2021-03-01 00:00:00'),
		("Крепления Union Contact Pro 2015 года размер L/XL", "Очень подробное описание", "img/lot-3.jpg", 8000, 5, 2, 2, '2021-03-01 00:00:00'),
		("Ботинки для сноуборда DC Mutiny Charocal", "Очень подробное описание", "img/lot-4.jpg", 10999, 5, 3, 1, '2021-03-01 00:00:00'),
		("Куртка для сноуборда DC Mutiny Charocal", "Очень подробное описание", "img/lot-5.jpg", 7500, 5, 4, 1, '2021-03-01 00:00:00'),
		("Маска Oakley Canopy", "Очень подробное описание", "img/lot-6.jpg", 5400, 5, 6, 2, '2021-03-01 00:00:00');

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



INSERT INTO lots (dt_start, name, description, img, start_price, rate_step, category_id, author, dt_end)
	VALUES 
	(NOW(), "Сноуборд №1", "Очень подробное описание", "img/2.jpg", 1500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №2", "Очень подробное описание", "img/3.jpg", 2500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №3", "Очень подробное описание", "img/4.jpg", 4500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №4", "Очень подробное описание", "img/5.jpg", 6500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №5", "Очень подробное описание", "img/6.jpg", 5500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №6", "Очень подробное описание", "img/7.jpg", 8500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №7", "Очень подробное описание", "img/8.jpg", 9500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №8", "Очень подробное описание", "img/9.jpg", 10500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №9", "Очень подробное описание", "img/10.jpg", 11500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №10", "Очень подробное описание", "img/11.jpg", 121500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №11", "Очень подробное описание", "img/12.jpg", 11500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №12", "Очень подробное описание", "img/13.jpg", 21500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №13", "Очень подробное описание", "img/14.jpg", 13500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №14", "Очень подробное описание", "img/15.jpg", 15500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №15", "Очень подробное описание", "img/16.jpg", 15700, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №16", "Очень подробное описание", "img/17.jpg", 15900, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №17", "Очень подробное описание", "img/18.jpg", 71500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №18", "Очень подробное описание", "img/19.jpg", 81500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №19", "Очень подробное описание", "img/20.jpg", 11500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №20", "Очень подробное описание", "img/21.jpg", 21500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №21", "Очень подробное описание", "img/22.jpg", 1500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №22", "Очень подробное описание", "img/23.jpg", 31500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №23", "Очень подробное описание", "img/24.jpg", 11500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №24", "Очень подробное описание", "img/25.jpg", 11500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №25", "Очень подробное описание", "img/26.jpg", 1500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №26", "Очень подробное описание", "img/27.jpg", 21500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №27", "Очень подробное описание", "img/28.jpg", 12500, 100, 1, 12, '2021-03-01 00:00:00'),
	(NOW(), "Сноуборд №28", "Очень подробное описание", "img/1.png", 500, 100, 1, 12, '2021-03-01 00:00:00')