ALTER TABLE `items` ADD `hard` TINYINT NOT NULL;
UPDATE versions SET version=7;
