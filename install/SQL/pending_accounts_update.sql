ALTER TABLE `pending_accounts` ADD `salt` BINARY(32) NOT NULL AFTER `email`; 
ALTER TABLE `pending_accounts` CHANGE `password` `password` BINARY(32) NOT NULL; 