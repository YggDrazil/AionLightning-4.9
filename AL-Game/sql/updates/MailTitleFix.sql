ALTER TABLE `mail`
MODIFY COLUMN `mail_title`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `sender_name`;