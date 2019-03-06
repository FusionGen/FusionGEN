CREATE TABLE `password_recovery_key` (
	`recoverykey` VARCHAR(255) NOT NULL,
	`username` VARCHAR(255) NOT NULL,
	`ip` VARCHAR(50) NOT NULL,
	`time` INT(10) NOT NULL
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;
