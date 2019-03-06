SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `store_items`
  ADD COLUMN `command` TEXT AFTER `query_need_character`,
  ADD COLUMN `command_need_character` INT(1) AFTER `command`,
  ADD COLUMN `require_character_offline` INT(1) NOT NULL DEFAULT '0' AFTER `command_need_character`;

ALTER TABLE `menu` ADD COLUMN `permission` VARCHAR(50) AFTER `direct_link`;
ALTER TABLE `account_data` ADD COLUMN `total_votes` INT(11) NOT NULL DEFAULT '0' AFTER `dp`;
ALTER TABLE `account_data` ADD COLUMN `language` VARCHAR(40) NOT NULL DEFAULT 'english' AFTER `nickname`;
ALTER TABLE `sideboxes` ADD COLUMN `permission` VARCHAR(50) AFTER `order`;
ALTER TABLE `comments` ADD COLUMN `is_gm` INT(1) NOT NULL DEFAULT '0' AFTER `content`;
ALTER TABLE `shouts` ADD COLUMN `is_gm` INT(1) NOT NULL DEFAULT '0' AFTER `date`;
ALTER TABLE `pages` ADD COLUMN `permission` VARCHAR(50) AFTER `content`;

ALTER TABLE `sideboxes` CHANGE COLUMN `displayName` `displayName` TEXT(0);
ALTER TABLE `articles` CHANGE COLUMN `headline` `headline` TEXT(0);
ALTER TABLE `pages` CHANGE COLUMN `name` `name` TEXT(0);
ALTER TABLE `menu` CHANGE COLUMN `name` `name` TEXT(0);

UPDATE `menu` SET `permission`=`id` WHERE `link` IN('register', 'login', 'ucp', 'messages', 'admin', 'logout');

-- ----------------------------
--  Table structure for `acl_roles`
-- ----------------------------
DROP TABLE IF EXISTS `acl_roles`;
CREATE TABLE `acl_roles` (
	`name` VARCHAR(50) NOT NULL,
	`module` VARCHAR(50) NOT NULL,
	`description` VARCHAR(255) NULL DEFAULT '',
	PRIMARY KEY (`name`, `module`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;


-- ----------------------------
--  Table structure for `acl_roles_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `acl_roles_permissions`;
CREATE TABLE `acl_roles_permissions` (
	`role_name` VARCHAR(50) NOT NULL,
	`permission_name` VARCHAR(50) NOT NULL,
	`module` VARCHAR(50) NOT NULL,
	`value` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`role_name`, `permission_name`, `module`),
	UNIQUE INDEX `role_name_permission_name` (`role_name`, `permission_name`, `module`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;

-- ----------------------------
--  Table structure for `acl_groups`
-- ----------------------------
DROP TABLE IF EXISTS `acl_groups`;
CREATE TABLE `acl_groups` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`color` VARCHAR(7) NULL DEFAULT '#FFFFFF',
	`description` VARCHAR(255) NOT NULL DEFAULT '',
	PRIMARY KEY (`id`),
	UNIQUE INDEX `name` (`name`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;

-- ----------------------------
--  Records of `acl_groups`
-- ----------------------------
BEGIN;
INSERT INTO `acl_groups` VALUES ('1', 'Guest', '', 'Rank that the user gets when they are not logged in, can be defined in the configs that it is this rank.'), ('2', 'Player', '', 'Default player rank, the normal rank that you get when you are logged in and got no extra special rights.'), ('3', 'GM', '#8e208f', 'The rank GM, they got rights to access the Admin panel but then only with their tools that they need, examples are player support tickets, ...'), ('4', 'Moderator', '#00a3b6', 'They can manage shouts, users, ...'), ('5', 'QA', '#2a9553', 'A QA (= Quality Assurance) checks the quality on the website, ingame and on the other services, they then report this to the developers to get bugs fixed whey they find some.'), ('6', 'Developer', '#d56007', 'A developer'), ('7', 'Administrator', '#dc6200', 'The Administrators take care of the staff'), ('8', 'Owner', '#ae1600', 'This is the owner of the server.');
COMMIT;

DROP TABLE IF EXISTS `acl_account_permissions`;
CREATE TABLE `acl_account_permissions` (
	`account_id` INT(10) UNSIGNED NOT NULL,
	`permission_name` VARCHAR(50) NOT NULL,
	`module` VARCHAR(50) NOT NULL,
	`value` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`account_id`),
	UNIQUE INDEX `account_id_permission_id` (`account_id`, `permission_name`, `module`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;

-- ----------------------------
--  Table structure for `acl_account_roles`
-- ----------------------------
DROP TABLE IF EXISTS `acl_account_roles`;
CREATE TABLE `acl_account_roles` (
	`account_id` INT(11) UNSIGNED NOT NULL,
	`role_name` VARCHAR(50) NOT NULL,
	`module` VARCHAR(50) NOT NULL,
	PRIMARY KEY (`account_id`, `role_name`),
	UNIQUE INDEX `account_id_role_name` (`account_id`, `role_name`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;

-- ----------------------------
--  Table structure for `logs`
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module` varchar(50) NOT NULL,
  `logType` varchar(255) NOT NULL,
  `logMessage` text NOT NULL,
  `user` int(11) unsigned DEFAULT NULL,
  `ip` varchar(45) NOT NULL,
  `custom` text NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `acl_group_roles`
-- ----------------------------
DROP TABLE IF EXISTS `acl_group_roles`;
CREATE TABLE `acl_group_roles` (
	`group_id` INT(10) UNSIGNED NOT NULL,
	`role_name` VARCHAR(50) NOT NULL,
	`module` VARCHAR(50) NOT NULL,
	PRIMARY KEY (`group_id`, `role_name`, `module`),
	UNIQUE INDEX `group_id_role_id` (`group_id`, `role_name`, `module`),
	CONSTRAINT `FK__groups` FOREIGN KEY (`group_id`) REFERENCES `acl_groups` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;

-- ----------------------------
--  Table structure for `acl_account_groups`
-- ----------------------------
DROP TABLE IF EXISTS `acl_account_groups`;
CREATE TABLE `acl_account_groups` (
	`account_id` INT(10) UNSIGNED NOT NULL,
	`group_id` INT(10) UNSIGNED NOT NULL,
	PRIMARY KEY (`account_id`, `group_id`),
	UNIQUE INDEX `account_id_group_id` (`account_id`, `group_id`),
	INDEX `FK__acl_groups` (`group_id`),
	CONSTRAINT `FK__acl_groups` FOREIGN KEY (`group_id`) REFERENCES `acl_groups` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;

-- NEWS TAGS
CREATE TABLE `tag` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `name` (`name`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;

CREATE TABLE `article_tag` (
	`article_id` INT(11) NOT NULL,
	`tag_id` INT(10) NOT NULL,
	PRIMARY KEY (`article_id`, `tag_id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;

BEGIN;
INSERT INTO `acl_group_roles` VALUES ('1', '11', '--MENU--'), ('1', '2', '--MENU--'), ('1', '5', '--MENU--'), ('1', '8', '--MENU--'), ('1', 'use', 'sidebox_language_picker'), ('1', 'view', 'armory'), ('1', 'view', 'changelog'), ('1', 'view', 'character'), ('1', 'view', 'guild'), ('1', 'view', 'login'), ('1', 'view', 'news'), ('1', 'view', 'online'), ('1', 'view', 'password_recovery'), ('1', 'view', 'profile'), ('1', 'view', 'register'), ('2', '100', '--MENU--'), ('2', '101', '--MENU--'), ('2', '13', '--MENU--'), ('2', '19', '--MENU--'), ('2', '6', '--MENU--'), ('2', 'updateAccount', 'ucp'), ('2', 'use', 'messages'), ('2', 'use', 'news'), ('2', 'use', 'sidebox_language_picker'), ('2', 'use', 'sidebox_poll'), ('2', 'use', 'sidebox_shoutbox'), ('2', 'view', 'armory'), ('2', 'view', 'changelog'), ('2', 'view', 'character'), ('2', 'view', 'donate'), ('2', 'view', 'guild'), ('2', 'view', 'login'), ('2', 'view', 'news'), ('2', 'view', 'password_recovery'), ('2', 'view', 'profile'), ('2', 'view', 'register'), ('2', 'view', 'store'), ('2', 'view', 'teleport'), ('2', 'view', 'ucp'), ('2', 'view', 'vote'), ('3', '100', '--MENU--'), ('3', '101', '--MENU--'), ('3', '13', '--MENU--'), ('3', '19', '--MENU--'), ('3', '21', '--MENU--'), ('3', '6', '--MENU--'), ('3', 'manageTickets', 'gm'), ('3', 'moderate', 'news'), ('3', 'moderate', 'sidebox_shoutbox'), ('3', 'updateAccount', 'ucp'), ('3', 'use', 'messages'), ('3', 'use', 'news'), ('3', 'use', 'sidebox_language_picker'), ('3', 'use', 'sidebox_poll'), ('3', 'use', 'sidebox_shoutbox'), ('3', 'view', 'armory'), ('3', 'view', 'changelog'), ('3', 'view', 'character'), ('3', 'view', 'donate'), ('3', 'view', 'guild'), ('3', 'view', 'login'), ('3', 'view', 'news'), ('3', 'view', 'online'), ('3', 'view', 'password_recovery'), ('3', 'view', 'profile'), ('3', 'view', 'register'), ('3', 'view', 'store'), ('3', 'view', 'teleport'), ('3', 'view', 'ucp'), ('3', 'view', 'vote'), ('4', '100', '--MENU--'), ('4', '101', '--MENU--'), ('4', '13', '--MENU--'), ('4', '19', '--MENU--'), ('4', '6', '--MENU--'), ('4', 'moderate', 'news'), ('4', 'moderate', 'sidebox_shoutbox'), ('4', 'updateAccount', 'ucp'), ('4', 'use', 'messages'), ('4', 'use', 'news'), ('4', 'use', 'sidebox_language_picker'), ('4', 'use', 'sidebox_poll'), ('4', 'use', 'sidebox_shoutbox'), ('4', 'view', 'armory'), ('4', 'view', 'changelog'), ('4', 'view', 'donate'), ('4', 'view', 'guild'), ('4', 'view', 'login'), ('4', 'view', 'news'), ('4', 'view', 'online'), ('4', 'view', 'password_recovery'), ('4', 'view', 'profile'), ('4', 'view', 'register'), ('4', 'view', 'store'), ('4', 'view', 'teleport'), ('4', 'view', 'ucp'), ('4', 'view', 'vote'), ('5', '100', '--MENU--'), ('5', '101', '--MENU--'), ('5', '13', '--MENU--'), ('5', '19', '--MENU--'), ('5', '6', '--MENU--'), ('5', 'updateAccount', 'ucp'), ('5', 'use', 'messages'), ('5', 'use', 'news'), ('5', 'use', 'sidebox_language_picker'), ('5', 'use', 'sidebox_poll'), ('5', 'use', 'sidebox_shoutbox'), ('5', 'view', 'armory'), ('5', 'view', 'changelog'), ('5', 'view', 'character'), ('5', 'view', 'donate'), ('5', 'view', 'guild'), ('5', 'view', 'login'), ('5', 'view', 'news'), ('5', 'view', 'online'), ('5', 'view', 'password_recovery'), ('5', 'view', 'profile'), ('5', 'view', 'register'), ('5', 'view', 'store'), ('5', 'view', 'teleport'), ('5', 'view', 'ucp'), ('5', 'view', 'vote'), ('6', '100', '--MENU--'), ('6', '101', '--MENU--'), ('6', '13', '--MENU--'), ('6', '19', '--MENU--'), ('6', '6', '--MENU--'), ('6', 'manage', 'changelog'), ('6', 'manageTickets', 'gm'), ('6', 'moderate', 'sidebox_shoutbox'), ('6', 'updateAccount', 'ucp'), ('6', 'use', 'messages'), ('6', 'use', 'news'), ('6', 'use', 'sidebox_language_picker'), ('6', 'use', 'sidebox_poll'), ('6', 'use', 'sidebox_shoutbox'), ('6', 'view', 'armory'), ('6', 'view', 'changelog'), ('6', 'view', 'character'), ('6', 'view', 'donate'), ('6', 'view', 'guild'), ('6', 'view', 'login'), ('6', 'view', 'news'), ('6', 'view', 'online'), ('6', 'view', 'password_recovery'), ('6', 'view', 'profile'), ('6', 'view', 'register'), ('6', 'view', 'store'), ('6', 'view', 'teleport'), ('6', 'view', 'ucp'), ('6', 'view', 'vote'), ('7', '100', '--MENU--'), ('7', '101', '--MENU--'), ('7', '13', '--MENU--'), ('7', '19', '--MENU--'), ('7', '21', '--MENU--'), ('7', '6', '--MENU--'), ('7', 'administrate', 'donate'), ('7', 'manage', 'changelog'), ('7', 'manage', 'news'), ('7', 'manage', 'page'), ('7', 'manage', 'sidebox_poll'), ('7', 'manage', 'store'), ('7', 'manage', 'teleport'), ('7', 'manage', 'vote'), ('7', 'manageAccounts', 'admin'), ('7', 'manageMenu', 'admin'), ('7', 'manageSideboxes', 'admin'), ('7', 'manageSlider', 'admin'), ('7', 'manageTickets', 'gm'), ('7', 'moderate', 'news'), ('7', 'moderate', 'sidebox_shoutbox'), ('7', 'moderate', 'store'), ('7', 'updateAccount', 'ucp'), ('7', 'use', 'messages'), ('7', 'use', 'news'), ('7', 'use', 'sidebox_language_picker'), ('7', 'use', 'sidebox_poll'), ('7', 'use', 'sidebox_shoutbox'), ('7', 'view', 'admin'), ('7', 'view', 'armory'), ('7', 'view', 'changelog'), ('7', 'view', 'character'), ('7', 'view', 'donate'), ('7', 'view', 'guild'), ('7', 'view', 'login'), ('7', 'view', 'news'), ('7', 'view', 'online'), ('7', 'view', 'password_recovery'), ('7', 'view', 'profile'), ('7', 'view', 'register'), ('7', 'view', 'store'), ('7', 'view', 'teleport'), ('7', 'view', 'ucp'), ('7', 'view', 'vote'), ('7', 'viewLanguage', 'admin'), ('7', 'viewLogs', 'admin'), ('7', 'viewSessions', 'admin'), ('8', '100', '--MENU--'), ('8', '101', '--MENU--'), ('8', '13', '--MENU--'), ('8', '19', '--MENU--'), ('8', '21', '--MENU--'), ('8', '6', '--MENU--'), ('8', 'administrate', 'donate'), ('8', 'editSystemSettings', 'admin'), ('8', 'globalAnnouncement', 'admin'), ('8', 'manage', 'changelog'), ('8', 'manage', 'news'), ('8', 'manage', 'page'), ('8', 'manage', 'sidebox_poll'), ('8', 'manage', 'store'), ('8', 'manage', 'teleport'), ('8', 'manage', 'vote'), ('8', 'manageAccounts', 'admin'), ('8', 'manageCache', 'admin'), ('8', 'manageMenu', 'admin'), ('8', 'manageModules', 'admin'), ('8', 'managePermissions', 'admin'), ('8', 'manageSideboxes', 'admin'), ('8', 'manageSlider', 'admin'), ('8', 'manageTheme', 'admin'), ('8', 'manageTickets', 'gm'), ('8', 'moderate', 'news'), ('8', 'moderate', 'sidebox_shoutbox'), ('8', 'moderate', 'store'), ('8', 'updateAccount', 'ucp'), ('8', 'use', 'messages'), ('8', 'use', 'news'), ('8', 'use', 'sidebox_language_picker'), ('8', 'use', 'sidebox_poll'), ('8', 'use', 'sidebox_shoutbox'), ('8', 'view', 'admin'), ('8', 'view', 'armory'), ('8', 'view', 'changelog'), ('8', 'view', 'character'), ('8', 'view', 'donate'), ('8', 'view', 'guild'), ('8', 'view', 'login'), ('8', 'view', 'news'), ('8', 'view', 'online'), ('8', 'view', 'password_recovery'), ('8', 'view', 'profile'), ('8', 'view', 'register'), ('8', 'view', 'store'), ('8', 'view', 'teleport'), ('8', 'view', 'ucp'), ('8', 'view', 'vote'), ('8', 'viewLanguage', 'admin'), ('8', 'viewLogs', 'admin'), ('8', 'viewSessions', 'admin');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;