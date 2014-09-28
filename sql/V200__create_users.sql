CREATE TABLE IF NOT EXISTS `users` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `age` INT NOT NULL,
    `gender` VARCHAR(50) NOT NULL,
    `phone_number` VARCHAR(50) NOT NULL,
    `address` TEXT DEFAULT NULL,
    `body` TEXT DEFAULT NULL,
    `photo` varchar(255) DEFAULT NULL,
    `photo_dir` varchar(255) DEFAULT NULL,
    `message_url` varchar(255) DEFAULT NULL,
    -- `playlist_id` varchar(255) DEFAULT NULL,
    `created` DATETIME DEFAULT NULL,
    `modified` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`) 
);
