ALTER TABLE `items` ADD `root` VARCHAR( 10 ) NOT NULL ,
ADD `gender` TINYINT NOT NULL ,
ADD `feminine` VARCHAR( 63 ) NOT NULL ,
ADD `plural` VARCHAR( 63 ) NOT NULL ,
ADD `smihut` VARCHAR( 63 ) NOT NULL ,
ADD `abbrev` VARCHAR( 63 ) NOT NULL ,
ADD INDEX ( `root` ) ;
ALTER TABLE `questions` ADD `active` TINYINT NOT NULL ,
ADD INDEX ( `active` ) ;
UPDATE `questions` SET `active` = 1 ;
UPDATE versions SET version=4;
