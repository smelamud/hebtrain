ALTER TABLE `items` ADD `next_test` DATETIME NOT NULL ,
ADD INDEX ( `next_test` ) ;
UPDATE `items` SET `next_test` = now( ) ;
DELETE FROM questions WHERE question=1;
UPDATE versions SET version=3;
