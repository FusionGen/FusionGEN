ALTER TABLE `paypal_logs`
ADD COLUMN `pending_reason` TEXT(0) AFTER `error`,
ADD COLUMN `converted_price` INT(11) NOT NULL DEFAULT '0' AFTER `timestamp`;