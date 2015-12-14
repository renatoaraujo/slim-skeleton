CREATE DATABASE `phpslim-skelleton` CHARACTER SET UTF8;
USE `phpslim-skelleton`;

CREATE TABLE `phpslim-skelleton`.`sample` (
  `sample_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `sample_text` VARCHAR(100) NOT NULL,
  `sample_number` INT NOT NULL,
  `sample_regstatus` BOOLEAN NOT NULL DEFAULT TRUE,
  `sample_regdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
