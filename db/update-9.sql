CREATE TABLE `hebtrain`.`tests` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`completed` INT NOT NULL ,
INDEX ( `completed` )
);
ALTER TABLE `items` ADD `active` TINYINT NOT NULL AFTER `russian_comment` ,
ADD `added` DATETIME NULL AFTER `active` ,
ADD `activated` DATETIME NULL AFTER `added`;
ALTER TABLE `items` ADD INDEX ( `added` );
ALTER TABLE `items` ADD INDEX ( `activated` );
ALTER TABLE `items` ADD INDEX ( `active` );
UPDATE items SET active =1;
ALTER TABLE `tests` CHANGE `completed` `completed` DATETIME NOT NULL;
UPDATE versions SET version=9;
