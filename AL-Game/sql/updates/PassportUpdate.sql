DROP TABLE IF EXISTS `player_passports`;
CREATE TABLE `player_passports` (
`account_id`  int(11) NOT NULL ,
`passport_id`  int(11) NOT NULL ,
`stamps`  int(11) NOT NULL DEFAULT 0 ,
`last_stamp`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
`rewarded`  tinyint(1) NOT NULL DEFAULT 0 ,
UNIQUE INDEX `account_passport` USING BTREE (`account_id`, `passport_id`) 
)
ENGINE=InnoDB
;