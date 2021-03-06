CREATE DATABASE yeti_cave
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE UTF8_GENERAL_CI;

USE yeti_cave;

CREATE TABLE categories (
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	name_ru VARCHAR(30) UNIQUE,
	name_en VARCHAR(30) UNIQUE 
);

CREATE TABLE lots (
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	dt_start TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	name VARCHAR(128),
	description TEXT(128),
	img TEXT(128),
	start_price DECIMAL,
	dt_end TIMESTAMP,
	rate_step DECIMAL,
	category_id INTEGER REFERENCES categories(id),
	author INT REFERENCES users(id),
	winner INT REFERENCES users(id)
);

CREATE TABLE rates (
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	dt_rate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	rate DECIMAL,
	user_id INT REFERENCES users(id),
	lot_id INTEGER REFERENCES lots(id)
);

CREATE TABLE users (
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	email VARCHAR(128),
	name VARCHAR(128),
	password VARCHAR(64),
	avatar_ref TEXT,
	contacts TEXT,
	lot_id INT REFERENCES lots(id),
	rate_id INT REFERENCES rates(id)
);

CREATE UNIQUE INDEX lot_id ON lots(id);
CREATE UNIQUE INDEX user_id ON users(id);
CREATE UNIQUE INDEX rate_id ON rates(id);

CREATE INDEX lot_description ON lots(description(128));
CREATE INDEX lot_name ON lots(name);


CREATE FULLTEXT INDEX name_description ON lots (name, description);
