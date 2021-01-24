<?php
$is_auth = rand(0, 1);
$user_name = 'Михаил Серов'; // укажите здесь ваше имя
$user_avatar = 'img/user.jpg';

$categories = [
	'boards' => 'Доски и лыжи',
	'attachment' => 'Крепления',
	'boots' => 'Ботинки',
	'clothing' => 'Одежда',
	'tools' => 'Инструменты',
	'other' => 'Разное'
];

$lots = array(
                array('name' => '2014 Rossignol District Snowboard',
                    'category' => 'Доски и лыжи',
                    'price' => 10999,
                    'URL' => 'img/lot-1.jpg'),
                array('name' => 'DC Ply Mens 2016/2017 Snowboard',
                    'category' => 'Доски и лыжи',
                    'price' => 159999,
                    'URL' => 'img/lot-2.jpg'),
                array('name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
                    'category' => 'Крепления',
                    'price' => 8000,
                    'URL' => 'img/lot-3.jpg'),
                array('name' => 'Ботинки для сноуборда DC Mutiny Charocal',
                    'category' => 'Ботинки',
                    'price' => 10999,
                    'URL' => 'img/lot-4.jpg'),
                array('name' => 'Куртка для сноуборда DC Mutiny Charocal',
                    'category' => 'Одежда',
                    'price' => 7500,
                    'URL' => 'img/lot-5.jpg'),
                array('name' => 'Маска Oakley Canopy',
                    'category' => 'Разное',
                    'price' => 5400,
                    'URL' => 'img/lot-6.jpg')
            );
$title = 'Главная';