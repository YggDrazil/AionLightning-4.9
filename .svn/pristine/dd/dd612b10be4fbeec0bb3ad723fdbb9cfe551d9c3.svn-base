ALTER TABLE `legions`
ADD COLUMN `description`  varchar(255) NOT NULL DEFAULT '' AFTER `world_owner`,
ADD COLUMN `joinType`  int(1) NOT NULL DEFAULT 0 AFTER `description`,
ADD COLUMN `minJoinLevel`  int(3) NOT NULL DEFAULT 0 AFTER `joinType`;

ALTER TABLE `players`
ADD COLUMN `joinRequestLegionId`  int(11) NOT NULL DEFAULT 0 AFTER `rewarded_pass`,
ADD COLUMN `joinRequestState`  enum('NONE','DENIED','ACCEPTED') NOT NULL DEFAULT 'NONE' AFTER `joinRequestLegionId`;

CREATE TABLE `legion_join_requests` (
`legionId`  int(11) NOT NULL DEFAULT 0 ,
`playerId`  int(11) NOT NULL DEFAULT 0 ,
`playerName`  varchar(64) NOT NULL DEFAULT '' ,
`playerClassId`  int(2) NOT NULL DEFAULT 0 ,
`playerRaceId`  int(2) NOT NULL DEFAULT 0 ,
`playerLevel`  int(4) NOT NULL DEFAULT 0 ,
`playerGenderId`  int(2) NOT NULL DEFAULT 0 ,
`joinRequestMsg`  varchar(40) NOT NULL DEFAULT '' ,
`date`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`legionId`, `playerId`)
)
;

