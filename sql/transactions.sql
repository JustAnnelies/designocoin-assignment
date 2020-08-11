CREATE TABLE `transactions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id_payer` int(11) NOT NULL,
  `user_id_receiver` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;