<?php
require_once '../../Models/DataBase.php';
$db = new DataBase();

$createdb = "CREATE DATABASE IF NOT EXISTS `library`;";

$db->startConnection('');
$db->execQuery($createdb);

$queries = [
	"
		CREATE TABLE IF NOT EXISTS `books` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `title` varchar(50) NOT NULL DEFAULT '',
		  `author` varchar(50) NOT NULL DEFAULT '',
		  `edition` int(11) NOT NULL DEFAULT 0,
		  `qtd` int(11) NOT NULL DEFAULT 0,
		  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
		  `updated_at` datetime NOT NULL,
		  PRIMARY KEY (`id`)
		);
	",
	"
		INSERT INTO `books` (`id`, `title`, `author`, `edition`, `qtd`, `created_at`, `updated_at`) VALUES
			(1, 'Homo Deus', 'Yuval Noah Harari', 1, 1, '2020-05-07 18:52:28', '2020-05-07 18:52:28'),
			(3, 'teste', 'teste', 1, 1, '2020-05-08 18:50:16', '2020-05-08 18:50:16');
	",
	"
		CREATE TABLE IF NOT EXISTS `loans` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `user_id` int(11) NOT NULL DEFAULT 0,
		  `book_id` int(11) NOT NULL DEFAULT 0,
		  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
		  `deliver_on` datetime DEFAULT NULL,
		  PRIMARY KEY (`id`) USING BTREE
		);
	",
	"
		INSERT INTO `loans` (`id`, `user_id`, `book_id`, `created_at`, `deliver_on`) VALUES
			(1, 1, 1, '2020-05-09 10:20:21', '2020-05-12 10:20:25');
	",
	"
		CREATE TABLE IF NOT EXISTS `users` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(50) NOT NULL DEFAULT '',
		  `email` varchar(50) NOT NULL DEFAULT '',
		  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
		  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
		  PRIMARY KEY (`id`) USING BTREE
		);
	",
	"
		INSERT INTO `users` (`id`, `name`, `email`, `created_at`, `updated_at`) VALUES
			(1, 'Douglas Magno', 'domagn2@gmail.com', '2020-05-09 10:20:59', '2020-05-09 10:21:00');
	"
];

$db->startConnection();
foreach ($queries as $index => $query) {
	$db->execQuery($query);
}
$db->closeConneciton();
echo "Migration concluída";