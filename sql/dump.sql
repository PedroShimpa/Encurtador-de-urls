
CREATE DATABASE encurtador;

use encurtador;

CREATE TABLE `urls` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `url` VARCHAR(255) NOT NULL,
    `hash` VARCHAR(5) NOT NULL,
    `criado_em` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `vence_em` DATETIME NOT NULL DEFAULT DATE_ADD(NOW(), INTERVAL 3 DAY),
    PRIMARY KEY (`id`)
);

CREATE INDEX idx_vence_em ON urls (vence_em);
CREATE INDEX idx_hash ON urls (hash);
