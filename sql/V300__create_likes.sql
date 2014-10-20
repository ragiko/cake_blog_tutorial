CREATE TABLE IF NOT EXISTS `likes` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `send_user_id` VARCHAR(50) NOT NULL,
    `receive_user_id` VARCHAR(50) NOT NULL,
    `message_url` varchar(255) DEFAULT NULL,
    `created` DATETIME DEFAULT NULL,
    `modified` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`) 
);
