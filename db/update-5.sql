ALTER TABLE `questions` ADD `priority` TINYINT NOT NULL AFTER `step` ,
ADD INDEX ( `priority` ) ;
UPDATE `questions` SET `priority` = if( stage >=3, stage, 2 - stage ) ;
UPDATE versions SET version=5;
