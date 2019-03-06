ALTER TABLE `realms` ADD COLUMN `override_hostname_char` VARCHAR(255) AFTER `realm_port`;
ALTER TABLE `realms` ADD COLUMN `override_password_char` VARCHAR(255) AFTER `realm_port`;
ALTER TABLE `realms` ADD COLUMN `override_username_char` VARCHAR(255)  AFTER `realm_port`;
ALTER TABLE `realms` ADD COLUMN `override_port_char` int(11) AFTER `realm_port`;
ALTER TABLE `realms` ADD COLUMN `override_hostname_world` VARCHAR(255) AFTER `realm_port`;
ALTER TABLE `realms` ADD COLUMN `override_password_world` VARCHAR(255) AFTER `realm_port`;
ALTER TABLE `realms` ADD COLUMN `override_username_world` VARCHAR(255) AFTER `realm_port`;
ALTER TABLE `realms` ADD COLUMN `override_port_world` int(11) AFTER `realm_port`;