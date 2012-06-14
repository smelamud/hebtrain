INSERT INTO `questions` ( `item_id` , `question` , `stage` , `step` , `priority` , `next_test` , `active` )
SELECT `item_id` , 1, 0, 0, 2, now( ) , 0
FROM `questions`
WHERE `question` =2;
INSERT INTO `questions` ( `item_id` , `question` , `stage` , `step` , `priority` , `next_test` , `active` )
SELECT `item_id` , 5, 0, 0, 2, now( ) , 0
FROM `questions`
WHERE `question` =2;
UPDATE versions SET version=8;
