DROP TABLE IF EXISTS `vote_site_callback`;
ALTER TABLE `vote_sites` CHANGE `api_enabled` `callback_enabled` int(1) NOT NULL DEFAULT '0';
UPDATE `vote_sites` SET `vote_url` = REPLACE(`vote_url`, '{account_id}', '{user_id}')