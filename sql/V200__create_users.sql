CREATE TABLE IF NOT EXISTS `users` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `facebook_num` VARCHAR(50) NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    -- `age` INT NOT NULL,
    `gender` VARCHAR(50) NOT NULL,
    `phone_number` VARCHAR(50) NULL,
    `photo` varchar(255) DEFAULT NULL,
    `photo_dir` varchar(255) DEFAULT NULL,
    `message_url` varchar(255) DEFAULT NULL,
    `created` DATETIME DEFAULT NULL,
    `modified` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`) 
);
