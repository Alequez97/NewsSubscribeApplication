CREATE DATABASE IF NOT EXISTS magebit_task_aleksandrs;

USE magebit_task_aleksandrs;

CREATE TABLE IF NOT EXISTS `subscribers` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `subscription_date` DATETIME NOT NULL,
    PRIMARY KEY (`id`)
);

INSERT INTO `subscribers` (`email`, `subscription_date`)
VALUES ('aleksandrs.vaguscenko@gmail.com', '2021-03-21 15:47');

INSERT INTO `subscribers` (`email`, `subscription_date`)
VALUES ('jevgenijs.orlovs@yahoo.com', '2021-03-22 11:24');

INSERT INTO `subscribers` (`email`, `subscription_date`)
VALUES ('sergejs.belovs@outlook.com', '2021-03-23 18:26');